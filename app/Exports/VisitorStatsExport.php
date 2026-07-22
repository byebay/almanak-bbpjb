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
    public function view(): View
    {
        $dailyStats = Visitor::whereNotNull('visit_date')->select(
            DB::raw('visit_date as date'),
            DB::raw('count(*) as total')
        )
        ->groupBy('visit_date')
        ->orderBy('visit_date', 'desc')
        ->get();

        $monthlyStats = Visitor::whereNotNull('visit_date')->select(
            DB::raw("TO_CHAR(visit_date, 'YYYY-MM') as month"),
            DB::raw('count(*) as total')
        )
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->get();

        $yearlyStats = Visitor::whereNotNull('visit_date')->select(
            DB::raw("EXTRACT(YEAR FROM visit_date) as year"),
            DB::raw('count(*) as total')
        )
        ->groupBy('year')
        ->orderBy('year', 'desc')
        ->get();

        return view('exports.visitor_stats', [
            'dailyStats' => $dailyStats,
            'monthlyStats' => $monthlyStats,
            'yearlyStats' => $yearlyStats,
        ]);
    }
}
