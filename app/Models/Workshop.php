<?php

namespace App\Models;

use App\Models\Dto\Image;
use App\Models\Traits\MediaTrait;
use Database\Factories\WorkshopFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[UseFactory(WorkshopFactory::class)]
class Workshop extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, MediaTrait;

    protected $fillable = [
        'name',
        'type',
        'price',
        'duration',
        'age',
        'description',
    ];

    protected function collectionName(): string
    {
        return 'workshops';
    }

    /**
     * Relation avec les sessions
     */
    public function workshopSessions()
    {
        return $this->hasMany(WorkshopSession::class);
    }
}
