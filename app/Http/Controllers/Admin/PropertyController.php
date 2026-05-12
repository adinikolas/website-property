<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function index()
    {
        // Gunakan withCount('nama_fungsi_relasi_di_model')
        // Laravel otomatis akan membuat variabel baru bernama 'property_types_count'
        $properties = Property::withCount('propertyTypes')->latest()->get();

        return view('admin.property.index', compact('properties'));
    }

    public function create()
    {
        return view('admin.property.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi pastikan image "nullable"
        $request->validate([
            'name_property' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:10240' // WAJIB ADA NULLABLE
        ]);

        $data = $request->except(['_token']);

        // 2. Jika ada file gambar, simpan
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('properties', 'public');
        }

        Property::create($data);

        return redirect()->route('property.index')->with('success', 'Data Property berhasil ditambahkan!');
    }

    public function show($id)
    {
        $property = Property::with('propertyTypes')->findOrFail($id);
        return view('admin.property.detail', compact('property'));
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);
        return view('admin.property.edit', compact('property'));
    }

    public function update(Request $request, string $id)
    {
        // 1. Validasi pastikan image "nullable"
        $request->validate([
            'name_property' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:10240' // WAJIB ADA NULLABLE
        ]);

        $property = Property::findOrFail($id);
        $data = $request->except(['_token', '_method', 'remove_image']);

        // 2. Cek jika user klik tombol Hapus Gambar (dari field hidden remove_image)
        if ($request->input('remove_image') == "1") {
            if ($property->image) {
                Storage::disk('public')->delete($property->image);
            }
            $data['image'] = null;
        }
        // 3. Cek jika user upload gambar baru
        elseif ($request->hasFile('image')) {
            if ($property->image) {
                Storage::disk('public')->delete($property->image);
            }
            $data['image'] = $request->file('image')->store('properties', 'public');
        }

        $property->update($data);

        return redirect()->route('property.index')->with('success', 'Data Property berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $property = Property::findOrFail($id);

        // 1. Cek apakah property memiliki gambar, jika ADA baru dihapus filenya
        if ($property->image) {
            Storage::disk('public')->delete($property->image);
        }

        // 2. Hapus data dari database
        $property->delete();

        return redirect()->route('property.index')->with('success', 'Data Property berhasil dihapus!');
    }
}
