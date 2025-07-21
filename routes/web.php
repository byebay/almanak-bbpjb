<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserImportController;  
use App\Http\Controllers\AttendanceImportController;
use App\Http\Controllers\AttendanceReportController;
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
    Route::get('/attendances/import', [AttendanceImportController::class, 'create'])->name('attendances.import.create');
    Route::post('/attendances/import', [AttendanceImportController::class, 'store'])->name('attendances.import.store');
    Route::get('/reports/attendance', [AttendanceReportController::class, 'index'])->name('reports.attendance.index');
    Route::post('/reports/attendance/update-status', [AttendanceReportController::class, 'updateStatus'])->name('reports.attendance.updateStatus');

});

require __DIR__.'/auth.php';
