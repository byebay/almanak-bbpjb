<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agenda extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
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
     *
     * @var array<string, string>
     */
    protected $casts = [
        'agenda_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Mendefinisikan relasi bahwa Agenda ini milik seorang User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
