<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Mengambil semua data dan menjadikannya array asosiatif ['key' => 'value']
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'contact_phone' => 'nullable|string',
            'contact_whatsapp' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_address' => 'nullable|string',
        ]);

        // Daftar key yang akan disimpan
        $keys = [
            'contact_phone',
            'contact_whatsapp',
            'contact_email',
            'contact_address',
        ];

        // Looping untuk menyimpan atau memperbarui data berdasarkan 'key'
        foreach ($keys as $key) {
            Setting::updateOrCreate(
                ['key' => $key], // Cari berdasarkan key ini
                ['value' => $request->input($key)] // Update value-nya dengan data dari form
            );
        }

        return redirect()->back()->with('success', 'Pengaturan kontak berhasil diperbarui!');
    }
}
