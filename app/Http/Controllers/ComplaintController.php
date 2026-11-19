<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ComplaintController extends Controller
{
    public function mine()
    {
        $complaints = Complaint::where('user_id', auth()->id())->latest()->get();
        return view('complaints.mine', compact('complaints'));
    }

    public function store(Request $r)
    {
        $d = $r->validate(['title' => 'required|max:100', 'body' => 'required', 'photo' => 'nullable|image|max:2048']);
        if ($r->hasFile('photo')) $d['photo'] = $r->file('photo')->store('keluhan', 'public');
        Complaint::create($d + ['user_id' => auth()->id()]);
        return back()->with('ok', 'Keluhan terkirim.');
    }

    public function index()
    {
        $complaints = Complaint::with('user')->latest()->get();
        return view('manage.complaints.index', compact('complaints'));
    }

    public function update(Request $r, Complaint $complaint)
    {
        $d = $r->validate(['status' => 'required|in:diterima,diproses,selesai']);
        $complaint->update($d);

        try { // notifikasi ke penghuni (default: ditulis ke storage/logs/laravel.log)
            Mail::raw("Status keluhan \"{$complaint->title}\" sekarang: {$d['status']}.",
                fn ($m) => $m->to($complaint->user->email)->subject('Update Keluhan My Kost'));
        } catch (\Throwable $e) {}

        return back()->with('ok', 'Status keluhan diperbarui.');
    }
}
