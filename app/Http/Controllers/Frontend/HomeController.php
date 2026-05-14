<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Testimonial;
use App\Models\Setting;
use App\Models\PropertyTypeImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 properti terbaru untuk ditampilkan di halaman depan
        $properties = Property::latest()->take(4)->get();

        // Ambil semua testimoni
        $testimonials = Testimonial::latest()->get();

        // Ambil data settings untuk tombol WhatsApp (CTA)
        $settings = Setting::pluck('value', 'key')->toArray();

        // Mengambil 10 gambar terbaru dari galeri gambar property
        $galleries = PropertyTypeImage::latest()->take(10)->get();

        return view('frontend.home.index', compact('properties', 'testimonials', 'settings', 'galleries'));
    }
}
