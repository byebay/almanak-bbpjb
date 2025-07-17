<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class UserImportController extends Controller
{
    public function create()
    {
        // Hapus dd() jika masih ada
        // dd(Auth::user());

        // Pengecekan manual yang akan menjaga halaman ini
        if (trim(Auth::user()->role) !== 'super_admin') {
            abort(403, 'Aksi ini hanya untuk Super Admin.');
        }

        return view('users.import');
    }

    public function store(Request $request)
    {
        if (trim(Auth::user()->role) !== 'super_admin') {
            abort(403, 'Aksi ini hanya untuk Super Admin.');
        }

        $request->validate(['users_file' => 'required|mimes:xls,xlsx']);
        Excel::import(new UsersImport, $request->file('users_file'));
        return redirect()->route('dashboard')->with('success', 'Master data pegawai berhasil diimpor!');
    }
}
