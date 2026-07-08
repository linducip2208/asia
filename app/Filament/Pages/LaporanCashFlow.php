<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\CashAccount;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class LaporanCashFlow extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrow-trending-up';
    protected static string|\UnitEnum|null $navigationGroup = '📈 Laporan';
    protected static ?string $navigationLabel = 'Cash Flow';
    protected static ?int $navigationSort = 50;
    protected string $view = 'filament.pages.laporan.cash-flow';

    public $startDate;
    public $endDate;
    public $cashIn = 0;
    public $cashOut = 0;
    public $netCashFlow = 0;
    public $openingBalance = 0;
    public $closingBalance = 0;

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

        $this->cashIn = Order::whereBetween('created_at', [$start, $end])
            ->where('order_status', 'completed')
            ->sum('total_amount');

        $this->cashIn += DB::table('income_entries')
            ->whereBetween('transaction_date', [$start, $end])
            ->sum('amount');

        $this->cashOut = DB::table('expense_entries')
            ->whereBetween('transaction_date', [$start, $end])
            ->sum('amount');

        $this->netCashFlow = $this->cashIn - $this->cashOut;
        $this->openingBalance = CashAccount::sum('opening_balance');
        $this->closingBalance = $this->openingBalance + $this->netCashFlow;
    }
}
