<?php

namespace App\Http\Controllers;

use App\Models\Contract;

class ContractController extends Controller
{
    public function extend(Contract $contract)
    {
        abort_unless($contract->user_id === auth()->id() && $contract->status === 'aktif', 403);
        $contract->update(['end_date' => $contract->end_date->copy()->addMonths(6)]);
        return back()->with('ok', 'Kontrak diperpanjang 6 bulan.');
    }

    public function end(Contract $contract)
    {
        abort_unless($contract->user_id === auth()->id() && $contract->status === 'aktif', 403);
        $contract->update(['status' => 'selesai']);
        $contract->room->update(['status' => 'kosong']);
        return back()->with('ok', 'Kontrak diakhiri.');
    }
}
