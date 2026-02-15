<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home

// Auth dari Breeze
require __DIR__ . '/auth.php';


// ===================== PROTECTED ROUTES =====================
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('layouts.dashboard');
    })->name('dashboard');


    // ================= CHILDREN =================

    // List anak
    Route::get('/children', [ChildController::class, 'index'])
        ->name('children.index');

    // Form tambah anak
    Route::get('/children/create', [ChildController::class, 'create'])
        ->name('children.create');

    // Simpan ke database
    Route::post('/children', [ChildController::class, 'store'])
        ->name('children.store');

    // Detail anak
    Route::get('/children/{child}', [ChildController::class, 'show'])
        ->name('children.show');
});
