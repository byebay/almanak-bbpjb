<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $programs = Program::with(['wilayah', 'creator'])
            ->when($search, function ($query, $search) {
                $searchLower = strtolower($search);
                $query->where(function ($q) use ($searchLower) {
                    $q->whereRaw('LOWER(nama_program) like ?', ['%' . $searchLower . '%'])
                        ->orWhereHas('wilayah', function ($wilayahQuery) use ($searchLower) {
                            $wilayahQuery->whereRaw('LOWER(nama_wilayah) like ?', ['%' . $searchLower . '%']);
                        });
                });
            })
            ->orderBy('nama_program')
            ->paginate(10)
            ->withQueryString()
            ->fragment('daftar-program');

        $wilayahOptions = Wilayah::orderBy('nama_wilayah')->pluck('nama_wilayah', 'id');
        return view('admin.programs.index', compact('programs', 'wilayahOptions', 'search'));
    }

    public function create()
    {
        $wilayahOptions = Wilayah::orderBy('nama_wilayah')->pluck('nama_wilayah', 'id');
        return view('admin.programs.create', compact('wilayahOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'wilayah_id' => 'nullable|exists:wilayah,id',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'file_path' => 'nullable|file|mimes:pdf,docx,jpg,jpeg,png,webp|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('program_files', 'public');
        }

        $validated['file_path'] = $filePath;
        $validated['created_by'] = Auth::id();

        Program::create($validated);

        return redirect()->route('admin.programs.index')->with('success', 'Program baru berhasil ditambahkan.');
    }

    public function show(Program $program)
    {
        $program->load(['wilayah', 'creator']);
        return view('admin.programs.show', compact('program'));
    }

    public function edit(Program $program)
    {
        $wilayahOptions = Wilayah::orderBy('nama_wilayah')->pluck('nama_wilayah', 'id');
        return view('admin.programs.edit', compact('program', 'wilayahOptions'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'wilayah_id' => 'nullable|exists:wilayah,id',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'file_path' => 'nullable|file|mimes:pdf,docx,jpg,jpeg,png,webp|max:5120',
        ]);
        
        $filePath = $program->file_path;
        if ($request->hasFile('file_path')) {
            if ($program->file_path) { Storage::disk('public')->delete($program->file_path); }
            $filePath = $request->file('file_path')->store('program_files', 'public');
        }
        
        $validated['file_path'] = $filePath;

        $program->update($validated);

        return redirect()->route('admin.programs.index')->with('success', 'Data program berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        if ($program->file_path) {
            Storage::disk('public')->delete($program->file_path);
        }
        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus.');
    }
}
