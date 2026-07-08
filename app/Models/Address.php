<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Address extends Model
{
    protected $fillable = [
        'name',
        'address_line1',
        'address_line2',
        'user_id',
    ];

    protected $with = ['city'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
