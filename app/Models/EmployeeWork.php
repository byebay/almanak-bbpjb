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
        'title',
        'description',
        'file_path',
        'file_type',
    ];

    // Definisikan relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}