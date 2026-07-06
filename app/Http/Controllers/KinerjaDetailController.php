<?php

namespace App\Http\Controllers;

use App\Models\KinerjaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KinerjaDetailController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KinerjaDetail $kinerjaDetail)
    {
        $validated = $request->validate([
            'pelaksana'             => 'required|string|max:255',
            'deskripsi_pekerjaan'   => 'required|string',
            'realisasi_target'      => 'required|string',
            'progres_kegiatan'      => 'required|string',
            'kendala'               => 'nullable|string',
            'strategi_penyelesaian' => 'nullable|string',
            'file_bukti'            => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('file_bukti')) {
            // Hapus file lama jika ada
            if ($kinerjaDetail->file_bukti && Storage::disk('public')->exists($kinerjaDetail->file_bukti)) {
                Storage::disk('public')->delete($kinerjaDetail->file_bukti);
            }
            // Simpan file baru dan update path
            $validated['file_bukti'] = $request->file('file_bukti')->store('bukti_kinerja', 'public');
        }

        $kinerjaDetail->update($validated);

        return back()->with('success', 'Detail laporan berhasil diperbarui.');
    }
}