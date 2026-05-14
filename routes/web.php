<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Admin\PropertyTypeImageController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PropertyController as FrontendPropertyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Utama (Homepage)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route untuk Halaman Detail Property
Route::get('/property/{id}', [FrontendPropertyController::class, 'show'])->name('frontend.property.show');

// Route logout sementara
Route::post('/logout', function () {
    // Auth::logout();
    return redirect('/');
})->name('logout');

// Grup Route khusus halaman Admin
Route::prefix('admin')->group(function () {

    // Halaman Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // CRUD Data Property
    Route::resource('property', PropertyController::class);

    // CRUD Data Type Rumah
    Route::resource('property_type', PropertyTypeController::class);

    // CRUD Data Gambar Type Rumah
    Route::resource('property_type_image', PropertyTypeImageController::class);

    // CRUD Data Testimonial
    Route::resource('testimonial', TestimonialController::class);

    // Data Setting
    Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('setting.store');

});
