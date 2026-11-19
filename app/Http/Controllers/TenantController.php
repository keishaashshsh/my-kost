<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $contracts = Contract::with('user', 'room')->latest()->get();
        $users = User::where('role', 'penghuni')->orderBy('name')->get();
        $rooms = Room::where('status', 'kosong')->orderBy('number')->get();
        return view('manage.tenants.index', compact('contracts', 'users', 'rooms'));
    }

    public function store(Request $r)
    {
        $d = $r->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        $room = Room::findOrFail($d['room_id']);
        if ($room->status !== 'kosong') return back()->with('err', 'Kamar sudah terisi.');

        Contract::create($d);
        $room->update(['status' => 'terisi']);
        return back()->with('ok', 'Penghuni dan kontrak tercatat.');
    }
}
