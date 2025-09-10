<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\User;
use App\Models\Room;
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
        

        // Dengan SoftDeletes di Model, Laravel secara otomatis hanya mengambil data yang "aktif"
        
        $agendas = Agenda::with(['user', 'room'])->latest()->get();
        $rooms = Room::orderBy('name')->get();
        return view('agenda.index', compact('agendas', 'rooms')); // Kirim data ruangan ke view
// Sesuaikan nama view jika perlu
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'agenda_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'file_path' => 'nullable|file|mimes:pdf,docx,jpg,png|max:5120',
            'room_id' => 'nullable|exists:rooms,id',
        ]);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('agenda_files', 'public');
        }

        // Gunakan data dari $validated yang sudah aman
        Agenda::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'agenda_date' => $validated['agenda_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'file_path' => $filePath,
            'room_id' => $validated['room_id'],
            'status' => 'Terpublikasi', // Atau 'pending' jika menggunakan alur persetujuan
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

        // 3. Kirim data dalam format JSON yang bersih dan aman.
        return response()->json([
            'id' => $agenda->id,
            'title' => $agenda->title,
            'description' => $agenda->description,
            'agenda_date' => $agenda->agenda_date->format('Y-m-d'),
            'start_time' => \Carbon\Carbon::parse($agenda->start_time)->format('H:i'),
            'end_time' => \Carbon\Carbon::parse($agenda->end_time)->format('H:i'),
            'file_path' => $agenda->file_path,
            'room_id' => $agenda->room_id,
        ]);
    }

     public function update(Request $request, string $id)
    {
        // 1. Cari agenda secara manual berdasarkan ID dari URL.
        $agenda = Agenda::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'agenda_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'file_path' => 'nullable|file|mimes:pdf,docx,jpg,png|max:5120',
            'room_id' => 'nullable|exists:rooms,id',
        ]);

        $filePath = $agenda->file_path;
        if ($request->hasFile('file_path')) {
            if ($agenda->file_path) { Storage::disk('public')->delete($agenda->file_path); }
            $filePath = $request->file('file_path')->store('agenda_files', 'public');
        }

        // 3. Perintah update ini sekarang akan berhasil
        $agenda->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'agenda_date' => $validated['agenda_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'file_path' => $filePath,
            'room_id' => $validated['room_id'],
        ]);

        return redirect()->route('agenda-harian.index')->with('success', 'Agenda berhasil diperbarui.');
    }
    
    public function destroy(string $id)
    {
        // --- PERBAIKAN FINAL DI SINI ---
        // 1. Cari agenda secara manual menggunakan ID dari URL.
        $agenda = Agenda::findOrFail($id);

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