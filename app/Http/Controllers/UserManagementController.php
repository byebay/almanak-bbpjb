<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserManagementController extends Controller
{
    /**
     * Menampilkan halaman daftar pegawai.
     */
    public function index()
    {
        // Cek hak akses di dalam controller
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $users = User::where('role', '!=', 'super_admin')->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan formulir tambah pegawai baru.
     */
    public function create()
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        return view('admin.users.create');
    }

    /**
     * Menyimpan pegawai baru ke database.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:users,nip',
            'email' => 'nullable|email|max:255|unique:users,email',
            'tanggal_lahir' => 'nullable|date',
            'role' => 'required|in:pegawai,kepegawaian,super_admin',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('photo')) {
            $filePath = $request->file('photo')->store('photos/pegawai', 'public');
        }

        $email = $validated['email'] ?? $validated['nip'] . '@bbjb.test';
        $defaultPassword = 'sandi123';

        User::create([
            'name' => $validated['name'],
            'nip' => $validated['nip'],
            'email' => $email,
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'role' => $validated['role'],
            'photo_path' => $filePath,
            'password' => Hash::make($defaultPassword),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pegawai baru berhasil ditambahkan dengan kata sandi default "sandi123".');
    }

    /**
     * Menampilkan formulir edit pegawai.
     */
    public function edit(User $user)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Memperbarui data pegawai di database.
     */
    public function update(Request $request, User $user)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore($user->id), // Abaikan NIP milik pengguna ini sendiri
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id), // Abaikan email milik pengguna ini sendiri
            ],
            'tanggal_lahir' => 'nullable|date',
            'role' => 'required|in:pegawai,kepegawaian,super_admin',
        ]);
        
        $email = $validated['email'] ?? $validated['nip'] . '@bbjb.test';

        $user->update([
            'name' => $validated['name'],
            'nip' => $validated['nip'],
            'email' => $email,
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Mereset kata sandi pengguna ke nilai default.
     */
    public function resetPassword(User $user)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $defaultPassword = 'sandi123';
        $user->password = Hash::make($defaultPassword);
        $user->save();

        return back()->with('success', 'Kata sandi untuk ' . $user->name . ' berhasil direset menjadi "' . $defaultPassword . '".');
    }
}