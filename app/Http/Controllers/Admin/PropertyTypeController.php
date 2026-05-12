<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = PropertyType::with(['property', 'primaryImage'])->latest();

        // Filter jika datang dari halaman Detail Property
        if ($request->has('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        $types = $query->get();
        return view('admin.property_type.index', compact('types'));
    }

    public function create(Request $request)
    {
        $properties = Property::all();
        $selectedProperty = $request->query('property_id');
        return view('admin.property_type.create', compact('properties', 'selectedProperty'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required',
            'name_type' => 'required',
            'jenis_type' => 'required',
            'jml_kamar' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'kpr' => 'required|numeric',
            'booking' => 'required|numeric',
            'is_featured' => 'required|boolean',
        ]);

        // Format data DP menjadi array
        $dpData = [];
        if ($request->dp_nama && $request->dp_harga) {
            foreach ($request->dp_nama as $index => $nama) {
                if (!empty($nama)) {
                    $dpData[] = [
                        'nama' => $nama,
                        'harga' => $request->dp_harga[$index]
                    ];
                }
            }
        }

        PropertyType::create([
            'property_id' => $request->property_id,
            'name_type' => $request->name_type,
            'jenis_type' => $request->jenis_type,
            'jml_kamar' => $request->jml_kamar,
            'harga_jual' => $request->harga_jual,
            'kpr' => $request->kpr,
            'dp' => $dpData, // Disimpan sebagai JSON berkat $casts array
            'booking' => $request->booking,
            'is_featured' => $request->is_featured,
        ]);

        return redirect()->route('property_type.index')->with('success', 'Type Rumah berhasil ditambahkan!');
    }

    public function show($id)
    {
        $type = PropertyType::with(['property', 'images'])->findOrFail($id);
        return view('admin.property_type.detail', compact('type'));
    }

    public function edit($id)
    {
        $type = PropertyType::findOrFail($id);
        $properties = Property::all();
        return view('admin.property_type.edit', compact('type', 'properties'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'property_id' => 'required',
            'name_type' => 'required',
            'jenis_type' => 'required',
            'jml_kamar' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'kpr' => 'required|numeric',
            'booking' => 'required|numeric',
            'is_featured' => 'required|boolean',
        ]);

        // Format ulang data DP dari input form
        $dpData = [];
        if ($request->dp_nama && $request->dp_harga) {
            foreach ($request->dp_nama as $index => $nama) {
                if (!empty($nama)) {
                    $dpData[] = [
                        'nama' => $nama,
                        'harga' => $request->dp_harga[$index]
                    ];
                }
            }
        }

        $type = PropertyType::findOrFail($id);
        $type->update([
            'property_id' => $request->property_id,
            'name_type' => $request->name_type,
            'jenis_type' => $request->jenis_type,
            'jml_kamar' => $request->jml_kamar,
            'harga_jual' => $request->harga_jual,
            'kpr' => $request->kpr,
            'dp' => $dpData,
            'booking' => $request->booking,
            'is_featured' => $request->is_featured,
        ]);

        return redirect()->route('property_type.index')->with('success', 'Type Rumah berhasil diperbarui!');
    }

    // Untuk Edit, Update, Destroy (Mirip dengan PropertyController)
    public function destroy($id)
    {
        PropertyType::findOrFail($id)->delete();
        return back()->with('success', 'Type Rumah berhasil dihapus!');
    }
}
