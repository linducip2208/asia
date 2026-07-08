<?php

namespace App\Filament\Pages;

use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class LaporanKasir extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-circle';
    protected static string|\UnitEnum|null $navigationGroup = '📈 Laporan';
    protected static ?string $navigationLabel = 'Laporan Kasir';
    protected static ?int $navigationSort = 80;
    protected static ?string $title = 'Laporan Kasir';
    protected string $view = 'filament.pages.laporan.kasir';

    public $startDate;
    public $endDate;
    public $data = [];

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

        $this->data = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->where('orders.order_status', 'completed')
            ->select(
                'users.name',
                DB::raw('COUNT(orders.id) as total_transactions'),
                DB::raw('COALESCE(SUM(orders.total_amount), 0) as total_sales'),
                DB::raw('COALESCE(AVG(orders.total_amount), 0) as avg_transaction')
            )
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_sales')
            ->get()
            ->toArray();
    }
}
