<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        $extensions = ['jpg', 'png', 'jpeg'];
        foreach ($extensions as $ext) {
            // Menggunakan 'name' sebagai nama file foto
            $path = "photos/pegawai/{$this->name}.{$ext}";
            if (Storage::disk('public')->exists($path)) {
                return asset("storage/{$path}");
            }
        }
        // Jika tidak ada foto, kembalikan URL ke gambar placeholder
        return 'https://via.placeholder.com/150/0000FF/FFFFFF?text=No+Photo';
    }
}