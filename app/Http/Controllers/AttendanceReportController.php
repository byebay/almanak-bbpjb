<?php
namespace App\Http\Controllers;

use App\Models\DailyAttendance;
use App\Models\LeaveRecord; // <-- Import model baru
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->input('date', Carbon::today()->toDateString());

        $allEmployees = User::where('role', '!=', 'super_admin')->orderBy('name')->get();
        $attendanceLogs = DailyAttendance::where('date', $selectedDate)->get()->keyBy('ac_no');
        
        // Ambil data cuti/dinas luar yang relevan untuk tanggal yang dipilih
        $leaveLogs = LeaveRecord::where('start_date', '<=', $selectedDate)
                                ->where('end_date', '>=', $selectedDate)
                                ->get()
                                ->keyBy('user_id');

        $reportData = $allEmployees->map(function ($employee) use ($attendanceLogs, $leaveLogs) {
            // Prioritas 1: Cek data Cuti/DL
            if ($leave = $leaveLogs->get($employee->id)) {
                return [
                    'name' => $employee->name, 'check_in_time' => null, 'check_out_time' => null,
                    'status' => $leave->status, 'notes' => $leave->notes
                ];
            }
            // Prioritas 2: Cek data dari Excel
            if ($log = $attendanceLogs->get($employee->nip)) {
                return [
                    'name' => $employee->name, 'check_in_time' => $log->check_in_time, 'check_out_time' => $log->check_out_time,
                    'status' => $log->status, 'notes' => $log->notes
                ];
            }
            // Prioritas 3: Jika tidak ada data sama sekali
            return [
                'name' => $employee->name, 'check_in_time' => null, 'check_out_time' => null,
                'status' => 'Tanpa Keterangan', 'notes' => null
            ];
        });

        // Urutkan berdasarkan status, lalu jam masuk
        $reportData = $reportData->sortBy(function($item) {
            $statusOrder = ['Hadir' => 1, 'Terlambat' => 2, 'Dinas Luar' => 3, 'Cuti' => 4, 'Tanpa Keterangan' => 5];
            return ($statusOrder[$item['status']] ?? 99) . ($item['check_in_time'] ?? '23:59:59');
        });

        return view('reports.attendance', compact('reportData', 'selectedDate'));
    }

    // HAPUS FUNGSI updateStatus() DARI CONTROLLER INI
}
