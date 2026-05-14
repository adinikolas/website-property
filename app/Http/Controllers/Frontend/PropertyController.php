<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Setting;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function show($id)
    {
        // Ambil data Property beserta Tipe Rumah dan Gambar Galerinya
        $property = Property::with(['propertyTypes.images'])->findOrFail($id);

        // Asumsi: Menampilkan Tipe Rumah pertama dari property ini
        $type = $property->propertyTypes->first();

        // Ambil data kontak untuk tombol WA
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('frontend.property.detail', compact('property', 'type', 'settings'));
    }
}
