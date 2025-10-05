<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\DailyAttendance;
use App\Models\LeaveRecord;
use App\Models\Room;
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

            $endDateForCalendar = null;
            if ($agenda->end_date) {
                $endDateForCalendar = $agenda->end_date->addDay()->format('Y-m-d');
            }

            $events[] = [
                'title' => $title,
                'start' => $agenda->start_date->format('Y-m-d'),
                'end'   => $endDateForCalendar,
                'extendedProps' => [
                    'description' => $agenda->description,
                    'start_time' => Carbon::parse($agenda->start_time)->format('H:i'),
                    'end_time' => Carbon::parse($agenda->end_time)->format('H:i'),
                    'file_url' => $agenda->file_path ? asset('storage/' . $agenda->file_path) : null,
                    'room_name' => $agenda->room ? $agenda->room->name : null,
                ]
            ];
        }
        return response()->json($events);
    }
}