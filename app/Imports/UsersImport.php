<?php
namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $formattedRow = collect($row)->mapWithKeys(fn($v, $k) => [Str::snake(strtolower($k)) => $v]);

        if (empty($formattedRow['nip'])) {
            return null;
        }

        $employeeName = $formattedRow['nama'];
        $baseFileName = str_replace(' ', '_', $employeeName);
        $baseFileName = preg_replace('/[^A-Za-z0-9_]/', '', $baseFileName);
        $photoPath = null;
        $possibleExtensions = ['jpg', 'jpeg', 'png'];

        foreach ($possibleExtensions as $ext) {
            $path = 'photos/pegawai/' . $baseFileName . '.' . $ext;
            if (Storage::disk('public')->exists($path)) {
                $photoPath = $path;
                break;
            }
        }

        return User::updateOrCreate(
            ['nip' => $formattedRow['nip']],
            [
                'name'     => $employeeName,
                'email'    => $formattedRow['nip'] . '@bbpjb.test',
                'password' => Hash::make('sandi123'),
                'role'     => 'pegawai',
                'birth_date' => $formattedRow['tanggal_lahir'],
                'photo_path' => $photoPath,
                'shareable_token' => Str::random(60),
            ]
        );
    }
}