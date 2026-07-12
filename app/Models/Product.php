<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 1. Agar bisa diinput dari Admin Panel (Mass Assignment)
    protected $fillable = [
        'name',
        'price',
        'stock',
        'category',
        'description',
        'image',
    ];

    // 2. Agar detail produk bisa mengambil data ulasan
    public function reviews()
    {
        // Hubungkan ke Model Review (Pastikan Model Review sudah ada)
        return $this->hasMany(Review::class);
    }
}
