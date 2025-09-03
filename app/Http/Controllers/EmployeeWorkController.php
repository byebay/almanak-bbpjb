<?php
namespace App\Http\Controllers;

use App\Models\EmployeeWork;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // <-- Import Str
use ZipArchive; // <-- Import ZipArchive

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
        $employees = User::orderBy('name')->get();

        return view('hasil-kerja.month', compact('employees', 'year', 'month'));
    }

    // Menampilkan detail hasil kerja satu pegawai dengan pengecekan
    public function showEmployeeWork($year, $month, User $user)
    {
        $authUser = Auth::user();

        // OTORISASI:
        // Hentikan jika user yang login bukan admin DAN bukan pemilik halaman.

        $works = EmployeeWork::where('user_id', $user->id)
                             ->where('year', $year)
                             ->where('month', $month)
                             ->orderBy('work_date', 'desc')
                             ->get();

        return view('hasil-kerja.show', compact('user', 'works', 'year', 'month'));
    }

    // Menyimpan file hasil kerja yang baru diunggah
    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer|between:1,12',
            'work_date' => 'required|date',
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
            'work_date' => $validated['work_date'],
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

        return back()->with('success', 'Bukti kerja berhasil dihapus.');
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

     public function downloadAllAsZip(User $user, $year, $month)
    {
        $works = EmployeeWork::where('user_id', $user->id)
                             ->where('year', $year)
                             ->where('month', $month)
                             ->get();

        if ($works->isEmpty()) {
            return back()->with('error', 'Tidak ada bukti kerja untuk diunduh pada periode ini.');
        }

        $zipFileName = 'bukti-kerja-' . Str::slug($user->name) . '-' . $year . '-' . $month . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0775, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            return back()->with('error', 'Gagal membuat arsip ZIP.');
        }

        $filesAdded = 0;
        foreach ($works as $work) {
            // Gunakan Storage::path() untuk mendapatkan path absolut yang benar
            if (Storage::exists($work->file_path)) {
                $absolutePath = Storage::path($work->file_path);
                $fileNameInZip = $work->work_date->format('Y-m-d') . '_' . Str::slug($work->title) . '.' . $work->file_type;
                $zip->addFile($absolutePath, $fileNameInZip);
                $filesAdded++;
            }
        }
        $zip->close();

        if ($filesAdded > 0 && file_exists($zipPath)) {
            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        if (file_exists($zipPath)) { unlink($zipPath); }
        
        return back()->with('error', 'Tidak ada file valid yang ditemukan untuk diarsipkan.');
    }

    // --- FUNGSI-FUNGSI BARU UNTUK LINK PUBLIK ---
    public function showPublic($token, $year, $month)
    {
        $user = User::where('shareable_token', $token)->firstOrFail();
        $works = EmployeeWork::where('user_id', $user->id)
                             ->where('year', $year)
                             ->where('month', $month)
                             ->orderBy('work_date', 'desc')
                             ->get();
        return view('hasil-kerja.public-show', compact('user', 'works', 'year', 'month'));
    }

    public function viewPublic(EmployeeWork $work, $token)
    {
        $user = User::where('shareable_token', $token)->firstOrFail();
        // Pastikan file yang diminta dimiliki oleh user dengan token yang benar
        if ($work->user_id !== $user->id) { abort(403); }
        return Storage::response($work->file_path);
    }

    public function downloadPublic(EmployeeWork $work, $token)
    {
        $user = User::where('shareable_token', $token)->firstOrFail();
        if ($work->user_id !== $user->id) { abort(403); }
        return Storage::download($work->file_path);
    }
}
