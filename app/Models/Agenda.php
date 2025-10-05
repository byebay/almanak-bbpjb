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
     * Pastikan semua kolom dari form Anda ada di sini.
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'start_date', // Diubah dari agenda_date
        'end_date',
        'start_time',
        'end_time',
        'file_path',
        'status',
        'room_id', // <-- Pastikan ini ada
    ];

    /**
     * Casts atribut ke tipe data asli.
     */
    protected $casts = [
        'start_date' => 'date', // Diubah dari agenda_date
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}