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


