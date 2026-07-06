<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\DailyAttendance;
use App\Models\LeaveRecord;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PublicController extends Controller
{
    /**
     * Menampilkan halaman dashboard publik.
     */
    public function index(Request $request)
    {
        // Logika pencatatan pengunjung
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $today = now()->toDateString();

        $existingVisitor = Visitor::where('ip_address', $ipAddress)
                                  ->where('visit_date', $today)
                                  ->first();

        if (!$existingVisitor) {
            $newVisitor = new Visitor();
            $newVisitor->ip_address = $ipAddress;
            $newVisitor->visit_date = $today;
            $newVisitor->user_agent = $userAgent;
            $newVisitor->save();
        }

        // Logika penghitungan pengunjung yang sudah diperbaiki
        $startOfMonth = now()->startOfMonth()->toDateString();
        $visitorCount = Visitor::where('visit_date', '>=', $startOfMonth)->count();

        // Logika untuk statistik kehadiran
        $startOfMonth = now()->startOfMonth()->toDateString();
        $visitorCount = Visitor::where('visit_date', '>=', $startOfMonth)->count();
        $todayForAttendance = Carbon::today()->toDateString();
        $attendanceLogs = DailyAttendance::where('date', $todayForAttendance)->with('user')->get();
        $leaveLogs = LeaveRecord::where('start_date', '<=', $todayForAttendance)
                                ->where('end_date', '>=', $todayForAttendance)
                                ->with('user')
                                ->get();
        $earliestAttendance = $attendanceLogs->whereNotNull('user')->whereIn('status', ['Hadir', 'Terlambat'])->sortBy('check_in_time')->first();
        $pegawaiPalingAwal = $earliestAttendance ? $earliestAttendance->user : null;
        $jumlahHadir = $attendanceLogs->where('status', 'Hadir')->count();
        $jumlahTerlambat = $attendanceLogs->where('status', 'Terlambat')->count();
        $pegawaiCuti = $leaveLogs->where('status', 'Cuti')->whereNotNull('user')->pluck('user')->unique('id');
        $pegawaiDinasLuar = $leaveLogs->where('status', 'Dinas Luar')->whereNotNull('user')->pluck('user')->unique('id');
        
        return view('public-dashboard', compact('visitorCount', 'pegawaiPalingAwal', 'jumlahHadir', 'jumlahTerlambat', 'pegawaiCuti', 'pegawaiDinasLuar'));
    }

    /**
     * Menyediakan data agenda untuk FullCalendar.
     */
    public function getEvents(Request $request)
    {
        $agendas = Agenda::where('status', 'Terpublikasi')->with('room')->get();
        $events = [];

        foreach ($agendas as $agenda) {
            $title = $agenda->title;
            if ($agenda->room) {
                $title = '[' . $agenda->room->name . '] ' . $agenda->title;
            }

            $commonProps = [
                'description' => $agenda->description,
                'start_time' => Carbon::parse($agenda->start_time)->format('H:i'),
                'end_time' => Carbon::parse($agenda->end_time)->format('H:i'),
                'file_url' => $agenda->file_path ? asset('storage/' . $agenda->file_path) : null,
                'file_name' => $agenda->file_path ? basename($agenda->file_path) : null,
                'file_extension' => $agenda->file_path ? strtolower(pathinfo($agenda->file_path, PATHINFO_EXTENSION)) : null,
                'room_name' => $agenda->room ? $agenda->room->name : null,
            ];

            // Jika agenda hanya satu hari atau tidak memiliki tanggal berakhir
            if (!$agenda->end_date || $agenda->start_date->isSameDay($agenda->end_date)) {
                $events[] = [
                    'title' => $title,
                    'start' => $agenda->start_date->format('Y-m-d'),
                    'extendedProps' => $commonProps,
                ];
            } else {
                // Jika agenda berlangsung beberapa hari, buat perulangan
                $period = new \DatePeriod(
                     $agenda->start_date,
                     new \DateInterval('P1D'),
                     $agenda->end_date->addDay() // Tambahkan 1 hari agar tanggal terakhir ikut dihitung
                );

                foreach ($period as $date) {
                    $events[] = [
                        'title' => $title,
                        'start' => $date->format('Y-m-d'), // Gunakan tanggal dari perulangan
                        'extendedProps' => $commonProps,
                    ];
                }
            }
        }

        return response()->json($events);
    }
}