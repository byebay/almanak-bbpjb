<?php
namespace App\Http\Controllers;

use App\Models\SharedLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SharedLinkController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->input('year', now()->year);
        $kategori = $request->input('kategori', 'Hasil Kerja');

        $query = SharedLink::where('year', $selectedYear)->where('kategori', $kategori);
        
        if ($kategori === 'Hasil Kerja') {
            $driver = $query->getConnection()->getDriverName();
            if ($driver === 'sqlite') {
                $query->orderByRaw("CAST(strftime('%m', created_at) AS INTEGER) ASC");
            } else {
                $query->orderByRaw('MONTH(created_at) ASC');
            }
            $query->orderBy('created_at', 'ASC');
        } else {
            $query->orderBy('title');
        }

        $links = $query->get();
        return view('galeri-tautan.index', compact('links', 'selectedYear', 'kategori'));
    }

    public function store(Request $request)
    {
        // Hanya Super Admin yang bisa menambah
        if (!Auth::user()->isSuperAdmin()) { abort(403); }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'year' => 'required|integer',
            'kategori' => 'required|in:Hasil Kerja,Lainnya',
        ], [
            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.in' => 'Kategori harus berupa Hasil Kerja atau Lainnya.',
        ]);

        SharedLink::create($validated);
        return back()->with('success', 'Tautan baru berhasil ditambahkan.');
    }

    public function destroy(SharedLink $link)
    {
        // Hanya Super Admin yang bisa menghapus
        if (!Auth::user()->isSuperAdmin()) { abort(403); }

        $link->delete();
        return back()->with('success', 'Tautan berhasil dihapus.');
    }
}