<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * Les attributs assignables en masse
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
        'billing_address',
        'delivery_address',
    ];

    /**
     * Les attributs cachés pour la sérialisation
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les casts automatiques
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => RoleEnum::class, // <-- cast enum
    ];

    /**
     * Vérifie si l'utilisateur est admin
     */
    public function isAdmin(): bool
    {
        return $this->role === RoleEnum::ROLE_ADMIN;
    }

    /**
     * Résout le "me" pour les routes
     */
    public function resolveRouteBinding($value, $field = null): ?self
    {
        return $value === 'me' ? Auth::user() : parent::resolveRouteBinding($value, $field);
    }

    // ---------------------
    // RELATIONS
    // ---------------------

    public function cartProducts()
    {
        return $this->hasMany(Product::class);
    }

    public function customerReviews()
    {
        return $this->hasMany(CustomerReview::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_id');
    }

    public function deliveryAddress()
    {
        return $this->belongsTo(City::class, 'delivery_address');
    }

    public function billingAddress()
    {
        return $this->belongsTo(City::class, 'billing_address');
    }

    public function reservationSessions()
    {
        return $this->hasMany(WorkshopSession::class);
    }
}
