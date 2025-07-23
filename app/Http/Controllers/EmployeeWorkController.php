<?php
namespace App\Http\Controllers;

use App\Models\EmployeeWork;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeWorkController extends Controller
{
    // Halaman utama, menampilkan pilihan tahun/bulan
    public function index()
    {
        return view('hasil-kerja.index');
    }

    // Menampilkan daftar pegawai sesuai hak akses
    public function showMonth($year, $month)
    {
        $authUser = Auth::user();

        // LOGIKA HAK AKSES UTAMA:
        // Jika user adalah salah satu jenis admin, tampilkan semua pegawai.
        if ($authUser->isSuperAdmin() || $authUser->isKepegawaianAdmin() || $authUser->isAnggaranAdmin()) {
            $employees = User::orderBy('name')->get();
        } else {
            // Jika bukan admin, hanya tampilkan dirinya sendiri.
            $employees = collect([$authUser]);
        }

        return view('hasil-kerja.month', compact('employees', 'year', 'month'));
    }

    // Menampilkan detail hasil kerja satu pegawai dengan pengecekan
    public function showEmployeeWork($year, $month, User $user)
    {
        $authUser = Auth::user();

        // OTORISASI:
        // Hentikan jika user yang login bukan admin DAN bukan pemilik halaman.
        if (!($authUser->isSuperAdmin() || $authUser->isKepegawaianAdmin() || $authUser->isAnggaranAdmin()) && $authUser->id !== $user->id) {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }

        $works = EmployeeWork::where('user_id', $user->id)
                             ->where('year', $year)
                             ->where('month', $month)
                             ->get();

        return view('hasil-kerja.show', compact('user', 'works', 'year', 'month'));
    }

    // Menyimpan file hasil kerja yang baru diunggah
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer|between:1,12',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'work_file' => 'required|file|max:10240', // Maks 10MB
        ]);

        $file = $request->file('work_file');
        $path = $file->store('public/hasil-kerja/' . $validated['year'] . '/' . $validated['month']);

        EmployeeWork::create([
            'user_id' => Auth::id(),
            'year' => $validated['year'],
            'month' => $validated['month'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
        ]);

        return back()->with('success', 'Hasil kerja berhasil diunggah.');
    }

    // Menghapus file hasil kerja
    public function destroy(EmployeeWork $work)
    {
        $authUser = Auth::user();
        // Otorisasi: hanya pemilik atau admin yang bisa hapus
        if ($authUser->id !== $work->user_id && !($authUser->isSuperAdmin() || $authUser->isKepegawaianAdmin() || $authUser->isAnggaranAdmin())) {
            abort(403);
        }

        Storage::delete($work->file_path);
        $work->delete();

        return back()->with('success', 'Hasil kerja berhasil dihapus.');
    }

     public function view(EmployeeWork $work)
    {
        $authUser = Auth::user();

        // OTORISASI: Pastikan hanya pemilik atau admin yang bisa melihat.
        if (!($authUser->isSuperAdmin() || $authUser->isKepegawaianAdmin() || $authUser->isAnggaranAdmin()) && $authUser->id !== $work->user_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }

        // Gunakan Storage::response untuk mengirim file dengan header 'inline'.
        // Ini akan memberitahu browser untuk mencoba menampilkan file (PDF, gambar, teks).
        return Storage::response($work->file_path);
    }

    public function download(EmployeeWork $work)
    {
        $authUser = Auth::user();

        // OTORISASI: Pastikan hanya pemilik atau admin yang bisa mengunduh.
        if (!($authUser->isSuperAdmin() || $authUser->isKepegawaianAdmin() || $authUser->isAnggaranAdmin()) && $authUser->id !== $work->user_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }

        // Gunakan Storage::download untuk mengirim file dengan header yang benar.
        // Ini akan memaksa browser untuk menampilkan dialog "Simpan File".
        return Storage::download($work->file_path);
    }
}
