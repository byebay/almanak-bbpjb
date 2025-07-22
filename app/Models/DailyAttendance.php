<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyAttendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'ac_no',
        'employee_name',
        'date',
        'check_in_time',
        'check_out_time',
        'status',
        'notes',
        'imported_by_user_id',
    ];

    /**
     * 2. TAMBAHKAN FUNGSI RELASI DI SINI
     * Mendefinisikan relasi bahwa setiap data absensi ini milik (belongs to) seorang User.
     */
    public function user(): BelongsTo
    {
        // Kode ini menghubungkan kolom 'ac_no' di tabel ini
        // dengan kolom 'nip' di tabel 'users'.
        return $this->belongsTo(User::class, 'ac_no', 'nip');
    }
}