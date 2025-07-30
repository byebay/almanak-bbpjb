<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'agenda_date',
        'start_time',
        'end_time',
        'file_path',
        'status',
    ];

    /**
     * Casts atribut ke tipe data asli.
     */
    protected $casts = [
        'agenda_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'password' => 'hashed', // Tambahkan ini jika belum ada, praktik yang baik
    ];

    /**
     * Mendefinisikan relasi bahwa Agenda ini milik seorang User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}