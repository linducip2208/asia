<?php

namespace App\Filament\Pages;

use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class LaporanCustomer extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';
    protected static string|\UnitEnum|null $navigationGroup = '📈 Laporan';
    protected static ?string $navigationLabel = 'Laporan Customer';
    protected static ?int $navigationSort = 60;
    protected static ?string $title = 'Laporan Customer';
    protected string $view = 'filament.pages.laporan.customer';

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

        $this->data = DB::table('customers')
            ->leftJoin('orders', function ($join) use ($start, $end) {
                $join->on('orders.customer_id', '=', 'customers.id')
                    ->whereBetween('orders.created_at', [$start, $end])
                    ->where('orders.order_status', 'completed');
            })
            ->select(
                'customers.name',
                'customers.phone',
                DB::raw('COALESCE(SUM(orders.total_amount), 0) as total_spent'),
                DB::raw('COUNT(orders.id) as total_orders'),
                DB::raw('MAX(orders.created_at) as last_order')
            )
            ->groupBy('customers.id', 'customers.name', 'customers.phone')
            ->orderByDesc('total_spent')
            ->limit(200)
            ->get()
            ->toArray();
    }
}
