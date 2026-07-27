<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Wilayah;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = resource_path('data/jabar_slugs.json');
        
        if (File::exists($jsonPath)) {
            $json = File::get($jsonPath);
            $data = json_decode($json, true);
            
            foreach ($data as $kode => $nama) {
                if ($kode === 'jabar') continue; // Skip Jabar map parent
                
                Wilayah::firstOrCreate(
                    ['kode' => $kode],
                    ['nama_wilayah' => $nama]
                );
            }
        }
    }
}
