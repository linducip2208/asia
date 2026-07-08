<?php

namespace App\Filament\Pages;

use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class LaporanRekapHarian extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static string|\UnitEnum|null $navigationGroup = '📈 Laporan';
    protected static ?string $navigationLabel = 'Rekap Harian';
    protected static ?int $navigationSort = 130;
    protected static ?string $title = 'Rekap Harian';
    protected string $view = 'filament.pages.laporan.rekap-harian';

    public $startDate;
    public $endDate;
    public $data = [];
    public $totals = [];

    public function mount(): void
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
        $this->loadData();
    }

    public function loadData(): void
    {
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        $sales = DB::table('orders')
            ->whereBetween('created_at', [$start, $end])
            ->where('order_status', 'completed')
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')->pluck('total', 'date');

        $purchases = DB::table('purchase_orders')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')->pluck('total', 'date');

        $expenses = DB::table('expense_entries')
            ->whereBetween('transaction_date', [$this->startDate, $this->endDate])
            ->selectRaw('DATE(transaction_date) as date, SUM(amount) as total')
            ->groupBy('date')->pluck('total', 'date');

        $dates = collect($sales->keys())
            ->merge($purchases->keys())
            ->merge($expenses->keys())
            ->unique()->sort()->values();

        $rows = [];
        $tSales = $tPurchases = $tExpenses = $tProfit = 0;
        foreach ($dates as $date) {
            $s = (float) ($sales[$date] ?? 0);
            $p = (float) ($purchases[$date] ?? 0);
            $e = (float) ($expenses[$date] ?? 0);
            $profit = $s - $p - $e;
            $rows[] = [
                'date' => $date,
                'sales' => $s,
                'purchases' => $p,
                'expenses' => $e,
                'profit' => $profit,
            ];
            $tSales += $s;
            $tPurchases += $p;
            $tExpenses += $e;
            $tProfit += $profit;
        }

        $this->data = $rows;
        $this->totals = [
            'sales' => $tSales,
            'purchases' => $tPurchases,
            'expenses' => $tExpenses,
            'profit' => $tProfit,
        ];
    }
}
