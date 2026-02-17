<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\MeasurementController;
use App\Models\Measurement;

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

    // Form edit anak
    Route::get('/children/{child}/edit', [ChildController::class, 'edit'])
        ->name('children.edit');

    // Update data anak
    Route::put('/children/{child}', [ChildController::class, 'update'])
        ->name('children.update');

    Route::delete('/children/{child}', [ChildController::class, 'destroy'])
        ->name('children.destroy');



     // ================= MEASUREMENT =================
    Route::get('/measurements', [MeasurementController::class, 'index'])
        ->name('measurements.strore');
    
    Route::get('measurements/{measurement}/edit', [MeasurementController::class,'edit'])->name('measurements.edit');
    Route::put('measurements/{measurement}', [MeasurementController::class,'update'])->name('measurements.update');
    Route::get('measurements/create/{child}', [MeasurementController::class,'create'])->name('measurements.create');
    Route::post('measurements/{child}', [MeasurementController::class,'store'])->name('measurements.store');
    Route::delete('measurements/{measurement}', [MeasurementController::class,'destroy'])->name('measurements.destroy');

});
