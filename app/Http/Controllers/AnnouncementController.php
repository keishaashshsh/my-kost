<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('announcements.index', compact('announcements'));
    }

    public function store(Request $r)
    {
        Announcement::create($r->validate(['title' => 'required|max:100', 'body' => 'required']));
        return back()->with('ok', 'Pengumuman dibuat.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return back()->with('ok', 'Pengumuman dihapus.');
    }
}
