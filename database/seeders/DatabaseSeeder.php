<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Brand;
use App\Models\Car;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat Akun Admin Utama
        User::create([
            'name' => 'Admin Sinar Mandiri',
            'email' => 'admin@sinarmandiri.com',
            'password' => Hash::make('password123'), // Passwordnya: password123
        ]);

        // 2. Membuat Data Dummy Merek (Brands)
        $brandToyota = Brand::create([
            'name' => 'Toyota',
            'slug' => 'toyota'
        ]);

        $brandHonda = Brand::create([
            'name' => 'Honda',
            'slug' => 'honda'
        ]);

        // 3. Membuat Data Dummy Mobil (Cars)
        Car::create([
            'brand_id' => $brandToyota->id,
            'name' => 'Toyota Avanza Veloz 2023',
            'slug' => Str::slug('Toyota Avanza Veloz 2023' . '-' . Str::random(5)),
            'description' => 'Mobil keluarga nyaman dengan fitur keselamatan canggih (TSS). Kondisi sangat mulus seperti baru.',
            'price' => 250000000,
            'year' => 2023,
            'mileage' => 15000,
            'transmission' => 'Automatic',
            'fuel_type' => 'Bensin',
            'status' => 'Available'
        ]);

        Car::create([
            'brand_id' => $brandHonda->id,
            'name' => 'Honda Civic RS 2022',
            'slug' => Str::slug('Honda Civic RS 2022' . '-' . Str::random(5)),
            'description' => 'Sedan sporty dengan performa turbo mesin 1.5L. Pajak panjang dan terawat.',
            'price' => 480000000,
            'year' => 2022,
            'mileage' => 22000,
            'transmission' => 'Automatic',
            'fuel_type' => 'Bensin',
            'status' => 'Available'
        ]);
    }
}