<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::query()->delete(); // Hapus data lama
        Room::create(['name' => 'Aula Merdeka', 'location' => 'Gedung Utama, Lt. 3', 'capacity' => 100]);
        Room::create(['name' => 'Ruang Rapat Sumbawa', 'location' => 'Gedung Utama, Lt. 2', 'capacity' => 25]);
        Room::create(['name' => 'Ruang Diskusi', 'location' => 'Gedung Perpustakaan', 'capacity' => 10]);
    }
}
