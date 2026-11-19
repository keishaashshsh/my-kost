<?php

namespace App\Console\Commands;

use App\Models\Bill;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SendReminders extends Command
{
    protected $signature = 'bills:remind';
    protected $description = 'Kirim pengingat untuk tagihan yang jatuh tempo dalam 3 hari';

    public function handle(): int
    {
        $bills = Bill::where('status', 'belum')
            ->whereBetween('due_date', [today(), today()->addDays(3)])
            ->with('contract.user', 'contract.room')->get();

        foreach ($bills as $b) {
            $user = $b->contract->user;
            $msg = "Halo {$user->name}, tagihan kos kamar {$b->contract->room->number} periode {$b->period} "
                 . "sebesar Rp " . number_format($b->total, 0, ',', '.')
                 . " jatuh tempo pada " . $b->due_date->format('d-m-Y') . ". Terima kasih.";

            try {
                Mail::raw($msg, fn ($m) => $m->to($user->email)->subject('Pengingat Tagihan My Kost'));
                if (config('mykost.fonnte_token') && $user->phone) {
                    Http::withHeaders(['Authorization' => config('mykost.fonnte_token')])
                        ->post('https://api.fonnte.com/send', ['target' => $user->phone, 'message' => $msg]);
                }
            } catch (\Throwable $e) {
                $this->warn("Gagal kirim ke {$user->email}: " . $e->getMessage());
            }
        }

        $this->info($bills->count() . ' pengingat diproses.');
        return self::SUCCESS;
    }
}
