<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
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
// Route::post('/logout', function () {
//     // Auth::logout();
//     return redirect('/');
// })->name('logout');

// Grup Route khusus halaman Admin
Route::prefix('admin')->group(function () {

    // Route untuk Tamu (Belum Login)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    });

    // Jika mengakses /admin otomatis diarahkan ke /admin/dashboard
    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });

    // Route yang DILINDUNGI (Hanya bisa diakses jika sudah Login)
    Route::middleware('auth')->group(function () {

        // Halaman Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Route logout (Dipindah ke dalam auth agar hanya bisa diakses kalau sudah login)
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // CRUD Data
        Route::resource('property', PropertyController::class);
        Route::resource('property_type', PropertyTypeController::class);
        Route::resource('property_type_image', PropertyTypeImageController::class);
        Route::resource('testimonial', TestimonialController::class);

        // Data Setting
        Route::get('/settings', [SettingController::class, 'index'])->name('setting.index');
        Route::post('/settings', [SettingController::class, 'store'])->name('setting.store');
    });

});
