<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyType;
use App\Models\PropertyTypeImage;
use Illuminate\Support\Facades\Storage;

class PropertyTypeImageController extends Controller
{
    // 1. Halaman Data Gambar (Hanya menampilkan Type Rumah yang memiliki gambar)
    public function index()
    {
        // Mengambil Type Rumah yang memiliki setidaknya 1 gambar
        $typesWithImages = PropertyType::whereHas('images')->with(['property', 'images'])->get();
        return view('admin.property_type_image.index', compact('typesWithImages'));
    }

    // 2. Halaman Tambah Gambar
    public function create(Request $request)
    {
        // Jika ada property_type_id dari URL, kita jadikan selected
        $selectedType = $request->query('type_id');
        $propertyTypes = PropertyType::with('property')->get();
        return view('admin.property_type_image.create', compact('propertyTypes', 'selectedType'));
    }

    // 3. Proses Simpan Gambar Baru
    public function store(Request $request)
    {
        $request->validate([
            'property_type_id' => 'required|exists:property_types,id',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:10240' // Max 10MB per gambar
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('property_type_images', 'public');
                PropertyTypeImage::create([
                    'property_type_id' => $request->property_type_id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('property_type_image.index')->with('success', 'Galeri Gambar berhasil ditambahkan!');
    }

    // 4. Halaman Detail Gambar
    public function show($id)
    {
        // $id di sini adalah ID dari PropertyType
        $type = PropertyType::with(['property', 'images'])->findOrFail($id);
        return view('admin.property_type_image.detail', compact('type'));
    }

    // 5. Halaman Edit Gambar
    public function edit($id)
    {
        // $id di sini adalah ID dari PropertyType
        $type = PropertyType::with(['property', 'images'])->findOrFail($id);
        $propertyTypes = PropertyType::with('property')->get();
        return view('admin.property_type_image.edit', compact('type', 'propertyTypes'));
    }

    // 6. Proses Update (Tambah gambar baru & Hapus gambar lama terpilih)
    public function update(Request $request, $id)
    {
        $request->validate([
            'property_type_id' => 'required|exists:property_types,id',
            'new_images.*' => 'image|mimes:jpeg,png,jpg|max:10240'
        ]);

        // Jika ada gambar lama yang dihapus
        if ($request->has('deleted_images')) {
            $imagesToDelete = PropertyTypeImage::whereIn('id', $request->deleted_images)->get();
            foreach ($imagesToDelete as $img) {
                if (Storage::disk('public')->exists($img->image_path)) {
                    Storage::disk('public')->delete($img->image_path);
                }
                $img->delete();
            }
        }

        // Jika ada gambar baru yang ditambahkan
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $file) {
                $path = $file->store('property_type_images', 'public');
                PropertyTypeImage::create([
                    'property_type_id' => $request->property_type_id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('property_type_image.index')->with('success', 'Galeri Gambar berhasil diperbarui!');
    }

    // 7. Proses Hapus Semua Gambar pada Type Tersebut
    public function destroy($id)
    {
        $images = PropertyTypeImage::where('property_type_id', $id)->get();
        foreach ($images as $img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
            $img->delete();
        }

        return redirect()->route('property_type_image.index')->with('success', 'Semua Gambar pada Type tersebut berhasil dihapus!');
    }
}
