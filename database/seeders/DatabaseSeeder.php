<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Password plaintext 'password' di-hash otomatis oleh cast 'hashed' di model User.

        // 1. Admin
        User::updateOrCreate(['email' => 'admin@bungkusin.com'], [
            'name'     => 'Admin BungkusIn',
            'phone'    => '081200000001',
            'role'     => 'admin',
            'password' => 'password',
        ]);

        // 2. Merchant + data toko
        $merchantUser = User::updateOrCreate(['email' => 'merchant@bungkusin.com'], [
            'name'     => 'Budi Pemilik Toko',
            'phone'    => '081200000002',
            'role'     => 'merchant',
            'password' => 'password',
        ]);

        $merchant = Merchant::updateOrCreate(['user_id' => $merchantUser->id], [
            'store_name'          => 'Roti Bahagia Bakery',
            'address'             => 'Jl. Contoh No. 10, Padang, Sumatera Barat',
            'latitude'            => -0.9470830,
            'longitude'           => 100.4171780,
            'open_pickup_time'    => '18:00:00',
            'close_pickup_time'   => '21:00:00',
            'status_verification' => 'approved',
        ]);

        // (Opsional) contoh produk untuk persiapan katalog
        Product::updateOrCreate(
            ['merchant_id' => $merchant->id, 'name' => 'Paket Roti Sisa Hari Ini'],
            ['category' => 'Roti & Kue', 'original_price' => 60000, 'discount_price' => 25000, 'stock' => 10]
        );

        // 3. Customer
        User::updateOrCreate(['email' => 'customer@bungkusin.com'], [
            'name'     => 'Citra Customer',
            'phone'    => '081200000003',
            'role'     => 'customer',
            'password' => 'password',
        ]);
    }
}
