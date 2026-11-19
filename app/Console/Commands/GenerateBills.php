<?php

namespace App\Console\Commands;

use App\Models\Bill;
use App\Models\Contract;
use Illuminate\Console\Command;

class GenerateBills extends Command
{
    protected $signature = 'bills:generate';
    protected $description = 'Buat tagihan bulan ini untuk semua kontrak aktif';

    public function handle(): int
    {
        $period = now()->format('Y-m');
        $count = 0;

        foreach (Contract::where('status', 'aktif')->with('room')->get() as $c) {
            $bill = Bill::firstOrCreate(
                ['contract_id' => $c->id, 'period' => $period],
                [
                    'rent'     => $c->room->price,
                    'total'    => $c->room->price,
                    'due_date' => now()->startOfMonth()->addDays(9),
                ]
            );
            if ($bill->wasRecentlyCreated) $count++;
        }

        $this->info("$count tagihan baru dibuat untuk periode $period.");
        return self::SUCCESS;
    }
}
