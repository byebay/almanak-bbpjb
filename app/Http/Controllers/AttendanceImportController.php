<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DailyAttendanceImport;

class AttendanceImportController extends Controller
{
    public function create()
    {
        return view('attendances.import');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'attendance_file' => 'required|mimes:xls,xlsx',
            'report_date'     => 'required|date',
        ]);
        Excel::import(new DailyAttendanceImport($validated['report_date']), $request->file('attendance_file'));
        return redirect()->route('reports.attendance.index', ['date' => $validated['report_date']])
                         ->with('success', 'Data absensi berhasil diimpor!');
    }
}