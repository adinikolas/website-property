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
        $request->validate([
            'name_property' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Diubah jadi nullable
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('properties', 'public');
        }

        Property::create([
            'name_property' => $request->name_property,
            'description' => $request->description,
            'image' => $path,
        ]);

        return redirect()->route('property.index')->with('success', 'Property berhasil ditambahkan');
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

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $request->validate([
            'name_property' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name_property' => $request->name_property,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($property->image);
            // Upload baru
            $data['image'] = $request->file('image')->store('properties', 'public');
        }

        $property->update($data);

        return redirect()->route('property.index')->with('success', 'Property berhasil diupdate');
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        Storage::disk('public')->delete($property->image);
        $property->delete();

        return redirect()->route('property.index')->with('success', 'Property berhasil dihapus');
    }
}
