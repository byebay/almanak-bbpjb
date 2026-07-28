<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'wilayah_id',
        'nama_program',
        'deskripsi',
        'tahun',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'file_path',
        'created_by',
    ];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
