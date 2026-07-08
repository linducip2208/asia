<?php

namespace App\Filament\Pages;

use App\Models\Product;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class LaporanProdukTerlaris extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-fire';
    protected static string|\UnitEnum|null $navigationGroup = '📈 Laporan';
    protected static ?string $navigationLabel = 'Produk Terlaris';
    protected static ?int $navigationSort = 31;
    protected string $view = 'filament.pages.laporan.produk-terlaris';

    public $startDate;
    public $endDate;
    public $products = [];

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

        $this->products = Product::select(
            'products.id', 'products.name', 'products.sku',
            'categories.name as category_name',
            DB::raw('SUM(order_items.quantity) as total_qty'),
            DB::raw('SUM(order_items.subtotal) as total_revenue')
        )
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.order_status', 'completed')
            ->whereBetween('orders.created_at', [$start, $end])
            ->groupBy('products.id', 'products.name', 'products.sku', 'categories.name')
            ->orderByDesc('total_qty')
            ->limit(50)
            ->get()
            ->toArray();
    }
}
