<?php

namespace App\Filament\Pages;

use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class LaporanSupplier extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-truck';
    protected static string|\UnitEnum|null $navigationGroup = '📈 Laporan';
    protected static ?string $navigationLabel = 'Laporan Supplier';
    protected static ?int $navigationSort = 70;
    protected static ?string $title = 'Laporan Supplier';
    protected string $view = 'filament.pages.laporan.supplier';

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

        $this->data = DB::table('suppliers')
            ->leftJoin('purchase_orders', function ($join) use ($start, $end) {
                $join->on('purchase_orders.supplier_id', '=', 'suppliers.id')
                    ->whereBetween('purchase_orders.created_at', [$start, $end]);
            })
            ->select(
                'suppliers.name',
                'suppliers.phone',
                DB::raw('COUNT(purchase_orders.id) as total_po'),
                DB::raw('COALESCE(SUM(purchase_orders.total_amount), 0) as total_amount')
            )
            ->groupBy('suppliers.id', 'suppliers.name', 'suppliers.phone')
            ->orderByDesc('total_amount')
            ->limit(200)
            ->get()
            ->toArray();
    }
}
