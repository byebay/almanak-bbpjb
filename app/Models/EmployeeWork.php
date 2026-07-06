<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeWork extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'year',
        'month',
        'work_date',
        'title',
        'description',
        'file_path',
        'file_type',
    ];
    protected $casts = [
        'work_date' => 'date', // <-- Tambahkan ini
    ];

    // Definisikan relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}