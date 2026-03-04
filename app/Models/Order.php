<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    use HasFactory;
    protected $fillable = [
        'user_id',
        'total',
        'status'
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

    public function updateStatus(string $newStatus): bool
    {
        $allowedStatuses = ['pending', 'paid', 'shipped', 'cancelled'];

        if (!in_array($newStatus, $allowedStatuses)) {
            throw new \InvalidArgumentException("Statut invalide : $newStatus");
        }

        $this->status = $newStatus;
        return $this->save();
    }
}
