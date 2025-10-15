<?php

namespace App\Http\Controllers;

use App\Models\Kinerja;
use App\Exports\KinerjaExport; // <-- Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel; // <-- Tambahkan ini

class KinerjaController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->input('bulan', Carbon::now()->format('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $selectedMonth)->startOfMonth();

        $kinerjaBulanan = Kinerja::whereYear('bulan_tahun', $date->year)
                                  ->whereMonth('bulan_tahun', $date->month)
                                  ->with('details')
                                  ->latest()
                                  ->get();

        return view('kinerja.index', [
            'kinerjaBulanan' => $kinerjaBulanan,
            'currentDate' => $date,
        ]);
    }

    /**
     * Menyimpan data Kegiatan Utama baru beserta detail pertamanya.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'target_kinerja' => 'required|string',
            'bulan_tahun' => 'required|date_format:Y-m',
            'pelaksana' => 'required|string',
            'deskripsi_pekerjaan' => 'required|string',
            'realisasi_target' => 'required|string',
            'progres_kegiatan' => 'required|string',
            'kendala' => 'nullable|string',
            'strategi_penyelesaian' => 'nullable|string',
            'file_bukti' => 'nullable|file|mimes:pdf,jpg,png,docx|max:2048',
        ]);

        // Buat Kegiatan Utama
        $kinerja = Kinerja::create([
            'user_id' => Auth::id(),
            'judul_kegiatan' => $validated['judul_kegiatan'],
            'target_kinerja' => $validated['target_kinerja'],
            'bulan_tahun' => $validated['bulan_tahun'] . '-01', // Tambah hari agar jadi format tanggal valid
        ]);

        $filePath = null;
        if ($request->hasFile('file_bukti')) {
            $filePath = $request->file('file_bukti')->store('bukti_kinerja', 'public');
        }

        // Buat Detail Kinerja yang pertama
        $kinerja->details()->create([
            'pelaksana' => $validated['pelaksana'],
            'deskripsi_pekerjaan' => $validated['deskripsi_pekerjaan'],
            'realisasi_target' => $validated['realisasi_target'],
            'progres_kegiatan' => $validated['progres_kegiatan'],
            'kendala' => $validated['kendala'],
            'strategi_penyelesaian' => $validated['strategi_penyelesaian'],
            'file_bukti' => $filePath,
        ]);

        return back()->with('success', 'Realisasi kegiatan baru berhasil ditambahkan.');
    }

    public function show(Kinerja $kinerja)
    {
        // Memuat relasi 'details' untuk ditampilkan di view
        $kinerja->load('details');

        return view('kinerja.show', compact('kinerja'));
    }

    public function update(Request $request, Kinerja $kinerja)
    {
        $validated = $request->validate([
            'pelaksana'             => 'required|string|max:255',
            'deskripsi_pekerjaan'   => 'required|string',
            'realisasi_target'      => 'required|string',
            'progres_kegiatan'      => 'required|string',
        ]);
        
        $kinerja->update($validated);
        
        return back()->with('success', 'Kegiatan utama berhasil diperbarui.');
    }

    public function destroy(Kinerja $kinerja)
    {
        foreach ($kinerja->details as $detail) {
            if ($detail->file_bukti) {
                Storage::disk('public')->delete($detail->file_bukti);
            }
        }

        $kinerja->delete();
        return redirect()->route('kinerja.index')->with('success', 'Laporan Realisasi Kegiatan berhasil dihapus.');
    }
    // Fungsi lainnya akan kita tambahkan nanti
// app/Http/Controllers/KinerjaController.php

    public function exportExcel(Request $request)
    {
    $validated = $request->validate([
        'year' => 'required|integer|min:2023',
        'month' => 'required|integer|between:1,12',
    ]);

    $year = $validated['year'];
    $user = Auth::user();

    // --- PERBAIKAN FINAL DI SINI ---
    // Lakukan konversi (casting) tipe data dari string ke integer secara manual
    $month = (int)$validated['month'];
    // -------------------------------

    // Sekarang, $month dijamin bertipe integer
    $namaBulan = \Carbon\Carbon::create()->month($month)->translatedFormat('F');

    // Nama file yang akan diunduh
    $fileName = 'Laporan Realisasi - ' . $namaBulan . ' ' . $year . '.xlsx';

    // Pastikan KinerjaExport juga menerima integer
    return Excel::download(new KinerjaExport((int)$year, $month, $user->id), $fileName);
    }
}