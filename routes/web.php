<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/prijava', [App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::post('/obrada', [App\Http\Controllers\AuthController::class, 'obrada']);

// rute za job_postings
Route::resource('jobpostings', App\Http\Controllers\JobPostingController::class);

// API ruta za dohvat radnih pozicija (za Select2/TomSelect)
Route::get('/api/job-positions', [App\Http\Controllers\Api\JobPositionController::class, 'index']);
