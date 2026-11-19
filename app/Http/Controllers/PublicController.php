<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $rooms = Room::where('status', 'kosong')->latest()->take(3)->get();
        return view('public.home', compact('rooms'));
    }

    public function catalog(Request $r)
    {
        $q = Room::query();
        if ($r->filled('type')) $q->where('type', $r->type);
        if ($r->filled('max_price')) $q->where('price', '<=', (int) $r->max_price);
        if ($r->filled('facility')) $q->where('facilities', 'like', '%' . $r->facility . '%');
        $rooms = $q->orderBy('number')->get();
        $types = Room::select('type')->distinct()->pluck('type');
        return view('public.catalog', compact('rooms', 'types'));
    }

    public function show(Room $room)
    {
        return view('public.show', compact('room'));
    }
}
