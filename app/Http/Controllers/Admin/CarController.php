<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Brand;
use App\Models\CarlImage; // Disesuaikan
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::with('brand')->latest()->get();
        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        $brands = Brand::orderBy('name', 'asc')->get();
        return view('admin.cars.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'mileage' => 'required|integer',
            'transmission' => 'required|in:Manual,Automatic',
            'fuel_type' => 'required|string',
            'status' => 'required|in:Available,Sold',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $car = Car::create([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . Str::random(5)),
            'description' => $request->description,
            'price' => $request->price,
            'year' => $request->year,
            'mileage' => $request->mileage,
            'transmission' => $request->transmission,
            'fuel_type' => $request->fuel_type,
            'status' => $request->status,
        ]);

        // Simpan Foto Mobil menggunakan CarlImage
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $path = $file->store('cars', 'public');
                CarlImage::create([
                    'car_id' => $car->id,
                    'image_path' => $path,
                    'is_primary' => $key == 0 ? true : false,
                ]);
            }
        }

        return redirect()->route('admin.cars.index')->with('success', 'Data mobil berhasil ditambahkan!');
    }

    public function edit(Car $car)
    {
        $brands = Brand::orderBy('name', 'asc')->get();
        return view('admin.cars.edit', compact('car', 'brands'));
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'year' => 'required|integer',
            'mileage' => 'required|integer',
            'transmission' => 'required|in:Manual,Automatic',
            'fuel_type' => 'required|string',
            'status' => 'required|in:Available,Sold',
        ]);

        $car->update([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'year' => $request->year,
            'mileage' => $request->mileage,
            'transmission' => $request->transmission,
            'fuel_type' => $request->fuel_type,
            'status' => $request->status,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('cars', 'public');
                CarlImage::create([
                    'car_id' => $car->id,
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('admin.cars.index')->with('success', 'Data mobil berhasil diperbarui!');
    }

    public function destroy(Car $car)
    {
        foreach ($car->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }
        
        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Data mobil dan foto berhasil dihapus!');
    }
}