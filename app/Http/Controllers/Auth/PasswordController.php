<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator; // <-- TAMBAHKAN INI
use Illuminate\Validation\ValidationException; // <-- TAMBAHKAN INI

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        // 1. Definisikan aturan dan pesan kustom
        $rules = [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ];

        $messages = [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi yang Anda masukkan tidak cocok dengan kata sandi saat ini.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.min' => 'Kata sandi baru minimal harus 8 karakter.',
        ];

        // 2. Buat instance Validator secara manual
        $validator = Validator::make($request->all(), $rules, $messages);

        // 3. Atur "kantong surat" yang benar dan validasi
        // Jika gagal, ini akan otomatis redirect kembali dengan error di kantong 'updatePassword'
        try {
            $validated = $validator->validateWithBag('updatePassword');
        } catch (ValidationException $e) {
            return back()->withErrors($validator, 'updatePassword');
        }

        // 4. Lanjutkan proses jika validasi berhasil
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}