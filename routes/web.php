<?php

use Illuminate\Support\Facades\Route;

// SIMPLE AUTH ROUTES FOR TESTING
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/login', function () {
    // Untuk testing, redirect ke dashboard
    return redirect('/dashboard');
});

Route::post('/register', function () {
    // Untuk testing, redirect ke login
    return redirect('/login')->with('status', 'Registrasi berhasil!');
});

// Dashboard (protected)
Route::get('/dashboard', function () {
    return "Dashboard akan datang di sini!";
})->name('dashboard');

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// ... setelah routes login/register

// Dashboard route
Route::get('/dashboard', function () {
    return view('layouts.dashboard');
})->name('dashboard');

// Logout route (dummy)
Route::post('/logout', function () {
    return redirect('/login')->with('status', 'Berhasil logout!');
})->name('logout');

// Children routes (sementara dummy)
Route::get('/children', function () {
    return "Halaman list anak akan datang!";
})->name('children.index');

Route::get('/children/create', function () {
    return "Form tambah anak akan datang!";
})->name('children.create');