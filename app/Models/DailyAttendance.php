<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}