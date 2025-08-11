<?php
namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Agenda;
use App\Models\User; // <-- Import User
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth; // <-- Import Auth

class RoomController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isSuperAdmin()) { abort(403); }
        $rooms = Room::orderBy('name')->get();
        return view('rooms.index', compact('rooms'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isSuperAdmin()) { abort(403); }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);
        Room::create($validated);
        return redirect()->route('rooms.index')->with('success', 'Ruangan baru berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        if (!Auth::user()->isSuperAdmin()) { abort(403); }
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        if (!Auth::user()->isSuperAdmin()) { abort(403); }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);
        $room->update($validated);
        return redirect()->route('rooms.index')->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        if (!Auth::user()->isSuperAdmin()) { abort(403); }
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Ruangan berhasil dihapus.');
    }

    public function showStatus(Request $request)
    {
        $selectedDate = $request->input('date', Carbon::today()->toDateString());
        $allRooms = Room::orderBy('name')->get();
        $bookedAgendas = Agenda::where('agenda_date', $selectedDate)
                               ->whereNotNull('room_id')
                               ->where('status', 'Terpublikasi')
                               ->get()
                               ->groupBy('room_id');

        $roomsWithStatus = $allRooms->map(function ($room) use ($bookedAgendas) {
            if ($bookedAgendas->has($room->id)) {
                $room->status = 'Digunakan';
                $room->agendas = $bookedAgendas->get($room->id);
            } else {
                $room->status = 'Tersedia';
                $room->agendas = collect();
            }
            return $room;
        });

        return view('rooms.status', [
            'rooms' => $roomsWithStatus,
            'selectedDate' => $selectedDate
        ]);
    }
}
