<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserImportController; 
use App\Http\Controllers\AgendaController; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users/import', [UserImportController::class, 'create'])->name('users.import.create');
    Route::post('/users/import', [UserImportController::class, 'store'])->name('users.import.store');
    Route::resource('agenda-harian', AgendaController::class);
    Route::get('/dashboard/events', [DashboardController::class, 'getEvents'])->name('dashboard.events');
});

require __DIR__.'/auth.php';
