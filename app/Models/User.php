<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'phone', 'role', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // Cast 'hashed' (Laravel 10+/11): password otomatis di-hash saat di-set
            'password' => 'hashed',
        ];
    }

    // Satu user dengan role merchant memiliki satu profil toko
    public function merchant(): HasOne
    {
        return $this->hasOne(Merchant::class);
    }

    // Satu user (customer) bisa punya banyak pesanan -> FK: orders.customer_id
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    // Helper praktis untuk pengecekan role
    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }
}
