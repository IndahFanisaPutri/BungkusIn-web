<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'merchant_id', 'name', 'category', 'image',
        'original_price', 'discount_price', 'stock',
    ];

    protected $casts = [
        'original_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock'          => 'integer',
    ];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
}
