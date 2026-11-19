<?php

namespace App\Http\Controllers;

use App\Models\Bill;

class ReportController extends Controller
{
    public function index()
    {
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i)->format('Y-m'));
        $income = $months->map(fn ($m) => (int) Bill::where('status', 'lunas')->where('period', $m)->sum('total'));
        $arrears = $months->map(fn ($m) => (int) Bill::where('status', '!=', 'lunas')->where('period', $m)->sum('total'));
        $unpaid = Bill::where('status', '!=', 'lunas')->with('contract.user', 'contract.room')->orderBy('due_date')->get();
        return view('manage.reports.index', compact('months', 'income', 'arrears', 'unpaid'));
    }
}
