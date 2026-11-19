<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('number')->get();
        return view('manage.rooms.index', compact('rooms'));
    }

    public function create() { return view('manage.rooms.form', ['room' => new Room]); }

    public function store(Request $r)
    {
        Room::create($this->data($r));
        return redirect()->route('manage.rooms.index')->with('ok', 'Kamar ditambahkan.');
    }

    public function edit(Room $room) { return view('manage.rooms.form', compact('room')); }

    public function update(Request $r, Room $room)
    {
        $room->update($this->data($r, $room));
        return redirect()->route('manage.rooms.index')->with('ok', 'Kamar diperbarui.');
    }

    public function destroy(Room $room)
    {
        if ($room->contracts()->exists()) {
            return back()->with('err', 'Kamar punya riwayat kontrak, tidak bisa dihapus.');
        }
        $room->delete();
        return back()->with('ok', 'Kamar dihapus.');
    }

    private function data(Request $r, ?Room $room = null): array
    {
        $d = $r->validate([
            'number' => ['required', Rule::unique('rooms', 'number')->ignore($room?->id)],
            'type' => 'required|string|max:50',
            'price' => 'required|integer|min:0',
            'facilities' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:kosong,terisi',
            'photo' => 'nullable|image|max:2048',
        ]);
        if ($r->hasFile('photo')) {
            $d['photo'] = $r->file('photo')->store('kamar', 'public');
        } else {
            unset($d['photo']);
        }
        return $d;
    }
}
