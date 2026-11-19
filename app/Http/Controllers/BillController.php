<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class BillController extends Controller
{
    // ---- penghuni ----
    public function mine()
    {
        $bills = Bill::whereHas('contract', fn ($q) => $q->where('user_id', auth()->id()))
            ->with('contract.room')->latest('period')->get();
        return view('bills.mine', compact('bills'));
    }

    public function proof(Request $r, Bill $bill)
    {
        abort_unless($bill->contract->user_id === auth()->id(), 403);
        abort_if($bill->status === 'lunas', 403);
        $r->validate(['proof' => 'required|image|max:2048']);
        $bill->update(['proof' => $r->file('proof')->store('bukti', 'public'), 'status' => 'menunggu']);
        return back()->with('ok', 'Bukti terkirim, menunggu verifikasi pemilik.');
    }

    public function receipt(Bill $bill)
    {
        $u = auth()->user();
        abort_unless($bill->status === 'lunas' && ($u->isStaff() || $bill->contract->user_id === $u->id), 403);
        $bill->load('contract.user', 'contract.room');
        return Pdf::loadView('pdf.receipt', compact('bill'))->download($bill->receipt_no . '.pdf');
    }

    // ---- pemilik/admin ----
    public function index()
    {
        $bills = Bill::with('contract.user', 'contract.room')->latest('period')->latest('id')->paginate(20);
        return view('manage.bills.index', compact('bills'));
    }

    public function generate()
    {
        Artisan::call('bills:generate');
        return back()->with('ok', trim(Artisan::output()));
    }

    public function meter(Request $r, Bill $bill)
    {
        abort_if($bill->status !== 'belum', 403);
        $d = $r->validate(['elec_kwh' => 'required|integer|min:0', 'water_m3' => 'required|integer|min:0']);
        $total = $bill->rent + $d['elec_kwh'] * config('mykost.tariff_kwh') + $d['water_m3'] * config('mykost.tariff_water');
        $bill->update($d + ['total' => $total]);
        return back()->with('ok', 'Tagihan listrik dan air dihitung ulang.');
    }

    public function verify(Bill $bill)
    {
        $bill->update([
            'status' => 'lunas',
            'paid_at' => now(),
            'receipt_no' => 'KW-' . now()->format('Ymd') . '-' . str_pad($bill->id, 4, '0', STR_PAD_LEFT),
        ]);
        return back()->with('ok', 'Pembayaran diverifikasi, kuitansi terbit.');
    }

    public function reject(Bill $bill)
    {
        $bill->update(['status' => 'belum', 'proof' => null]);
        return back()->with('ok', 'Bukti ditolak, penghuni diminta mengunggah ulang.');
    }
}
