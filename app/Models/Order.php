<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = true;

    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'payment_provider_id',
        'payment_provider_name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('quantity', 'price');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
