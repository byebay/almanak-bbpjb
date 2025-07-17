<?php
namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Daftarkan policy Anda di sini nanti
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate ini akan memberikan akses penuh kepada Super Admin untuk semua Gate lainnya.
        // Ini adalah cara yang efisien agar kita tidak perlu menambahkan
        // '|| $user->role === 'super_admin'' di setiap Gate.
        Gate::before(function ($user, $ability) {
            if ($user->role === 'super_admin') {
                return true;
            }
        });

        // Gate untuk fitur Kepegawaian
        Gate::define('manage-kepegawaian', function ($user) {
            return $user->role === 'admin_kepegawaian';
        });

        // Gate untuk fitur Anggaran/Caput
        Gate::define('manage-anggaran', function ($user) {
            return $user->role === 'admin_anggaran';
        });

        // Gate untuk mengecek apakah user adalah jenis admin APAPUN
        Gate::define('is-any-admin', function ($user) {
            return in_array($user->role, [
                'admin_kepegawaian',
                'admin_anggaran',
                'super_admin'
            ]);
        });
    }
}