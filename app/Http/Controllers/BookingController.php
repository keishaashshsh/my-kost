<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Contract;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Calon penghuni memesan kamar
    public function store(Request $r, Room $room)
    {
        if ($room->status !== 'kosong') {
            return back()->with('err', 'Kamar ini sudah terisi.');
        }
        $data = $r->validate(['start_date' => 'required|date|after_or_equal:today', 'note' => 'nullable|string|max:500']);

        $exists = Booking::where('user_id', auth()->id())->where('room_id', $room->id)->where('status', 'menunggu')->exists();
        if ($exists) return back()->with('err', 'Kamu sudah memesan kamar ini, tunggu konfirmasi pemilik.');

        Booking::create($data + ['user_id' => auth()->id(), 'room_id' => $room->id]);
        return redirect()->route('dashboard')->with('ok', 'Booking terkirim. Tunggu konfirmasi pemilik.');
    }

    // ---- sisi pemilik/admin ----
    public function index()
    {
        $bookings = Booking::with('user', 'room')->latest()->get();
        return view('manage.bookings.index', compact('bookings'));
    }

    public function confirm(Booking $booking)
    {
        if ($booking->room->status !== 'kosong') {
            return back()->with('err', 'Kamar sudah terisi.');
        }
        $booking->update(['status' => 'dikonfirmasi']);
        Contract::create([
            'user_id' => $booking->user_id,
            'room_id' => $booking->room_id,
            'start_date' => $booking->start_date,
            'end_date' => $booking->start_date->copy()->addMonths(6),
        ]);
        $booking->room->update(['status' => 'terisi']);
        return back()->with('ok', 'Booking dikonfirmasi, penghuni otomatis tercatat.');
    }

    public function reject(Booking $booking)
    {
        $booking->update(['status' => 'ditolak']);
        return back()->with('ok', 'Booking ditolak.');
    }
}
