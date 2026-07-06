<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SemiStructuredAgendaImport; // <-- Gunakan importer baru kita

class AgendaImportController extends Controller
{
    public function create()
    {
        if (!auth()->user()->isSuperAdmin()) { abort(403); }
        return view('agenda.import');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isSuperAdmin()) { abort(403); }
        $validated = $request->validate([
            'agenda_file' => 'required|mimes:xls,xlsx',
            'year' => 'required|integer|min:2020',
            'month' => 'required|integer|between:1,12',
        ]);

        Excel::import(new SemiStructuredAgendaImport($validated['year'], $validated['month']), $request->file('agenda_file'));

        return redirect()->route('agenda-harian.index')->with('success', 'Data agenda historis berhasil diimpor!');
    }
}
