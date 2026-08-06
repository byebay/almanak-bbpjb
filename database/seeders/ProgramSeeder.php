<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Wilayah;
use App\Models\User;
use Carbon\Carbon;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data program lama
        Program::query()->delete();

        $wilayahIds = Wilayah::pluck('id')->toArray();
        $adminId = User::where('role', 'super_admin')->first()?->id ?? User::first()?->id;

        $namaProgramTemplate = [
            'Program Peningkatan Kapasitas Guru',
            'Pembangunan Perpustakaan Digital Wilayah',
            'Pengembangan Infrastruktur Pendidikan Anak Usia Dini',
            'Program Literasi Digital bagi Masyarakat',
            'Pemberdayaan UMKM Kreatif Berbasis Komunitas',
            'Revitalisasi Pusat Seni dan Budaya Daerah',
            'Program Beasiswa Berprestasi Tingkat Menengah',
            'Pelatihan Keterampilan Vokasi Pemuda',
            'Penyediaan Akses Internet Ramah Anak',
            'Program Bimbingan Teknis Tenaga Kependidikan',
            'Pengadaan Sarana Laboratorium Komputer Sekolah',
            'Kampanye Sadar Membaca dan Menulis',
            'Pelestarian Bahasa dan Sastra Daerah',
            'Program Penguatan Karakter Siswa melalui Seni',
            'Workshop Penulisan Karya Ilmiah Guru',
            'Pengembangan Aplikasi Pembelajaran Mandiri',
            'Peningkatan Sarana Prasarana PAUD Nonformal',
            'Program Pendampingan Sertifikasi Pendidik',
            'Evaluasi Kinerja Mutu Pendidikan Wilayah',
            'Festival Kreativitas dan Inovasi Siswa'
        ];

        $timKerjaOptions = [
            [
                'tim' => 'Tim Kerja Pengembangan',
                'sub' => ['Kamus dan Istilah', 'BIPA']
            ],
            [
                'tim' => 'Tim Kerja Pembinaan',
                'sub' => ['Pembahu', 'Literasi', 'UKBI', 'Penerjemahan']
            ],
            [
                'tim' => 'Tim Kerja Pelindungan',
                'sub' => ['Molinbastra']
            ]
        ];

        for ($i = 0; $i < 20; $i++) {
            $startDate = Carbon::now()->subMonths(rand(1, 6))->addDays(rand(1, 30));
            $endDate = (clone $startDate)->addMonths(rand(1, 5));
            $selectedOption = $timKerjaOptions[array_rand($timKerjaOptions)];

            Program::create([
                'wilayah_id' => !empty($wilayahIds) ? $wilayahIds[array_rand($wilayahIds)] : null,
                'tim_kerja' => $selectedOption['tim'],
                'sub_tim_kerja' => $selectedOption['sub'][array_rand($selectedOption['sub'])],
                'nama_program' => $namaProgramTemplate[$i] ?? 'Program Unggulan Daerah ' . ($i + 1),
                'deskripsi' => 'Deskripsi untuk ' . ($namaProgramTemplate[$i] ?? 'Program Unggulan Daerah ' . ($i + 1)) . '. Program ini bertujuan untuk memberikan dampak positif berkelanjutan di wilayah sasaran dengan melibatkan pemangku kepentingan setempat.',
                'tahun' => $startDate->format('Y'),
                'tanggal_mulai' => $startDate->format('Y-m-d'),
                'tanggal_selesai' => $endDate->format('Y-m-d'),
                'file_path' => null,
                'created_by' => $adminId,
            ]);
        }
    }
}
