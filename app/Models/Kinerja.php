<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kinerja extends Model
{
    use HasFactory;

    protected $table = 'kinerjas'; // Sesuaikan dengan nama tabel plural

    protected $fillable = [
        'user_id', 
        'judul_kegiatan', 
        'target_kinerja', 
        'bulan_tahun'
    ];

    /**
     * Mendefinisikan bahwa satu Kinerja memiliki banyak Detail Kinerja.
     */
    public function details(): HasMany
    {
        return $this->hasMany(KinerjaDetail::class);
    }
}