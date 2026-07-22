<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserImportController;
use App\Http\Controllers\UserManagementController; 
use App\Http\Controllers\AttendanceImportController;
use App\Http\Controllers\AttendanceReportController;
// use App\Http\Controllers\EmployeeWorkController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AttendanceStatisticController;
use App\Http\Controllers\KinerjaController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\KinerjaDetailController;
use App\Http\Controllers\AgendaImportController;
use App\Http\Middleware\LogVisitor; // <-- Import Middleware
use App\Http\Controllers\SharedLinkController;

Route::get('/', function () {
    return view('welcome');
});

// 1. Jadikan halaman utama (root) menunjuk ke PublicController
Route::get('/', [PublicController::class, 'index'])->middleware(LogVisitor::class);


// 2. Buat route untuk data event kalender yang bisa diakses publik
Route::get('/public/events', [PublicController::class, 'getEvents'])->name('public.events');
// Route ini tidak memerlukan login
// Halaman utama untuk link yang dibagikan
// Route::get('/share/hasil-kerja/{token}/{year}/{month}', [EmployeeWorkController::class, 'showPublic'])->name('hasil-kerja.public.show');
// // Rute untuk melihat file dari halaman publik
// Route::get('/share/view/{work}/{token}', [EmployeeWorkController::class, 'viewPublic'])->name('hasil-kerja.public.view');
// // Rute untuk mengunduh file dari halaman publik
// Route::get('/share/download/{work}/{token}', [EmployeeWorkController::class, 'downloadPublic'])->name('hasil-kerja.public.download');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Dashboard internal juga butuh data event
    Route::get('/dashboard/events', [DashboardController::class, 'getEvents'])->name('dashboard.events');
    Route::get('/dashboard/visitor-stats/export', [DashboardController::class, 'exportVisitorStats'])->name('dashboard.visitor.export');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::post('/profile/change-password', [ProfileController::class, 'sendChangePasswordLink'])->name('profile.change-password.send');
    Route::get('/users/import', [UserImportController::class, 'create'])->name('users.import.create');
    Route::post('/users/import', [UserImportController::class, 'store'])->name('users.import.store');
    Route::get('/admin/manage-users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserManagementController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::patch('/admin/users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('admin.users.reset_password');
    Route::get('/attendances/import', [AttendanceImportController::class, 'create'])->name('attendances.import.create');
    Route::post('/attendances/import', [AttendanceImportController::class, 'store'])->name('attendances.import.store');
    Route::get('/reports/attendance', [AttendanceReportController::class, 'index'])->name('reports.attendance.index');
    Route::post('/reports/attendance/update-status', [AttendanceReportController::class, 'updateStatus'])->name('reports.attendance.updateStatus');
    Route::resource('agenda-harian', AgendaController::class);
    Route::get('/dashboard/events', [DashboardController::class, 'getEvents'])->name('dashboard.events');
    Route::get('/laporan/statistik', [AttendanceStatisticController::class, 'index'])->name('laporan.statistik');
    // Route::get('/hasil-kerja', [EmployeeWorkController::class, 'index'])->name('hasil-kerja.index');
    // Route::post('/hasil-kerja', [EmployeeWorkController::class, 'store'])->name('hasil-kerja.store');
    // Route::get('/hasil-kerja/{work}/view', [EmployeeWorkController::class, 'view'])->name('hasil-kerja.view');
    // Route::get('/hasil-kerja/{work}/download', [EmployeeWorkController::class, 'download'])->name('hasil-kerja.download');
    // Route::delete('/hasil-kerja/{work}', [EmployeeWorkController::class, 'destroy'])->name('hasil-kerja.destroy');
    // Route::get('/hasil-kerja/{user}/{year}/{month}/download-all', [EmployeeWorkController::class, 'downloadAllAsZip'])->name('hasil-kerja.download-all');
    // Route::get('/hasil-kerja/{year}/{month}', [EmployeeWorkController::class, 'showMonth'])->name('hasil-kerja.month');
    // Route::get('/hasil-kerja/{year}/{month}/{user}', [EmployeeWorkController::class, 'showEmployeeWork'])->name('hasil-kerja.employee');
    Route::get('/leaves/manage', [LeaveController::class, 'index'])->name('leaves.manage');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
    Route::delete('/leaves/{leaveRecord}', [LeaveController::class, 'destroy'])->name('leaves.destroy');
    Route::resource('kinerja', KinerjaController::class);
    Route::get('/realisasi-kegiatan/export', [KinerjaController::class, 'exportExcel'])->name('kinerja.export');
    Route::get('/status-ruangan', [RoomController::class, 'showStatus'])->name('rooms.status');
    Route::resource('rooms', RoomController::class)->except(['show', 'create']);Route::put('/kinerja-detail/{kinerjaDetail}', [KinerjaDetailController::class, 'update'])->name('kinerja.detail.update');
    Route::get('/agendas/import', [AgendaImportController::class, 'create'])->name('agendas.import.create');
    Route::post('/agendas/import', [AgendaImportController::class, 'store'])->name('agendas.import.store');
    Route::get('/galeri-tautan', [SharedLinkController::class, 'index'])->name('galeri-tautan.index');
    Route::post('/galeri-tautan', [SharedLinkController::class, 'store'])->name('galeri-tautan.store');
    Route::delete('/galeri-tautan/{link}', [SharedLinkController::class, 'destroy'])->name('galeri-tautan.destroy');
    
});


require __DIR__.'/auth.php';
