<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\TodoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth dari Breeze
require __DIR__ . '/auth.php';

// ===================== PROTECTED ROUTES =====================
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

    // Children Route
    Route::get('/children', [ChildController::class, 'index'])->name('children.index');
    Route::get('/children/create', [ChildController::class, 'create'])->name('children.create');
    Route::post('/children', [ChildController::class, 'store'])->name('children.store');
    Route::get('/children/{child}', [ChildController::class, 'show'])->name('children.show');
    Route::get('/children/{child}/edit', [ChildController::class, 'edit'])->name('children.edit');
    Route::put('/children/{child}', [ChildController::class, 'update'])->name('children.update');
    Route::delete('/children/{child}', [ChildController::class, 'destroy'])->name('children.destroy');

    // Measurement Route
    Route::get('/measurements', [MeasurementController::class, 'index'])->name('measurements.index');
    Route::get('/measurements/create/{child}', [MeasurementController::class, 'create'])->name('measurements.create');
    Route::post('/measurements/{child}', [MeasurementController::class, 'store'])->name('measurements.store');
    Route::get('/measurements/{measurement}/edit', [MeasurementController::class, 'edit'])->name('measurements.edit');
    Route::put('/measurements/{measurement}', [MeasurementController::class, 'update'])->name('measurements.update');
    Route::delete('/measurements/{measurement}', [MeasurementController::class, 'destroy'])->name('measurements.destroy');

    // Todos Route
    Route::get('/children/{child}/todos', [TodoController::class, 'index'])->name('todos.index');
    Route::post('/children/{child}/todos', [TodoController::class, 'store'])->name('todos.store');
    Route::put('/todos/{todo}/toggle', [TodoController::class, 'toggle'])->name('todos.toggle');
    Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
    Route::get('/todos', [TodoController::class, 'globalIndex'])->name('todos.global');
    // Grafik Route
    Route::get('/grafik', [GrafikController::class, 'index'])->name('grafik.index');

});