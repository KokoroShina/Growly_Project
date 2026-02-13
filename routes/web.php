<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| SEMENTARA TANPA AUTH MIDDLEWARE
| Untuk testing tampilan saja
*/

// ==================== PUBLIC ROUTES ====================
Route::get('/', function () {
    return view('welcome');
});

// ==================== AUTH ROUTES (DUMMY) ====================
// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    return redirect('/dashboard')->with('success', 'Login berhasil!');
});

// Register  
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function () {
    return redirect('/login')->with('status', 'Registrasi berhasil! Silakan login.');
});

// Logout
Route::post('/logout', function () {
    return redirect('/login')->with('status', 'Berhasil logout!');
})->name('logout');

// ==================== APP ROUTES (TANPA MIDDLEWARE) ====================
// Dashboard
Route::get('/dashboard', function () {
    return view('layouts.dashboard');
})->name('dashboard');
// Children routes
Route::get('/children', function () {
    return view('children.index');
})->name('children.index');

Route::get('/children/create', function () {
    return view('children.create');
})->name('children.create');

// Route untuk handle form submission (sementara dummy)
Route::post('/children', function () {
    return redirect('/children')->with('success', 'Data anak berhasil ditambahkan!');
})->name('children.store');

Route::get('/children/{id}', function ($id) {
    return view('children.show', ['childId' => $id]);
})->name('children.show');