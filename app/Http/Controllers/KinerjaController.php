<?php

namespace App\Http\Controllers;

use App\Models\Kinerja;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
        // Hapus semua file bukti dari detail terkait terlebih dahulu
        foreach ($kinerja->details as $detail) {
            // Perbaikan: Cek jika file_bukti adalah string dan ada isinya
            if ($detail->file_bukti && is_string($detail->file_bukti)) {
                Storage::disk('public')->delete($detail->file_bukti);
            }
        }
        
        $kinerja->delete(); // Ini akan otomatis menghapus detailnya karena ada onDelete('cascade')
        
        return redirect()->route('kinerja.index')->with('success', 'Kegiatan berhasil dihapus.');

    }
    // Fungsi lainnya akan kita tambahkan nanti
}