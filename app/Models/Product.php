<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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
    protected $appends = ['picture_url'];

    public function getPictureUrlAttribute(): ?string
    {
        return $this->picture ? asset('storage/' . $this->picture) : null;
    }

    // --- Recherche filtrée ---
    public static function search(
        string $name = null,
        string $minPrice = null,
        string $maxPrice = null,
        string $option = null,
        string $category = null,
        int $page = null,
        int $limit = null
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
