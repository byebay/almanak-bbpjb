<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\DailyAttendance;
use App\Models\LeaveRecord;
use App\Models\Visitor;
use App\Models\Program;
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
        $selectedMonth = $request->query('month', Carbon::today()->format('Y-m'));
        $selectedYear = $request->query('year', Carbon::today()->format('Y'));

        try {
            $carbonMonth = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();
        } catch (\Exception $e) {
            $carbonMonth = Carbon::today()->startOfMonth();
            $selectedMonth = $carbonMonth->format('Y-m');
        }

        try {
            $carbonYear = Carbon::createFromFormat('Y', $selectedYear)->startOfYear();
        } catch (\Exception $e) {
            $carbonYear = Carbon::today()->startOfYear();
            $selectedYear = $carbonYear->format('Y');
        }

        $dailyLabels = [];
        $dailyData = [];
        $daysInMonth = $carbonMonth->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = $carbonMonth->copy()->addDays($i - 1);
            $dailyLabels[] = $i;
            $dailyData[$date->format('Y-m-d')] = 0;
        }
        $visitorDaily = Visitor::whereNotNull('visit_date')
            ->where('visit_date', '>=', $carbonMonth->copy()->startOfMonth()->format('Y-m-d'))
            ->where('visit_date', '<=', $carbonMonth->copy()->endOfMonth()->format('Y-m-d'))
            ->select(DB::raw('visit_date as date'), DB::raw('count(*) as total'))
            ->groupBy('visit_date')
            ->get();
        foreach ($visitorDaily as $stat) {
            $dailyData[$stat->date] = $stat->total;
        }

        $driver = DB::connection()->getDriverName();
        $monthSelect = $driver === 'sqlite' ? "strftime('%Y-%m', visit_date)" : ($driver === 'pgsql' ? "TO_CHAR(visit_date, 'YYYY-MM')" : "DATE_FORMAT(visit_date, '%Y-%m')");

        $monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyData = array_fill(0, 12, 0);
        $monthlyStats = Visitor::whereNotNull('visit_date')
            ->where('visit_date', '>=', $carbonYear->copy()->startOfYear()->format('Y-m-d'))
            ->where('visit_date', '<=', $carbonYear->copy()->endOfYear()->format('Y-m-d'))
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

        $currentYear = (int)Carbon::today()->year;
        $defaultStartYear = (int)(floor($currentYear / 5) * 5);
        $selectedYearRangeStart = (int)$request->query('year_range', $defaultStartYear);
        $selectedYearRangeEnd = $selectedYearRangeStart + 4;

        $yearlyLabels = [];
        $yearlyData = [];
        for ($y = $selectedYearRangeStart; $y <= $selectedYearRangeEnd; $y++) {
            $yearlyLabels[] = (string)$y;
            $yearlyData[(string)$y] = 0;
        }

        $yearlyStats = Visitor::whereNotNull('visit_date')
            ->where('visit_date', '>=', Carbon::create($selectedYearRangeStart, 1, 1)->startOfYear()->format('Y-m-d'))
            ->where('visit_date', '<=', Carbon::create($selectedYearRangeEnd, 12, 31)->endOfYear()->format('Y-m-d'))
            ->select(DB::raw("{$yearSelect} as year"), DB::raw('count(*) as total'))
            ->groupBy('year')
            ->get();

        foreach ($yearlyStats as $stat) {
            $yStr = (string)$stat->year;
            if (isset($yearlyData[$yStr])) {
                $yearlyData[$yStr] = $stat->total;
            }
        }

        $chartDataGrouped = [
            'daily' => [
                'labels' => $dailyLabels,
                'data' => array_values($dailyData),
                'subtitle' => 'Periode: ' . $carbonMonth->locale('id')->translatedFormat('F Y'),
                'selectedMonth' => $selectedMonth,
            ],
            'monthly' => [
                'labels' => $monthlyLabels,
                'data' => array_values($monthlyData),
                'subtitle' => 'Periode: Tahun ' . $carbonYear->translatedFormat('Y'),
                'selectedYear' => $selectedYear,
            ],
            'yearly' => [
                'labels' => $yearlyLabels,
                'data' => array_values($yearlyData),
                'subtitle' => 'Periode: ' . $selectedYearRangeStart . ' - ' . $selectedYearRangeEnd,
                'selectedYearRange' => $selectedYearRangeStart,
            ],
        ];

        // --- JUMLAH PROGRAM PER WILAYAH (untuk tooltip peta) ---
        $programCountByKode = Wilayah::withCount('programs')
        ->pluck('programs_count', 'kode');
        
        $allProgramsData = Program::with('wilayah:id,kode')->get([
            'id',
            'nama_program',
            'tim_kerja',
            'sub_tim_kerja',
            'wilayah_id',
            'tanggal_mulai',
            'tanggal_selesai',
            'deskripsi',
            'file_path',
        ]);

        return view('public-dashboard', compact('visitorCount', 'pegawaiPalingAwal', 'jumlahHadir', 'jumlahTerlambat', 'pegawaiCuti', 'pegawaiDinasLuar', 'chartDataGrouped', 'programCountByKode', 'allProgramsData'));
    }

    /**
     * Menyediakan data agenda untuk FullCalendar.
     */
    public function showWilayah($kode)
    {
        $wilayah = Wilayah::where('kode', $kode)->firstOrFail();
        $programs = $wilayah->programs()->orderByRaw('tanggal_mulai DESC, id DESC')->get();

        return response()->json([
            'nama_wilayah' => $wilayah->nama_wilayah,
            'informasi' => $wilayah->informasi,
            'programs' => $programs->map(function ($program) {
                return [
                    'id' => $program->id,
                    'nama_program' => $program->nama_program,
                    'tim_kerja' => $program->tim_kerja,
                    'sub_tim_kerja' => $program->sub_tim_kerja,
                    'deskripsi' => $program->deskripsi,
                    'tanggal_mulai' => $program->tanggal_mulai,
                    'tanggal_selesai' => $program->tanggal_selesai,
                    'file_path' => $program->file_path,
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
