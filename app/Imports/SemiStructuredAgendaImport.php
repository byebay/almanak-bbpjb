<?php
namespace App\Imports;

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SemiStructuredAgendaImport implements ToCollection
{
    private $year;
    private $month;

    public function __construct(int $year, int $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function collection(Collection $rows)
    {
        $superAdmin = User::where('role', 'super_admin')->first();
        $userId = $superAdmin ? $superAdmin->id : Auth::id();

        // Ambil baris pertama untuk tanggal dan baris kedua untuk agenda
        $dateRow = $rows->get(0);
        $agendaRow = $rows->get(1);

        if (!$dateRow || !$agendaRow) {
            return; // Hentikan jika format tidak sesuai (kurang dari 2 baris)
        }

        // Iterasi melalui setiap kolom di baris tanggal
        foreach ($dateRow as $colIndex => $dateNumber) {
            // Jika sel tanggal kosong atau tidak valid, lewati kolom ini
            if (empty($dateNumber) || !is_numeric($dateNumber) || $dateNumber > 31) {
                continue;
            }

            // Buat objek tanggal yang valid
            try {
                $date = Carbon::createFromDate($this->year, $this->month, (int)$dateNumber);
            } catch (\Exception $e) {
                continue; // Lewati jika tanggal tidak valid (misal: 31 Februari)
            }

            // Ambil konten agenda dari baris kedua pada kolom yang sama
            $cellContent = $agendaRow[$colIndex] ?? null;

            if ($cellContent) {
                $this->createAgendasFromCell($cellContent, $date, $userId);
            }
        }
    }

    /**
     * Helper function untuk membuat agenda dari satu sel yang mungkin berisi banyak baris.
     */
    private function createAgendasFromCell($cellContent, $date, $userId)
    {
        // Pisahkan beberapa agenda dalam satu sel berdasarkan baris baru
        $agendas = preg_split("/\r\n|\n|\r/", $cellContent);

        foreach ($agendas as $singleAgenda) {
            // Hapus nomor di awal (misal: "1. Rapat") dan spasi ekstra
            $cleanedAgenda = trim(preg_replace('/^[0-9]+\.\s*/', ' ', $singleAgenda));
            
            if (!empty($cleanedAgenda)) {
                Agenda::create([
                    'title'         => $cleanedAgenda,
                    'description'   => 'Data diimpor dari almanak lama.',
                    'agenda_date'   => $date->format('Y-m-d'),
                    'start_time'    => '08:00:00', // Waktu default
                    'end_time'      => '16:00:00', // Waktu default
                    'status'        => 'Terpublikasi',
                    'user_id'       => $userId,
                ]);
            }
        }
    }
}
