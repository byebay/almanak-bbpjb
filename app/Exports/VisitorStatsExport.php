<?php

namespace App\Exports;

use App\Models\Visitor;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VisitorStatsExport implements FromView, ShouldAutoSize
{
    public function __construct(
        public string $period,
        public ?string $month = null,
        public ?string $year = null,
        public ?string $year_range = null
    ) {}

    public function view(): View
    {
        $stats = collect();
        $title = '';

        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $monthSelect = $driver === 'sqlite' ? "strftime('%Y-%m', visit_date)" : ($driver === 'pgsql' ? "TO_CHAR(visit_date, 'YYYY-MM')" : "DATE_FORMAT(visit_date, '%Y-%m')");
        $yearSelect = $driver === 'sqlite' ? "strftime('%Y', visit_date)" : ($driver === 'pgsql' ? "EXTRACT(YEAR FROM visit_date)" : "YEAR(visit_date)");

        if ($this->period === 'daily') {
            try {
                $carbonMonth = $this->month ? Carbon::createFromFormat('Y-m', $this->month)->startOfMonth() : Carbon::today()->startOfMonth();
            } catch (\Exception $e) {
                $carbonMonth = Carbon::today()->startOfMonth();
            }
            $title = 'Laporan Pengunjung Harian (' . $carbonMonth->locale('id')->translatedFormat('F Y') . ')';
            $stats = Visitor::whereNotNull('visit_date')
                ->where('visit_date', '>=', $carbonMonth->copy()->startOfMonth()->format('Y-m-d'))
                ->where('visit_date', '<=', $carbonMonth->copy()->endOfMonth()->format('Y-m-d'))
                ->select(DB::raw('visit_date as date'), DB::raw('count(*) as total'))
                ->groupBy('visit_date')
                ->orderBy('visit_date', 'asc')
                ->get();
        } elseif ($this->period === 'monthly') {
            try {
                $carbonYear = $this->year ? Carbon::createFromFormat('Y', $this->year)->startOfYear() : Carbon::today()->startOfYear();
            } catch (\Exception $e) {
                $carbonYear = Carbon::today()->startOfYear();
            }
            $title = 'Laporan Pengunjung Bulanan (Tahun ' . $carbonYear->format('Y') . ')';
            $stats = Visitor::whereNotNull('visit_date')
                ->where('visit_date', '>=', $carbonYear->copy()->startOfYear()->format('Y-m-d'))
                ->where('visit_date', '<=', $carbonYear->copy()->endOfYear()->format('Y-m-d'))
                ->select(DB::raw("{$monthSelect} as month"), DB::raw('count(*) as total'))
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();
        } elseif ($this->period === 'yearly') {
            $currentYear = (int)Carbon::today()->year;
            $defaultStartYear = (int)(floor($currentYear / 5) * 5);
            $startYear = (int)($this->year_range ?? $defaultStartYear);
            $endYear = $startYear + 4;
            $title = "Laporan Pengunjung Tahunan ({$startYear} - {$endYear})";
            $stats = Visitor::whereNotNull('visit_date')
                ->where('visit_date', '>=', Carbon::create($startYear, 1, 1)->startOfYear()->format('Y-m-d'))
                ->where('visit_date', '<=', Carbon::create($endYear, 12, 31)->endOfYear()->format('Y-m-d'))
                ->select(DB::raw("{$yearSelect} as year"), DB::raw('count(*) as total'))
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();
        }

        return view('exports.visitor_stats', [
            'period' => $this->period,
            'title' => $title,
            'stats' => $stats,
        ]);
    }
}
