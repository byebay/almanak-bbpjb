<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\DailyAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PublicController extends Controller
{
    /**
     * Menampilkan halaman dashboard publik.
     */
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // Mengambil data absensi hari ini beserta data user-nya
        $attendancesToday = DailyAttendance::where('date', $today)->with('user')->get();

        // 1. Pegawai datang paling awal
        $earliestAttendance = $attendancesToday
            ->whereNotNull('user')
            ->whereIn('status', ['Hadir', 'Terlambat'])
            ->sortBy('check_in_time')
            ->first();
        $pegawaiPalingAwal = $earliestAttendance ? $earliestAttendance->user : null;
        
        // 2. Jumlah hadir & terlambat
        $jumlahHadir = $attendancesToday->where('status', 'Hadir')->count();
        $jumlahTerlambat = $attendancesToday->where('status', 'Terlambat')->count();

        // 3. Pegawai yang cuti & dinas luar
        $pegawaiCuti = $attendancesToday->where('status', 'Cuti')->whereNotNull('user')->pluck('user')->unique('id');
        $pegawaiDinasLuar = $attendancesToday->where('status', 'Dinas Luar')->whereNotNull('user')->pluck('user')->unique('id');
        
        // Kirim semua data ke view publik yang akan kita buat
        return view('public-dashboard', [
            'pegawaiPalingAwal' => $pegawaiPalingAwal,
            'jumlahHadir' => $jumlahHadir,
            'jumlahTerlambat' => $jumlahTerlambat,
            'pegawaiCuti' => $pegawaiCuti,
            'pegawaiDinasLuar' => $pegawaiDinasLuar,
        ]);
    }

    /**
     * Menyediakan data agenda untuk FullCalendar.
     * Fungsi ini bisa dipanggil oleh halaman publik dan internal.
     */
    public function getEvents(Request $request)
    {
        $agendas = Agenda::where('status', 'Terpublikasi')->get();

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
