<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';

    protected $fillable = [
        'kode',
        'nama_wilayah',
        'informasi',
    ];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}
