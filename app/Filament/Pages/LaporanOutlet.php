<?php

namespace App\Filament\Pages;

use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class LaporanOutlet extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-storefront';
    protected static string|\UnitEnum|null $navigationGroup = '📈 Laporan';
    protected static ?string $navigationLabel = 'Laporan Outlet';
    protected static ?int $navigationSort = 90;
    protected static ?string $title = 'Laporan Outlet';
    protected string $view = 'filament.pages.laporan.outlet';

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

        $this->data = DB::table('outlets')
            ->leftJoin('orders', function ($join) use ($start, $end) {
                $join->on('orders.outlet_id', '=', 'outlets.id')
                    ->whereBetween('orders.created_at', [$start, $end])
                    ->where('orders.order_status', 'completed');
            })
            ->select(
                'outlets.name',
                'outlets.code',
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('COALESCE(SUM(orders.total_amount), 0) as total_sales'),
                DB::raw('COALESCE(AVG(orders.total_amount), 0) as avg_order')
            )
            ->groupBy('outlets.id', 'outlets.name', 'outlets.code')
            ->orderByDesc('total_sales')
            ->get()
            ->toArray();
    }
}
