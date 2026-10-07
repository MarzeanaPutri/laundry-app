<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $outlet = Outlet::create([
            'name'    => 'Laundry Bersih Cabang Utama',
            'address' => 'Jl. Merdeka No. 1, Jakarta',
            'phone'   => '021-12345678',
            'email'   => 'utama@laundrybersih.com',
        ]);

        User::create(['name' => 'Admin Utama', 'email' => 'admin@laundry.com', 'password' => Hash::make('password'), 'role' => 'admin', 'outlet_id' => $outlet->id]);

        $products = [
            ['name' => 'Cuci Kiloan Reguler', 'type' => 'kiloan',  'price' => 7000,  'unit' => 'kg',  'description' => 'Cuci + kering, estimasi 2 hari'],
            ['name' => 'Cuci Kiloan Express',  'type' => 'express', 'price' => 12000, 'unit' => 'kg',  'description' => 'Cuci + kering, selesai hari ini'],
            ['name' => 'Cuci Setrika Reguler', 'type' => 'kiloan',  'price' => 10000, 'unit' => 'kg',  'description' => 'Cuci + kering + setrika'],
            ['name' => 'Cuci Setrika Express',  'type' => 'express', 'price' => 15000, 'unit' => 'kg',  'description' => 'Cuci + setrika, selesai hari ini'],
            ['name' => 'Cuci Sepatu',           'type' => 'satuan',  'price' => 25000, 'unit' => 'pcs', 'description' => 'Per pasang sepatu'],
            ['name' => 'Cuci Tas',              'type' => 'satuan',  'price' => 30000, 'unit' => 'pcs', 'description' => 'Per buah tas'],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}
