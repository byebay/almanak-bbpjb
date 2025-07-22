<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DailyAttendance; // PASTIKAN NAMA MODEL INI SESUAI
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceStatisticController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // Mengambil semua data absensi hari ini beserta data user-nya
        $attendancesToday = DailyAttendance::where('date', $today)->with('user')->get();

        // 1. Pegawai datang paling awal
        $earliestAttendance = $attendancesToday
            ->whereIn('status', ['Hadir', 'Terlambat'])
            ->sortBy('check_in_time')
            ->first();
        $pegawaiPalingAwal = $earliestAttendance ? $earliestAttendance->user : null;
        
        // 2. Jumlah hadir & terlambat
        $jumlahHadir = $attendancesToday->where('status', 'Hadir')->count();
        $jumlahTerlambat = $attendancesToday->where('status', 'Terlambat')->count();

        // 3. Pegawai yang cuti
        $pegawaiCuti = $attendancesToday->where('status', 'Cuti')->map(fn($att) => $att->user)->whereNotNull()->unique('id');

        // 4. Pegawai yang dinas luar
        $pegawaiDinasLuar = $attendancesToday->where('status', 'Dinas Luar')->map(fn($att) => $att->user)->whereNotNull()->unique('id');
        
        // Mengirim semua data yang sudah diolah ke view
        return view('reports.statistics', [
            'pegawaiPalingAwal' => $pegawaiPalingAwal,
            'jumlahHadir' => $jumlahHadir,
            'jumlahTerlambat' => $jumlahTerlambat,
            'pegawaiCuti' => $pegawaiCuti,
            'pegawaiDinasLuar' => $pegawaiDinasLuar,
        ]);
    }
}