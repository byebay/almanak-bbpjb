<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard dengan kalender.
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Menyediakan data agenda untuk FullCalendar dalam format JSON.
     * Hanya agenda yang berstatus 'Terpublikasi' yang diambil.
     */
    public function getEvents(Request $request)
    {
        // Query ini akan mengambil semua agenda yang statusnya persis 'Terpublikasi'
        $agendas = Agenda::where('status', 'Terpublikasi')->get();

        $events = [];
        foreach ($agendas as $agenda) {
            $events[] = [
                'title' => $agenda->title,
                'start' => $agenda->agenda_date->format('Y-m-d'),
                'extendedProps' => [
                    'description' => $agenda->description,
                    'start_time' => \Carbon\Carbon::parse($agenda->start_time)->format('H:i'),
                    'end_time' => \Carbon\Carbon::parse($agenda->end_time)->format('H:i'),
                ]
            ];
        }

        return response()->json($events);
    }
}