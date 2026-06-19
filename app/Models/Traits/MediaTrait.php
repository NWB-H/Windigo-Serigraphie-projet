<?php

namespace App\Models\Traits;

use App\Models\Dto\Image;
use App\Models\Exceptions\UndefineCollectionName;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait MediaTrait
{
    use InteractsWithMedia;

    abstract protected function collectionName(): string;

    protected static function bootMediaTrait(): void
    {
        static::retrieved(function (self $model) {
            $model->append(['images', 'highlighted_image']);
        });
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
                $this->getMedia($this->collectionName())->all()
            )
        );
    }

    public function resetHighlightedImages(): void
    {
        $this->getMedia($this->collectionName())->each(function (Media $media) {
            $media->setCustomProperty('isHighlighted', false)->save(); // Non optimisé, il faudrait update la collection d'un coup
        });
    }

    public function highlightedImage(): Attribute
    {
        return Attribute::make(
            get: function () {
                $media = $this->getFirstMedia($this->collectionName(), ['isHighlighted' => true]);

                if (null === $media) {
                    return null;
                }

                return new Image(
                    id: $media->id,
                    url: $media->getUrl(),
                    isHighlighted: true,
                );
            },
        );
    }
}
