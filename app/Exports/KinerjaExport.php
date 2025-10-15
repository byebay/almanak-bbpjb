<?php

namespace App\Exports;

use App\Models\Kinerja;
use App\Models\KinerjaDetail; // PENTING: Kita akan mengambil data dari KinerjaDetail
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Carbon;

class KinerjaExport implements FromQuery, WithHeadings, WithMapping
{
    protected $year;
    protected $month;
    protected $userId;

    public function __construct(int $year, int $month, int $userId)
    {
        $this->year = $year;
        $this->month = $month;
        $this->userId = $userId;
    }

    /**
    * @return \Illuminate\Database\Query\Builder
    */
    public function query()
    {
        // Ambil semua detail kinerja yang induk 'kinerja'-nya
        // cocok dengan user, tahun, dan bulan yang dipilih.
        return KinerjaDetail::query()
            ->with('kinerja') // Eager load relasi ke tabel 'kinerjas'
            ->whereHas('kinerja', function ($query) {
                $query->where('user_id', $this->userId)
                      ->whereYear('bulan_tahun', $this->year)
                      ->whereMonth('bulan_tahun', $this->month);
            });
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        // Ini adalah judul kolom di file Excel, gabungan dari kedua tabel
        return [
            'Judul Kegiatan',
            'Target Kinerja',
            'Bulan Laporan',
            'Pelaksana',
            'Deskripsi Pekerjaan',
            'Realisasi Target',
            'Progres Kegiatan (%)',
            'Kendala',
            'Strategi Penyelesaian',
        ];
    }

    /**
    * @param KinerjaDetail $detail
    * @return array
    */
    public function map($detail): array
    {
        // Ini memetakan setiap baris data ke kolom yang sesuai
        return [
            // Data dari tabel 'kinerjas' (induk)
            $detail->kinerja->judul_kegiatan,
            $detail->kinerja->target_kinerja,
            Carbon::parse($detail->kinerja->bulan_tahun)->translatedFormat('F Y'),

            // Data dari tabel 'kinerjas_details' (anak)
            $detail->pelaksana,
            $detail->deskripsi_pekerjaan,
            $detail->realisasi_target,
            $detail->progres_kegiatan,
            $detail->kendala,
            $detail->strategi_penyelesaian,
        ];
    }
}