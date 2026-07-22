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
    public function __construct(public string $period) {}

    public function view(): View
    {
        $stats = collect();
        $title = '';

        if ($this->period === 'daily') {
            $title = 'Laporan Pengunjung Harian (Bulan Ini)';
            $stats = Visitor::whereNotNull('visit_date')
                ->where('visit_date', '>=', Carbon::today()->startOfMonth()->format('Y-m-d'))
                ->where('visit_date', '<=', Carbon::today()->endOfMonth()->format('Y-m-d'))
                ->select(DB::raw('visit_date as date'), DB::raw('count(*) as total'))
                ->groupBy('visit_date')
                ->orderBy('visit_date', 'asc')
                ->get();
        } elseif ($this->period === 'monthly') {
            $title = 'Laporan Pengunjung Bulanan (Tahun Ini)';
            $stats = Visitor::whereNotNull('visit_date')
                ->where('visit_date', '>=', Carbon::today()->startOfYear()->format('Y-m-d'))
                ->where('visit_date', '<=', Carbon::today()->endOfYear()->format('Y-m-d'))
                ->select(DB::raw("TO_CHAR(visit_date, 'YYYY-MM') as month"), DB::raw('count(*) as total'))
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();
        } elseif ($this->period === 'yearly') {
            $title = 'Laporan Pengunjung Tahunan (5 Tahun Terakhir)';
            $stats = Visitor::whereNotNull('visit_date')
                ->where('visit_date', '>=', Carbon::today()->subYears(4)->startOfYear()->format('Y-m-d'))
                ->select(DB::raw("EXTRACT(YEAR FROM visit_date) as year"), DB::raw('count(*) as total'))
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
