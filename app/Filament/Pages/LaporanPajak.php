<?php

namespace App\Filament\Pages;

use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class LaporanPajak extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calculator';
    protected static string|\UnitEnum|null $navigationGroup = '📈 Laporan';
    protected static ?string $navigationLabel = 'Laporan Pajak';
    protected static ?int $navigationSort = 100;
    protected static ?string $title = 'Laporan Pajak';
    protected string $view = 'filament.pages.laporan.pajak';

    public $startDate;
    public $endDate;
    public $totalTaxOutput = 0;
    public $totalSales = 0;
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

        $base = DB::table('orders')
            ->whereBetween('created_at', [$start, $end])
            ->where('order_status', 'completed');

        $this->totalTaxOutput = (float) (clone $base)->sum('tax_amount');
        $this->totalSales = (float) (clone $base)->sum('subtotal');

        $this->data = DB::table('orders')
            ->whereBetween('created_at', [$start, $end])
            ->where('order_status', 'completed')
            ->selectRaw('DATE(created_at) as date, SUM(subtotal) as dpp, SUM(tax_amount) as tax')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }
}
