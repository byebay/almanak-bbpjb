<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'wilayah_id',
        'nama_program',
        'deskripsi',
        'tahun',
    ];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }
}
