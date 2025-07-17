<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama.
     */
    public function index()
    {
        // Cukup tampilkan view-nya saja, tanpa data apa pun.
        return view('dashboard');
    }
}