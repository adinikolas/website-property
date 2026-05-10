<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\PropertyTypeImage;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProperty = Property::count();
        $totalPropertyType = PropertyType::count();
        $totalGambar = PropertyTypeImage::count();
        $totalTestimonial = Testimonial::count();

        // Tambahkan 'primaryImage' ke dalam with()
        $featuredTypes = PropertyType::with(['property', 'primaryImage'])
            ->where('is_featured', true)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalProperty',
            'totalPropertyType',
            'totalGambar',
            'totalTestimonial',
            'featuredTypes'
        ));
    }
}
