<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\DailyAttendance;
use App\Models\LeaveRecord;
use App\Models\Visitor;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

        // --- LOGIKA STATISTIK PENGUNJUNG (Chart) ---
        $dailyLabels = [];
        $dailyData = [];
        $daysInMonth = Carbon::today()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = Carbon::today()->startOfMonth()->addDays($i - 1);
            $dailyLabels[] = $i;
            $dailyData[$date->format('Y-m-d')] = 0;
        }
        $visitorDaily = Visitor::whereNotNull('visit_date')
            ->where('visit_date', '>=', Carbon::today()->startOfMonth()->format('Y-m-d'))
            ->where('visit_date', '<=', Carbon::today()->endOfMonth()->format('Y-m-d'))
            ->select(DB::raw('visit_date as date'), DB::raw('count(*) as total'))
            ->groupBy('visit_date')
            ->get();
        foreach ($visitorDaily as $stat) {
            $dailyData[$stat->date] = $stat->total;
        }

        $driver = DB::connection()->getDriverName();
        $monthSelect = $driver === 'sqlite' ? "strftime('%Y-%m', visit_date)" : ($driver === 'pgsql' ? "TO_CHAR(visit_date, 'YYYY-MM')" : "DATE_FORMAT(visit_date, '%Y-%m')");

        $monthlyLabels = [];
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyLabels[] = Carbon::create()->month($i)->translatedFormat('M');
            $monthlyData[] = 0;
        }
        $monthlyStats = Visitor::whereNotNull('visit_date')
            ->where('visit_date', '>=', Carbon::today()->startOfYear()->format('Y-m-d'))
            ->where('visit_date', '<=', Carbon::today()->endOfYear()->format('Y-m-d'))
            ->select(DB::raw("{$monthSelect} as month"), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->get();
        foreach ($monthlyStats as $stat) {
            $monthIndex = (int)substr($stat->month, -2) - 1;
            if (isset($monthlyData[$monthIndex])) {
                $monthlyData[$monthIndex] = $stat->total;
            }
        }

        $yearSelect = $driver === 'sqlite' ? "strftime('%Y', visit_date)" : ($driver === 'pgsql' ? "EXTRACT(YEAR FROM visit_date)" : "YEAR(visit_date)");

        $yearlyLabels = [];
        $yearlyData = [];
        $currentYear = Carbon::today()->year;
        for ($i = 4; $i >= 0; $i--) {
            $yearlyLabels[] = (string)($currentYear - $i);
            $yearlyData[] = 0;
        }
        $yearlyStats = Visitor::whereNotNull('visit_date')
            ->where('visit_date', '>=', Carbon::today()->subYears(4)->startOfYear()->format('Y-m-d'))
            ->select(DB::raw("{$yearSelect} as year"), DB::raw('count(*) as total'))
            ->groupBy('year')
            ->get();
        foreach ($yearlyStats as $stat) {
            $yearIndex = array_search($stat->year, $yearlyLabels);
            if ($yearIndex !== false) {
                $yearlyData[$yearIndex] = $stat->total;
            }
        }

        $chartDataGrouped = [
            'daily' => [
                'labels' => $dailyLabels,
                'data' => array_values($dailyData),
                'subtitle' => 'Periode: ' . Carbon::today()->translatedFormat('F Y')
            ],
            'monthly' => [
                'labels' => $monthlyLabels,
                'data' => array_values($monthlyData),
                'subtitle' => 'Periode: Tahun ' . Carbon::today()->translatedFormat('Y')
            ],
            'yearly' => [
                'labels' => $yearlyLabels,
                'data' => array_values($yearlyData),
                'subtitle' => 'Periode: ' . Carbon::today()->subYears(4)->format('Y') . ' - ' . Carbon::today()->format('Y')
            ],
        ];
        
        return view('public-dashboard', compact('visitorCount', 'pegawaiPalingAwal', 'jumlahHadir', 'jumlahTerlambat', 'pegawaiCuti', 'pegawaiDinasLuar', 'chartDataGrouped'));
    }

    /**
     * Menyediakan data agenda untuk FullCalendar.
     */
    public function showWilayah($kode)
    {
        $wilayah = Wilayah::with('programs')->where('kode', $kode)->firstOrFail();

        return response()->json([
            'nama_wilayah' => $wilayah->nama_wilayah,
            'informasi' => $wilayah->informasi ?? 'Belum ada informasi umum untuk wilayah ini.',
            'programs' => $wilayah->programs->map(function ($program) {
                return [
                    'nama_program' => $program->nama_program,
                    'deskripsi' => $program->deskripsi,
                    'tahun' => $program->tahun,
                    'status' => $program->status,
                    'tanggal_mulai' => $program->tanggal_mulai,
                    'tanggal_selesai' => $program->tanggal_selesai,
                ];
            }),
        ]);
    }

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