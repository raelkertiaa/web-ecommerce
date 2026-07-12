<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Produk Unggulan (Data Asli untuk Slider)
        $products = [
            [
                'name' => 'Gundam Aerial HG',
                'price' => 280000,
                'stock' => 5,
                'image' => 'https://placehold.co/600x400?text=Gundam+Aerial',
            ],
            [
                'name' => 'Miku Nakano Figure',
                'price' => 450000,
                'stock' => 3,
                'image' => 'https://placehold.co/600x400?text=Miku+Nakano',
            ],
            [
                'name' => 'One Piece Luffy Gear 5',
                'price' => 1500000,
                'stock' => 2,
                'image' => 'https://placehold.co/600x400?text=Luffy+G5',
            ],
        ];

        // Masukkan produk unggulan ke database
        foreach ($products as $p) {
            Product::create([
                'name' => $p['name'],
                'description' => 'Deskripsi keren untuk '.$p['name'],
                'price' => $p['price'],
                'stock' => $p['stock'],
                'image' => $p['image'],
            ]);
        }

    }
}
