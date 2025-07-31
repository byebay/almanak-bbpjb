<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\DailyAttendance;
use App\Models\LeaveRecord; // <-- 1. Import model baru
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // --- LOGIKA BARU UNTUK MENGGABUNGKAN DATA KEHADIRAN ---

        // 2. Ambil semua sumber data untuk hari ini
        $allEmployees = User::where('role', '!=', 'super_admin')->get();
        $attendanceLogs = DailyAttendance::where('date', $today)->with('user')->get()->keyBy('ac_no');
        $leaveLogs = LeaveRecord::where('start_date', '<=', $today)
                                ->where('end_date', '>=', $today)
                                ->with('user')
                                ->get()
                                ->keyBy('user_id');

        // 3. Buat laporan terpadu untuk hari ini
        $finalAttendanceData = $allEmployees->map(function ($employee) use ($attendanceLogs, $leaveLogs) {
            // Prioritas 1: Cek data Cuti/DL dari input manual
            if ($leave = $leaveLogs->get($employee->id)) {
                return (object) [
                    'user' => $employee,
                    'status' => $leave->status,
                    'check_in_time' => null,
                ];
            }
            // Prioritas 2: Cek data dari impor Excel
            if ($log = $attendanceLogs->get($employee->nip)) {
                return (object) [
                    'user' => $employee,
                    'status' => $log->status,
                    'check_in_time' => $log->check_in_time,
                ];
            }
            // Prioritas 3: Jika tidak ada data sama sekali
            return (object) [
                'user' => $employee,
                'status' => 'Tanpa Keterangan',
                'check_in_time' => null,
            ];
        });

        // 4. Hitung statistik berdasarkan data terpadu yang sudah benar
        $pegawaiPalingAwal = $finalAttendanceData
            ->whereIn('status', ['Hadir', 'Terlambat'])
            ->sortBy('check_in_time')
            ->first()->user ?? null;
        
        $jumlahHadir = $finalAttendanceData->where('status', 'Hadir')->count();
        $jumlahTerlambat = $finalAttendanceData->where('status', 'Terlambat')->count();
        $pegawaiCuti = $finalAttendanceData->where('status', 'Cuti')->pluck('user');
        $pegawaiDinasLuar = $finalAttendanceData->where('status', 'Dinas Luar')->pluck('user');
        
        // --- AKHIR LOGIKA BARU ---

        // Mengirim data yang sudah diolah dengan benar ke view
        return view('dashboard', [
            'pegawaiPalingAwal' => $pegawaiPalingAwal,
            'jumlahHadir' => $jumlahHadir,
            'jumlahTerlambat' => $jumlahTerlambat,
            'pegawaiCuti' => $pegawaiCuti,
            'pegawaiDinasLuar' => $pegawaiDinasLuar,
        ]);
    }

    public function getEvents(Request $request)
    {
        // --- PERBAIKAN UTAMA DI SINI ---
        // Ambil hanya agenda yang statusnya 'Terpublikasi'
        $agendas = Agenda::where('status', 'Terpublikasi')->get();
        // ------------------------------------

        $events = [];
        foreach ($agendas as $agenda) {
            $events[] = [
                'title' => $agenda->title,
                'start' => $agenda->agenda_date->format('Y-m-d'),
                'extendedProps' => [
                    'description' => $agenda->description,
                    'start_time' => Carbon::parse($agenda->start_time)->format('H:i'),
                    'end_time' => Carbon::parse($agenda->end_time)->format('H:i'),
                ]
            ];
        }

        return response()->json($events);
    }
}
