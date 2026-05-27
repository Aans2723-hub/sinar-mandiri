<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ['brand_id', 'name', 'slug', 'description', 'price', 'year', 'mileage', 'transmission', 'fuel_type', 'status'];

    // Relasi: Mobil dimiliki oleh 1 Merek
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Relasi: 1 Mobil punya banyak Gambar (Disesuaikan dengan file CarlImage.php Anda)
    public function images()
    {
        return $this->hasMany(CarlImage::class);
    }
}