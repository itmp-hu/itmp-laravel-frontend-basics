<?php

use App\Http\Controllers\CarController;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['username' => 'John Doe']);
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/users', function () {
    return view('users', ['users' => User::all()]);
});

Route::get('/cars', function () {
    return view('cars', ['cars' => Car::all()]);
})->name('cars.index');

Route::get('/cars/create', function () {
    return view('create');
})->name('cars.create');

Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
Route::delete('/cars/{id}', [CarController::class, 'destroy'])->name('cars.destroy');

Route::get('/cars/{id}/edit', [CarController::class, 'edit'])->name('cars.edit');
Route::put('/cars/{id}', [CarController::class, 'update'])->name('cars.update');

