<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data user lama untuk menghindari duplikasi
        User::query()->delete();

        // Buat 3 Akun Admin Utama dengan NIP & Password yang mudah diingat
        User::create([
            'name' => 'Super Administrator',
            'nip' => '111111111',
            'email' => 'superadmin@bbjb.test',
            'role' => 'super_admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Admin Kepegawaian',
            'nip' => '222222222',
            'email' => 'kepegawaian@bbjb.test',
            'role' => 'admin_kepegawaian',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Admin Anggaran',
            'nip' => '333333333',
            'email' => 'anggaran@bbjb.test',
            'role' => 'admin_anggaran',
            'password' => Hash::make('password'),
        ]);

        // Buat 37 Pegawai biasa menggunakan Factory
        // Total akan ada 40 pengguna di database
        User::factory(37)->create();
    }
}