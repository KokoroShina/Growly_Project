<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\TodoController;

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $user = request()->user();

        $children = $user->children()
            ->with('latestMeasurement')
            ->take(5)
            ->get();

        $totalChildren = $user->children()->count();

        return view('dashboard', compact('children', 'totalChildren'));
    })->name('dashboard');

    // =====================
    // CHILDREN ROUTES
    // =====================

    Route::get('/children', [ChildController::class, 'index'])
        ->name('children.index');

    Route::get('/children/create', [ChildController::class, 'create'])
        ->name('children.create');

    Route::post('/children', [ChildController::class, 'store'])
        ->name('children.store');

    Route::get('/children/{child}', [ChildController::class, 'show'])
        ->name('children.show');

    Route::get('/children/{child}/edit', [ChildController::class, 'edit'])
        ->name('children.edit');

    Route::put('/children/{child}', [ChildController::class, 'update'])
        ->name('children.update');

    Route::delete('/children/{child}', [ChildController::class, 'destroy'])
        ->name('children.destroy');

    // =====================
    // MEASUREMENTS
    // =====================

    Route::post('/children/{child}/measurements', [MeasurementController::class, 'store'])
        ->name('measurements.store');

    // =====================
    // TODOS
    // =====================

    Route::post('/children/{child}/todos', [TodoController::class, 'store'])
        ->name('todos.store');

    Route::put('/todos/{todo}/toggle', [TodoController::class, 'toggle'])
        ->name('todos.toggle');
});
