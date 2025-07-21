<?php
namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
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

        return User::updateOrCreate(
            ['nip' => $formattedRow['nip']],
            [
                'name'     => $formattedRow['nama'],
                'email'    => $formattedRow['nip'] . '@bbpjb.test',
                'password' => Hash::make('password123'),
                'role'     => 'pegawai',
                'birth_date' => $formattedRow['tanggal_lahir'],
                // ---------------------------------
            ]
        );
    }
}