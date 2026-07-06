<?php
namespace App\Http\Controllers;

use App\Models\LeaveRecord;
use App\Models\User;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $employees = User::where('role', '!=', 'super_admin')->orderBy('name')->get();
        $leaveRecords = LeaveRecord::with('user')->latest()->get();
        return view('leaves.manage', compact('employees', 'leaveRecords'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:Cuti,Dinas Luar',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
        ]);

        LeaveRecord::create($validated);
        return back()->with('success', 'Data berhasil disimpan.');
    }

    public function destroy(LeaveRecord $leaveRecord)
    {
        $leaveRecord->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}