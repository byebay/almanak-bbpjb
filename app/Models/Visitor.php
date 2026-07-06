<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ip_address',
        'visit_date', // <-- PASTIKAN BARIS INI ADA
        'user_agent', // <-- PASTIKAN BARIS INI JUGA ADA
    ];
}
