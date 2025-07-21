<?php
namespace App\Imports;

use App\Models\DailyAttendance;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DailyAttendanceImport implements ToModel, WithHeadingRow
{
    private $reportDate;

    public function __construct(string $reportDate)
    {
        $this->reportDate = $reportDate;
    }

    public function model(array $row)
    {
        $formattedRow = collect($row)->mapWithKeys(fn($v, $k) => [Str::snake(strtolower($k)) => $v]);

        // Validasi: Lewati baris jika ID atau Nama kosong
        if (empty($formattedRow['id_pegawai']) || empty($formattedRow['nama'])) {
            return null;
        }

        // Validasi: Lewati baris jika KEDUA jam (masuk dan keluar) tidak valid/kosong
        if (!is_numeric($formattedRow['masuk']) && !is_numeric($formattedRow['keluar'])) {
            return null;
        }

        $checkIn = is_numeric($formattedRow['masuk']) ? Date::excelToDateTimeObject($formattedRow['masuk'])->format('H:i:s') : null;
        $checkOut = is_numeric($formattedRow['keluar']) ? Date::excelToDateTimeObject($formattedRow['keluar'])->format('H:i:s') : null;

        $status = 'Hadir';
        if ($checkIn && $checkIn > '07:30:00') {
            $status = 'Terlambat';
        }

        return new DailyAttendance([
            'ac_no'           => $formattedRow['id_pegawai'],
            'employee_name'   => $formattedRow['nama'],
            'date'            => $this->reportDate,
            'check_in_time'   => $checkIn,
            'check_out_time'  => $checkOut,
            'status'          => $status,
            'imported_by_user_id' => Auth::id(),
        ]);
    }
}