<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Bill;
use App\Models\Booking;
use App\Models\Complaint;
use App\Models\Room;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();

        if ($user->isStaff()) {
            $data = [
                'totalRooms'    => Room::count(),
                'occupied'      => Room::where('status', 'terisi')->count(),
                'income'        => Bill::where('status', 'lunas')->where('period', now()->format('Y-m'))->sum('total'),
                'arrears'       => Bill::where('status', '!=', 'lunas')->sum('total'),
                'toVerify'      => Bill::where('status', 'menunggu')->count(),
                'pendingBooks'  => Booking::where('status', 'menunggu')->count(),
                'openComplaints'=> Complaint::where('status', '!=', 'selesai')->count(),
            ];
            return view('dashboard.owner', $data);
        }

        $contract = $user->activeContract()->with('room')->first();
        $bills = $contract ? $contract->bills()->latest('period')->take(3)->get() : collect();
        $bookings = Booking::where('user_id', $user->id)->with('room')->latest()->get();
        $announcements = Announcement::latest()->take(3)->get();
        return view('dashboard.penghuni', compact('contract', 'bills', 'bookings', 'announcements'));
    }
}
