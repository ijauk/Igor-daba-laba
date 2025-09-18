<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobPostingController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/prijava', [App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::post('/obrada', [App\Http\Controllers\AuthController::class, 'obrada']);

// rute za job_postings
Route::resource('jobpostings', JobPostingController::class);


// API ruta za dohvat radnih pozicija (za Select2/TomSelect)
Route::get('/api/job-positions', [App\Http\Controllers\Api\JobPositionController::class, 'index']);


// API ruta za dohvat zaposlenika (za Select2/TomSelect)
Route::get('/api/employees', [App\Http\Controllers\Api\EmployeeController::class, 'index']);

Route::get('/test', [App\Http\Controllers\TestController::class, 'index'])->name('test');

