<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarlImage extends Model
{
    use HasFactory;

    // Baris ini sangat penting untuk menyambungkan file CarlImage.php ke tabel car_images
    protected $table = 'car_images';

    protected $fillable = ['car_id', 'image_path', 'is_primary'];
}