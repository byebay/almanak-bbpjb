<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProgramController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $programs = Program::with('wilayah')->orderBy('nama_program')->get();
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $wilayahOptions = Wilayah::orderBy('nama_wilayah')->pluck('nama_wilayah', 'id');
        return view('admin.programs.create', compact('wilayahOptions'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'wilayah_id' => 'nullable|exists:wilayah,id',
            'deskripsi' => 'nullable|string',
            'tahun' => 'nullable|digits:4',
        ]);

        Program::create($validated);

        return redirect()->route('admin.programs.index')->with('success', 'Program baru berhasil ditambahkan.');
    }

    public function edit(Program $program)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $wilayahOptions = Wilayah::orderBy('nama_wilayah')->pluck('nama_wilayah', 'id');
        return view('admin.programs.edit', compact('program', 'wilayahOptions'));
    }

    public function update(Request $request, Program $program)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'wilayah_id' => 'nullable|exists:wilayah,id',
            'deskripsi' => 'nullable|string',
            'tahun' => 'nullable|digits:4',
        ]);

        $program->update($validated);

        return redirect()->route('admin.programs.index')->with('success', 'Data program berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus.');
    }
}
