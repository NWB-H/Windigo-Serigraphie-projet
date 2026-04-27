<?php

namespace App\Models;

use App\Models\Dto\Image;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[UseFactory(ProductFactory::class)]
class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'stock',
        'description',
        'archived',
        'option_id',
        'category_id',
        'picture',
    ];

    // --- pour récupérer l'URL complète de l'image ---
    protected $appends = [
        'picture_url',
        'images',
    ];

    public function getPictureUrlAttribute(): ?string
    {
        return $this->getFirstMedia('products', ['isHighlighted' => true])?->getUrl();
    }

    public function images(): Attribute
    {
        return Attribute::make(
            get: fn () => array_map(
                fn (Media $image) => new Image(
                    id: $image->id,
                    url: $image->getUrl(),
                    isHighlighted: $image->getCustomProperty('isHighlighted', false),
                ),
                $this->getMedia('products')->all()
            )
        );
    }

    public function resetHighlightedImages(): void
    {
        $this->getMedia('products')->each(function (Media $media) {
            $media->setCustomProperty('isHighlighted', false)->save(); // Non optimisé, il faudrait update la collection d'un coup
        });
    }

    // --- Recherche filtrée ---
    public static function search(
        ?string $name = null,
        ?string $minPrice = null,
        ?string $maxPrice = null,
        ?string $option = null,
        ?string $category = null,
        ?int $page = null,
        ?int $limit = null
    ) {
        $query = self::query();

        if ($name) {
            $query->where('name', 'like', "%$name%");
        }

        if (is_numeric($minPrice)) {
            $query->where('price', '>=', $minPrice);
        }

        if (is_numeric($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }

        if (is_numeric($option)) {
            $query->where('option_id', $option);
        }

        if (is_numeric($category)) {
            $query->where('category_id', $category);
        }

        $totalResults = $query->count();
        $query->orderBy('id', 'ASC');

        if ($page && $limit) {
            $query->skip(($page - 1) * $limit)->take($limit);
        }

        return [
            'products' => $query->get(),
            'totalResults' => $totalResults,
        ];
    }

    // --- Relations ---
    public function cartUsers()
    {
        return $this->hasMany(User::class);
    }

    public function customerReviews()
    {
        return $this->hasMany(CustomerReview::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')
            ->withPivot('quantity', 'price');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
