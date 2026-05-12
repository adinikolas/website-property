<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\PropertyTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

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

});
