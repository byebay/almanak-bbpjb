<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\DailyAttendance;
use App\Models\LeaveRecord; // <-- 1. Import model baru
use App\Models\User;
use App\Models\Visitor;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VisitorStatsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

        // --- LOGIKA GRAFIK PENGUNJUNG ---
        $selectedMonth = request()->query('month', Carbon::today()->format('Y-m'));
        $selectedYear = request()->query('year', Carbon::today()->format('Y'));

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

        // 1. Data Harian (Bulan Pilihan)
        $dailyLabels = [];
        $dailyData = [];
        $daysInMonth = $carbonMonth->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = $carbonMonth->copy()->addDays($i - 1);
            $dailyLabels[] = $i; // Hanya angka tanggal
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

        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $monthSelect = $driver === 'sqlite' ? "strftime('%Y-%m', visit_date)" : ($driver === 'pgsql' ? "TO_CHAR(visit_date, 'YYYY-MM')" : "DATE_FORMAT(visit_date, '%Y-%m')");

        // 2. Data Bulanan (Tahun Pilihan)
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

        // 3. Data Tahunan (Kelipatan 5 Tahun)
        $currentYear = (int)Carbon::today()->year;
        $defaultStartYear = (int)(floor($currentYear / 5) * 5);
        $selectedYearRangeStart = (int)request()->query('year_range', $defaultStartYear);
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

        // Mengirim data yang sudah diolah dengan benar ke view
        return view('dashboard', [
            'pegawaiPalingAwal' => $pegawaiPalingAwal,
            'jumlahHadir' => $jumlahHadir,
            'jumlahTerlambat' => $jumlahTerlambat,
            'pegawaiCuti' => $pegawaiCuti,
            'pegawaiDinasLuar' => $pegawaiDinasLuar,
            'chartDataGrouped' => $chartDataGrouped,
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

    public function exportVisitorStats(Request $request)
    {
        $period = $request->query('period', 'daily'); // Default 'daily' jika tidak ada
        $month = $request->query('month');
        $year = $request->query('year');
        $year_range = $request->query('year_range');
        
        $periodName = 'Harian';
        if ($period === 'monthly') {
            $periodName = 'Bulanan';
        } elseif ($period === 'yearly') {
            $periodName = 'Tahunan';
        }

        $fileName = "Statistik_Pengunjung_{$periodName}_BBPJB_" . date('Ymd') . ".xlsx";
        return Excel::download(new VisitorStatsExport($period, $month, $year, $year_range), $fileName);
    }

    public function sebaranPegawai()
    {
        // Halaman peta kini menjadi satu dengan pengelolaan program.
        return redirect()->route('admin.programs.index');
    }
}
