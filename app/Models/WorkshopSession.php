<?php

namespace App\Models;

use Database\Factories\WorkshopSessionFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[UseFactory(WorkshopSessionFactory::class)]
class WorkshopSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_number',
        'capacity',
        'workshop_id',
        'date',
        'avalaible_capacity',
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d H:i',
    ];

    protected $appends = ['remaining_places'];

    protected $hidden = ['reservations', 'reservations_count'];

    public function getRemainingPlacesAttribute(): int
    {
        return $this->capacity - ($this->reservations_count ?? $this->reservations()->count());
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'workshop_session_id');
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, Reservation::class, 'workshop_session_id', 'id', 'id', 'user_id');
    }
}
