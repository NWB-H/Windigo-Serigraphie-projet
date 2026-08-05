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

    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
        'addresses',
        'reset_password_token',
        'reset_password_token_expires_at',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => RoleEnum::class, // <-- cast enum
    ];

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

    public function hasRole(RoleEnum $role): bool
    {
        return $this->role === $role;
    }
}
