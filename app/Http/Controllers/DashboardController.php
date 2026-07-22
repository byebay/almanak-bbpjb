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

        // 1. Data Harian (Bulan Ini)
        $dailyLabels = [];
        $dailyData = [];
        $daysInMonth = Carbon::today()->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = Carbon::today()->startOfMonth()->addDays($i - 1);
            $dailyLabels[] = $i; // Hanya angka tanggal
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

        // 2. Data Bulanan (Tahun Ini)
        $monthlyLabels = [];
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::today()->startOfYear()->addMonths($i - 1);
            $monthlyLabels[] = $month->translatedFormat('M'); // Hanya singkatan bulan
            $monthlyData[$month->format('Y-m')] = 0;
        }
        $visitorMonthly = Visitor::whereNotNull('visit_date')
            ->where('visit_date', '>=', Carbon::today()->startOfYear()->format('Y-m-d'))
            ->where('visit_date', '<=', Carbon::today()->endOfYear()->format('Y-m-d'))
            ->select(DB::raw("TO_CHAR(visit_date, 'YYYY-MM') as month"), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->get();
        foreach ($visitorMonthly as $stat) {
            if (isset($monthlyData[$stat->month])) {
                $monthlyData[$stat->month] = $stat->total;
            }
        }

        // 3. Data Tahunan (5 Tahun Terakhir)
        $yearlyLabels = [];
        $yearlyData = [];
        for ($i = 4; $i >= 0; $i--) {
            $year = Carbon::today()->subYears($i)->format('Y');
            $yearlyLabels[] = $year;
            $yearlyData[$year] = 0;
        }
        $visitorYearly = Visitor::whereNotNull('visit_date')
            ->where('visit_date', '>=', Carbon::today()->subYears(4)->startOfYear()->format('Y-m-d'))
            ->select(DB::raw("EXTRACT(YEAR FROM visit_date) as year"), DB::raw('count(*) as total'))
            ->groupBy('year')
            ->get();
        foreach ($visitorYearly as $stat) {
            if (isset($yearlyData[$stat->year])) {
                $yearlyData[$stat->year] = $stat->total;
            }
        }

        $chartDataGrouped = [
            'daily' => [
                'labels' => $dailyLabels,
                'data' => array_values($dailyData),
                'subtitle' => 'Periode: ' . Carbon::today()->translatedFormat('F Y') // Contoh: Periode: Juli 2026
            ],
            'monthly' => [
                'labels' => $monthlyLabels,
                'data' => array_values($monthlyData),
                'subtitle' => 'Periode: Tahun ' . Carbon::today()->translatedFormat('Y') // Contoh: Periode: Tahun 2026
            ],
            'yearly' => [
                'labels' => $yearlyLabels,
                'data' => array_values($yearlyData),
                'subtitle' => 'Periode: ' . Carbon::today()->subYears(4)->format('Y') . ' - ' . Carbon::today()->format('Y')
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

    public function exportVisitorStats()
    {
        return Excel::download(new VisitorStatsExport, 'Statistik_Pengunjung_BBPJB_'.date('Ymd').'.xlsx');
    }
}
