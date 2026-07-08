<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'addresses',
        'reset_password_token',
        'reset_password_token_expires_at',
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
     * Résout le "me" pour les routes
     */
    public function resolveRouteBinding($value, $field = null): ?self
    {
        return $value === 'me' ? Auth::user() : parent::resolveRouteBinding($value, $field);
    }

    // ---------------------
    // RELATIONS
    // ---------------------

    /**
     * @return HasMany<Address>
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

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

    public function reservationSessions()
    {
        return $this->hasMany(WorkshopSession::class);
    }
}
