<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;

    // Champs modifiables via mass assignment
    protected $fillable = [
        'name',
        'type',
        'price',
        'duration',
        'age',
        'description',
        'images', // stocké en JSON
    ];

    // Cast JSON pour images
    protected $casts = [
        'images' => 'array',
    ];

    // Accessors à ajouter automatiquement dans le JSON renvoyé par l'API
    protected $appends = ['first_image_url'];

    /**
     * Retourne l'URL complète de la première image
     */
    public function getFirstImageUrlAttribute(): ?string
    {
        if (is_array($this->images) && count($this->images) > 0) {
            // Génère le lien complet vers le storage public
            return asset('storage/' . $this->images[0]);
        }
        return null;
    }

    /**
     * Relation avec les sessions
     */
    public function workshopSessions()
    {
        return $this->hasMany(WorkshopSession::class);
    }
}
