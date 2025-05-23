<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChurchController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\NetworkController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::post('/users/register',[UserController::class,'store'])->name('user.store');
    Route::post('/users/update',[UserController::class,'update'])->name('user.update');
    Route::get('/users/{user}/delete',[UserController::class, 'destroy'])->name('user.destroy');    
    Route::get('/users',[UserController::class, 'index'])->name('users');    
    
    Route::get('/church',[ChurchController::class,'show'])->name('church.show');
    Route::post('/church/update',[ChurchController::class,'update'])->name('church.update');

    Route::resource('/houses',HouseController::class);

    Route::resource('/networks',NetworkController::class)->only(['index','show','store']);

    // GET /posts - index
    // GET /posts/create - create
    // POST /posts - store
    // GET /posts/{post} - show
    // GET /posts/{post}/edit - edit
    // PUT/PATCH /posts/{post} - update
    // DELETE /posts/{post} - destroy

});
