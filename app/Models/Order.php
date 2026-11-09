<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_code', 'customer_id', 'merchant_id', 'total_amount',
        'payment_status', 'fulfillment_status', 'qr_code_path',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Nama relasi "customer" agar lebih deskriptif; FK eksplisit karena bukan user_id
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
