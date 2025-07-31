<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgendaController extends Controller
{
    /**
     * Menampilkan daftar agenda.
     */
    public function index()
    {
        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        // Dengan SoftDeletes di Model, Laravel secara otomatis hanya mengambil data yang "aktif"
        if ($authUser->isSuperAdmin()) {
            $agendas = Agenda::with('user')->latest()->get();
        } else {
            $agendas = Agenda::with('user')->where('user_id', $authUser->id)->latest()->get();
        }

        return view('agenda.index', compact('agendas')); // Sesuaikan nama view jika perlu
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'agenda_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'file_path' => 'nullable|file|mimes:pdf,docx,jpg,png|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('agenda_files', 'public');
        }

        Agenda::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'agenda_date' => $request->agenda_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'file_path' => $filePath,
            'status' => 'Terpublikasi',
        ]);

        return redirect()->route('agenda-harian.index')->with('success', 'Agenda baru berhasil ditambahkan.');
    }

    /**
     * Fungsi ini adalah kunci untuk fitur edit.
     * Ia mengirim data agenda spesifik ke JavaScript.
     */
    public function show(string $id)
    {
        // 1. Cari agenda secara manual berdasarkan ID dari URL.
        $agenda = Agenda::findOrFail($id);

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        // 2. Otorisasi Manual: Siapa yang boleh melihat data untuk diedit?
        // Aturan: Pengguna harus Super Admin ATAU pemilik agenda tersebut.
        if ($authUser->id !== $agenda->user_id && !$authUser->isSuperAdmin()) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // 3. Kirim data dalam format JSON yang bersih dan aman.
        return response()->json([
            'id' => $agenda->id,
            'title' => $agenda->title,
            'description' => $agenda->description,
            'agenda_date' => $agenda->agenda_date->format('Y-m-d'),
            'start_time' => \Carbon\Carbon::parse($agenda->start_time)->format('H:i'),
            'end_time' => \Carbon\Carbon::parse($agenda->end_time)->format('H:i'),
            'file_path' => $agenda->file_path,
        ]);
    }

    public function update(Request $request, Agenda $agenda)
    {
        // PERBAIKAN DI SINI: Pastikan ada 'update' sebagai parameter pertama
        $this->authorize('update', $agenda);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'agenda_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'file_path' => 'nullable|file|mimes:pdf,docx,jpg,png|max:5120',
        ]);

        $filePath = $agenda->file_path;
        if ($request->hasFile('file_path')) {
            if ($agenda->file_path) { Storage::disk('public')->delete($agenda->file_path); }
            $filePath = $request->file('file_path')->store('agenda_files', 'public');
        }

        $agenda->update([
            'title' => $request->title,
            'description' => $request->description,
            'agenda_date' => $request->agenda_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'file_path' => $filePath,
        ]);

        return redirect()->route('agenda-harian.index')->with('success', 'Agenda berhasil diperbarui.');
    }
    
    public function destroy(string $id)
    {
        // --- PERBAIKAN FINAL DI SINI ---
        // 1. Cari agenda secara manual menggunakan ID dari URL.
        $agenda = Agenda::findOrFail($id);

        /** @var \App\Models\User $authUser */
        $authUser = Auth::user();

        // 2. Lakukan otorisasi pada agenda yang sudah kita temukan.
        if ($authUser->id !== $agenda->user_id && !$authUser->isSuperAdmin()) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // 3. Hapus file terkait jika ada.
        if ($agenda->file_path) {
            Storage::disk('public')->delete($agenda->file_path);
        }

        // 4. Jalankan perintah delete pada objek yang sudah pasti benar.
        $agenda->delete();
        // --------------------------------

        return redirect()->route('agenda-harian.index')->with('success', 'Agenda berhasil dihapus.');
    }
}