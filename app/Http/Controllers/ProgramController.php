<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::with(['wilayah', 'creator'])->orderBy('nama_program')->get();
        return view('admin.programs.index', compact('programs'));
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
            'status' => 'required|in:direncanakan,berjalan,selesai',
        ]);

        $validated['created_by'] = Auth::id();

        Program::create($validated);

        return redirect()->route('admin.programs.index')->with('success', 'Program baru berhasil ditambahkan.');
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
            'status' => 'required|in:direncanakan,berjalan,selesai',
        ]);
        $program->update($validated);

        return redirect()->route('admin.programs.index')->with('success', 'Data program berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus.');
    }
}
