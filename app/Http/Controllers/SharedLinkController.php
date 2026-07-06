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
        $links = SharedLink::where('year', $selectedYear)->orderBy('title')->get();
        return view('galeri-tautan.index', compact('links', 'selectedYear'));
    }

    public function store(Request $request)
    {
        // Hanya Super Admin yang bisa menambah
        if (!Auth::user()->isSuperAdmin()) { abort(403); }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'year' => 'required|integer',
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