<?php
namespace App\Imports;

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class CalendarAgendaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Ambil ID Super Admin sebagai pembuat default untuk data historis
        $superAdmin = User::where('role', 'super_admin')->first();
        $userId = $superAdmin ? $superAdmin->id : Auth::id();

        // Asumsi struktur Excel:
        // Baris 10 berisi hari (SENIN, SELASA, dst.)
        // Baris 11 & 12 berisi tanggal dan agenda
        // Baris 14 & 15 berisi tanggal dan agenda, dst.
        
        // Kita akan memproses Excel dalam blok 3 baris (header hari, baris tanggal, baris agenda)
        // Namun, untuk menyederhanakan, kita akan fokus pada baris yang berisi data agenda.
        // Asumsi: Baris 13, 16, dst. adalah baris agenda.
        
        foreach ($rows as $rowIndex => $row) {
            // Kita asumsikan baris data agenda ada di row Excel 13, 16, 19, dst.
            // Indeks di sini dimulai dari 0, dan ada 1 baris header, jadi kita cek index 11, 14, dst.
            if (($rowIndex - 11) % 3 !== 0) {
                continue; // Lewati baris yang bukan baris agenda
            }

            foreach ($row as $day => $agendaText) {
                if (empty($agendaText) || !isset($rows[$rowIndex-1][$day])) {
                    continue; // Lewati jika tidak ada teks agenda atau tidak ada tanggal di atasnya
                }

                $dateNumber = (int) $rows[$rowIndex-1][$day];
                if ($dateNumber === 0) {
                    continue; // Lewati jika tanggal tidak valid
                }

                // Ambil bulan dan tahun dari sheet (ini perlu penyesuaian manual)
                // Untuk contoh ini, kita hardcode Juli 2025
                $year = 2025;
                $month = 7; // Juli
                $date = \Carbon\Carbon::createFromDate($year, $month, $dateNumber);

                // Pisahkan beberapa agenda dalam satu sel
                $agendas = preg_split("/\r\n|\n|\r/", $agendaText);

                foreach ($agendas as $singleAgenda) {
                    $cleanedAgenda = trim(preg_replace('/^[0-9]+\.\s*/', '', $singleAgenda));
                    if (!empty($cleanedAgenda)) {
                        Agenda::create([
                            'title'         => $cleanedAgenda,
                            'description'   => 'Data diimpor dari almanak lama.',
                            'agenda_date'   => $date->format('Y-m-d'),
                            'start_time'    => '08:00:00', // Waktu default
                            'end_time'      => '17:00:00', // Waktu default
                            'status'        => 'Terpublikasi',
                            'user_id'       => $userId,
                            'room_id'       => null, // Ruangan opsional
                        ]);
                    }
                }
            }
        }
    }
}
