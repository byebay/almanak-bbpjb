<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agenda;
use App\Models\User;
use App\Models\Room;

class AgendaSeeder extends Seeder
{
    public function run(): void
    {
        Agenda::query()->delete(); // Hapus data lama
        $pegawais = User::where('role', 'pegawai')->get();
        $rooms = Room::all();

        if ($pegawais->isNotEmpty() && $rooms->isNotEmpty()) {
            Agenda::create([
                'title' => 'Rapat Koordinasi Awal Bulan',
                'description' => 'Membahas rencana kerja bulan Agustus.',
                'start_date' => now()->startOfMonth()->addDays(5)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '11:00:00',
                'status' => 'Terpublikasi',
                'user_id' => $pegawais->random()->id,
                'room_id' => $rooms->firstWhere('name', 'Ruang Rapat Sumbawa')->id,
            ]);

            Agenda::create([
                'title' => 'Bimbingan Teknis Penulisan',
                'description' => 'Pelatihan untuk para penulis pemula.',
                'start_date' => now()->startOfMonth()->addDays(10)->toDateString(),
                'start_time' => '13:00:00',
                'end_time' => '15:00:00',
                'status' => 'Terpublikasi',
                'user_id' => $pegawais->random()->id,
                'room_id' => $rooms->firstWhere('name', 'Aula Merdeka')->id,
            ]);

             Agenda::create([
                'title' => 'Diskusi Kelompok Terpumpun',
                'description' => 'Diskusi internal KKLP Penerjemahan.',
                'start_date' => now()->startOfMonth()->addDays(12)->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
                'status' => 'Terpublikasi',
                'user_id' => $pegawais->random()->id, // Agenda tanpa ruangan
            ]);
        }
    }
}