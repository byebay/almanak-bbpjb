<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KinerjaDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'kinerja_id', 
        'pelaksana', 
        'deskripsi_pekerjaan', 
        'realisasi_target', 
        'progres_kegiatan', 
        'kendala', 
        'strategi_penyelesaian', 
        'file_bukti'
    ];

    /**
     * Mendefinisikan bahwa satu Detail Kinerja milik satu Kinerja utama.
     */
    public function kinerja(): BelongsTo
    {
        return $this->belongsTo(Kinerja::class);
    }
}