<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserImportController;  
use App\Http\Controllers\AttendanceImportController;
use App\Http\Controllers\AttendanceReportController;
use App\Http\Controllers\EmployeeWorkController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AttendanceStatisticController;
use App\Http\Controllers\KinerjaController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\KinerjaDetailController;
use App\Http\Controllers\AgendaImportController;

Route::get('/', function () {
    return view('welcome');
});

// 1. Jadikan halaman utama (root) menunjuk ke PublicController
Route::get('/', [PublicController::class, 'index'])->name('public.home');

// 2. Buat route untuk data event kalender yang bisa diakses publik
Route::get('/public/events', [PublicController::class, 'getEvents'])->name('public.events');
// --------------------------------


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Dashboard internal juga butuh data event
    Route::get('/dashboard/events', [DashboardController::class, 'getEvents'])->name('dashboard.events');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users/import', [UserImportController::class, 'create'])->name('users.import.create');
    Route::post('/users/import', [UserImportController::class, 'store'])->name('users.import.store');
    Route::get('/attendances/import', [AttendanceImportController::class, 'create'])->name('attendances.import.create');
    Route::post('/attendances/import', [AttendanceImportController::class, 'store'])->name('attendances.import.store');
    Route::get('/reports/attendance', [AttendanceReportController::class, 'index'])->name('reports.attendance.index');
    Route::post('/reports/attendance/update-status', [AttendanceReportController::class, 'updateStatus'])->name('reports.attendance.updateStatus');
    Route::resource('agenda-harian', AgendaController::class);
    Route::get('/dashboard/events', [DashboardController::class, 'getEvents'])->name('dashboard.events');
    Route::get('/laporan/statistik', [AttendanceStatisticController::class, 'index'])->name('laporan.statistik');
    Route::get('/hasil-kerja', [EmployeeWorkController::class, 'index'])->name('hasil-kerja.index');
    Route::post('/hasil-kerja', [EmployeeWorkController::class, 'store'])->name('hasil-kerja.store');
    Route::get('/hasil-kerja/{work}/view', [EmployeeWorkController::class, 'view'])->name('hasil-kerja.view');
    Route::get('/hasil-kerja/{work}/download', [EmployeeWorkController::class, 'download'])->name('hasil-kerja.download');
    Route::get('/hasil-kerja/{year}/{month}', [EmployeeWorkController::class, 'showMonth'])->name('hasil-kerja.month');
    Route::get('/hasil-kerja/{year}/{month}/{user}', [EmployeeWorkController::class, 'showEmployeeWork'])->name('hasil-kerja.employee');
    Route::delete('/hasil-kerja/{work}', [EmployeeWorkController::class, 'destroy'])->name('hasil-kerja.destroy');
    Route::get('/leaves/manage', [LeaveController::class, 'index'])->name('leaves.manage');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
    Route::delete('/leaves/{leaveRecord}', [LeaveController::class, 'destroy'])->name('leaves.destroy');
    Route::resource('kinerja', KinerjaController::class);
    Route::get('/status-ruangan', [RoomController::class, 'showStatus'])->name('rooms.status');
    Route::resource('rooms', RoomController::class)->except(['show', 'create']);Route::put('/kinerja-detail/{kinerjaDetail}', [KinerjaDetailController::class, 'update'])->name('kinerja.detail.update');
    Route::get('/agendas/import', [AgendaImportController::class, 'create'])->name('agendas.import.create');
    Route::post('/agendas/import', [AgendaImportController::class, 'store'])->name('agendas.import.store');
});


require __DIR__.'/auth.php';
