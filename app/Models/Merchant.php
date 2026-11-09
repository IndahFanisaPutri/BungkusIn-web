<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merchant extends Model
{
    protected $fillable = [
        'user_id', 'store_name', 'address', 'latitude', 'longitude',
        'open_pickup_time', 'close_pickup_time', 'status_verification',
    ];

    protected $casts = [
        'latitude'  => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Tambahan untuk fitur payout di minggu berikutnya
    public function payouts(): HasMany
    {
        return $this->hasMany(Payout::class);
    }
}
