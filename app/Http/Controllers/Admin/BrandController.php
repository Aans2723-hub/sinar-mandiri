<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->get();
        // Mengarahkan ke file tampilan: resources/views/admin/brands/index.blade.php
        return view('admin.brands.index', compact('brands')); 
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name'
        ]);

        Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Merek berhasil ditambahkan!');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id
        ]);

        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'Merek berhasil diperbarui!');
    }

    public function destroy(Brand $brand)
    {
        // Jika merek dihapus, otomatis mobil dengan merek ini ikut terhapus karena aturan cascade di database
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Merek berhasil dihapus!');
    }
}