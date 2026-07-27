<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WilayahController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $wilayahs = Wilayah::orderBy('nama_wilayah')->get();
        return view('admin.wilayah.index', compact('wilayahs'));
    }

    public function create()
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        return view('admin.wilayah.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:100', 'alpha_dash', Rule::unique('wilayah', 'kode')],
            'nama_wilayah' => 'required|string|max:255',
            'informasi' => 'nullable|string',
        ]);

        Wilayah::create($validated);

        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah baru berhasil ditambahkan.');
    }

    public function edit(Wilayah $wilayah)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        return view('admin.wilayah.edit', compact('wilayah'));
    }

    public function update(Request $request, Wilayah $wilayah)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:100', 'alpha_dash', Rule::unique('wilayah', 'kode')->ignore($wilayah->id)],
            'nama_wilayah' => 'required|string|max:255',
            'informasi' => 'nullable|string',
        ]);

        $wilayah->update($validated);

        return redirect()->route('admin.wilayah.index')->with('success', 'Data wilayah berhasil diperbarui.');
    }

    public function destroy(Wilayah $wilayah)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $wilayah->delete();

        return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah berhasil dihapus.');
    }
}
