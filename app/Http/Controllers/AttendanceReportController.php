<?php
namespace App\Http\Controllers;

use App\Models\DailyAttendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceReportController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->input('date', Carbon::today()->toDateString());

        // 1. Ambil SEMUA user yang seharusnya diabsen
        $allEmployees = User::where('role', '!=', 'super_admin')->orderBy('name')->get();

        // 2. Ambil data absensi yang SUDAH ADA untuk tanggal yang dipilih
        $attendanceLogs = DailyAttendance::where('date', $selectedDate)
                                         ->get()
                                         ->keyBy('ac_no'); // Jadikan NIP sebagai kunci untuk pencarian cepat

        // 3. Buat laporan terpadu
        $reportData = $allEmployees->map(function ($employee) use ($attendanceLogs) {
            $log = $attendanceLogs->get($employee->nip);

            if ($log) {
                // Jika data ditemukan di log absensi
                return [
                    'user_id' => $employee->id,
                    'name' => $employee->name,
                    'check_in_time' => $log->check_in_time,
                    'check_out_time' => $log->check_out_time,
                    'status' => $log->status,
                    'notes' => $log->notes,
                ];
            } else {
                // Jika data TIDAK ditemukan, beri status default
                return [
                    'user_id' => $employee->id,
                    'name' => $employee->name,
                    'check_in_time' => null,
                    'check_out_time' => null,
                    'status' => 'Tanpa Keterangan',
                    'notes' => null,
                ];
            }
        });

        // Urutkan berdasarkan status, lalu jam masuk
        $reportData = $reportData->sortBy(function($item) {
            $statusOrder = ['Hadir' => 1, 'Terlambat' => 2, 'Dinas Luar' => 3, 'Cuti' => 4, 'Tanpa Keterangan' => 5];
            return $statusOrder[$item['status']] . ($item['check_in_time'] ?? '23:59:59');
        });

        return view('reports.attendance', compact('reportData', 'selectedDate'));
    }

    // Fungsi updateStatus tidak perlu diubah, sudah benar
    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:Cuti,Dinas Luar,Tanpa Keterangan',
            'notes' => 'nullable|string',
        ]);

        $user = User::find($validated['user_id']);

        DailyAttendance::updateOrCreate(
            ['ac_no' => $user->nip, 'date'  => $validated['date']],
            [
                'employee_name' => $user->name,
                'status' => $validated['status'],
                'notes' => $validated['notes'],
                'check_in_time' => null,
                'check_out_time' => null,
                'imported_by_user_id' => Auth::id(),
            ]
        );

        return back()->with('success', 'Status kehadiran untuk ' . $user->name . ' berhasil diperbarui.');
    }
}