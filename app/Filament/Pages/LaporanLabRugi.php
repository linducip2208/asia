<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class LaporanLabRugi extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static string|\UnitEnum|null $navigationGroup = '📈 Laporan';
    protected static ?string $navigationLabel = 'Laba Rugi';
    protected static ?int $navigationSort = 40;
    protected string $view = 'filament.pages.laporan.laba-rugi';

    public $startDate;
    public $endDate;
    public $totalRevenue = 0;
    public $totalCOGS = 0;
    public $totalExpenses = 0;
    public $grossProfit = 0;
    public $netProfit = 0;
    public $revenueByDay = [];

    public function mount(): void
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
        $this->loadData();
    }

    public function loadData(): void
    {
        $start = Carbon::parse($this->startDate);
        $end = Carbon::parse($this->endDate)->endOfDay();

        $this->totalRevenue = Order::whereBetween('created_at', [$start, $end])
            ->where('order_status', 'completed')
            ->sum('total_amount');

        $this->totalCOGS = Order::whereBetween('created_at', [$start, $end])
            ->where('order_status', 'completed')
            ->sum(DB::raw('total_amount - discount_amount'));

        $this->totalExpenses = DB::table('expense_entries')
            ->whereBetween('transaction_date', [$start, $end])
            ->sum('amount');

        $this->grossProfit = $this->totalRevenue - $this->totalCOGS;
        $this->netProfit = $this->grossProfit - $this->totalExpenses;

        $this->revenueByDay = Order::whereBetween('created_at', [$start, $end])
            ->where('order_status', 'completed')
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, SUM(total_amount - discount_amount) as cogs')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }
}
