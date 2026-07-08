<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\User;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class LaporanPembelian extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';
    protected static string|\UnitEnum|null $navigationGroup = '📈 Laporan';
    protected static ?string $navigationLabel = 'Laporan Pembelian';
    protected static ?int $navigationSort = 20;
    protected string $view = 'filament.pages.laporan.pembelian';

    public $startDate;
    public $endDate;
    public $totalPO = 0;
    public $totalAmount = 0;
    public $totalReceived = 0;
    public $poBySupplier = [];
    public $purchaseByDay = [];

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

        $this->totalPO = DB::table('purchase_orders')->whereBetween('created_at', [$start, $end])->count();
        $this->totalAmount = DB::table('purchase_orders')->whereBetween('created_at', [$start, $end])->sum('total_amount');
        $this->totalReceived = DB::table('purchase_orders')->where('status', 'received')->whereBetween('created_at', [$start, $end])->count();

        $this->poBySupplier = DB::table('purchase_orders')
            ->join('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
            ->whereBetween('purchase_orders.created_at', [$start, $end])
            ->select('suppliers.name', DB::raw('COUNT(*) as total_po'), DB::raw('SUM(total_amount) as total_amount'))
            ->groupBy('suppliers.name')->orderByDesc('total_amount')->get()->toArray();

        $this->purchaseByDay = DB::table('purchase_orders')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')->orderBy('date')->get()->toArray();
    }
}
