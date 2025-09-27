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
Route::post('/odjava', [App\Http\Controllers\AuthController::class, 'odjava'])->name('logout');
// rute za job_postings
Route::resource('jobpostings', JobPostingController::class);


// API ruta za dohvat radnih pozicija (za Select2/TomSelect)
Route::get('/api/job-positions', [App\Http\Controllers\Api\JobPositionController::class, 'index']);

// API ruta za dohvat zaposlenika (za Select2/TomSelect)
Route::get('/api/employees', [App\Http\Controllers\Api\EmployeeController::class, 'index']);

// API ruta za dohvat edukacija (za Select2/TomSelect)
Route::get('/api/educations', [App\Http\Controllers\Api\EducationController::class, 'index']);

Route::get('/test', [App\Http\Controllers\TestController::class, 'index'])->name('test');
Route::get('/testiraj-komponentu', [App\Http\Controllers\TestController::class, 'komp'])->name('komp');

Route::middleware(['auth'])->group(function () {
    Route::resource('employees', App\Http\Controllers\EmployeeController::class);
    Route::resource('organizational-units', App\Http\Controllers\OrganizationalUnitController::class);
    Route::resource('educations', App\Http\Controllers\EducationController::class);
    Route::resource('job-positions', App\Http\Controllers\JobPositionController::class);
    Route::resource('hiring-plans', App\Http\Controllers\HiringPlanController::class);
});

