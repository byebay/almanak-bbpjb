<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nip',
        'birth_date',
        'photo_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- TAMBAHKAN FUNGSI BARU DI SINI ---
    /**
     * Memberitahu Laravel untuk menggunakan kolom 'nip' untuk autentikasi.
     *
     * @return string
     */
    public function username()
    {
        return 'nip';
    }

    public function isSuperAdmin(): bool
    {
        // Kita gunakan trim() untuk keamanan ekstra, lalu bandingkan.
        return trim($this->role) === 'super_admin';
    }

    public function isKepegawaianAdmin(): bool
    {
        // Super Admin juga memiliki hak akses ini.
        return in_array(trim($this->role), ['admin_kepegawaian', 'super_admin']);
    }

    /**
     * Memeriksa apakah pengguna adalah Admin Anggaran.
     */
    public function isAnggaranAdmin(): bool
    {
        // Super Admin juga memiliki hak akses ini.
        return in_array(trim($this->role), ['admin_anggaran', 'super_admin']);
    }
    // ------------------------------------

    /**
     * Accessor untuk mendapatkan URL foto pegawai.
     * Akan mencari file jpg, png, atau jpeg.
     */
    public function getPhotoUrlAttribute()
    {
        // Jika ada path foto yang tersimpan di database, gunakan itu.
        if ($this->photo_path && Storage::disk('public')->exists($this->photo_path)) {
            return asset('storage/' . $this->photo_path);
        }

        // Jika tidak ada, kembalikan foto placeholder dengan inisial nama.
        $initials = strtoupper(substr($this->name, 0, 2));
        return 'https://via.placeholder.com/150/007BFF/FFFFFF?text=' . urlencode($initials);
    }

    public function getRoleName(): string
    {
    return match ($this->role) {
        'super_admin' => 'Super Admin',
        'admin_kepegawaian' => 'Admin Kepegawaian',
        'admin_anggaran' => 'Admin Anggaran',
        'pegawai' => 'Pegawai',
        default => 'Tidak Diketahui',
    };
}
}
