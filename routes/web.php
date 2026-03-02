<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

// Change the root route to use your new controller logic
//Route::get('/', [DataController::class, 'index'])->name('home');


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/cases', function () {
    return view('cases');
})->name('cases');