<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Outlet;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class LaporanDashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar-square';
    protected static string|\UnitEnum|null $navigationGroup = '📈 Laporan';
    protected static ?string $navigationLabel = 'Dashboard Analytics';
    protected static ?int $navigationSort = 10;
    protected string $view = 'filament.pages.laporan.dashboard-analytics';

    public $todayRevenue = 0;
    public $todayOrders = 0;
    public $totalProducts = 0;
    public $totalCustomers = 0;
    public $thisMonthRevenue = 0;
    public $lastMonthRevenue = 0;
    public $growthPercent = 0;
    public $topProducts = [];
    public $revenueByOutlet = [];
    public $salesByDay = [];

    public function mount(): void
    {
        $this->todayRevenue = Order::whereDate('created_at', today())
            ->where('order_status', 'completed')->sum('total_amount');
        $this->todayOrders = Order::whereDate('created_at', today())->count();
        $this->totalProducts = Product::count();
        $this->totalCustomers = Customer::count();

        $this->thisMonthRevenue = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('order_status', 'completed')->sum('total_amount');
        $this->lastMonthRevenue = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->where('order_status', 'completed')->sum('total_amount');
        $this->growthPercent = $this->lastMonthRevenue > 0
            ? round(($this->thisMonthRevenue - $this->lastMonthRevenue) / $this->lastMonthRevenue * 100, 1)
            : 0;

        $this->topProducts = Product::select('products.name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.order_status', 'completed')
            ->whereMonth('orders.created_at', now()->month)
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_qty')
            ->limit(10)->get()->toArray();

        $this->revenueByOutlet = Outlet::select('outlets.name', DB::raw('SUM(orders.total_amount) as revenue'))
            ->leftJoin('orders', 'outlets.id', '=', 'orders.outlet_id')
            ->where('orders.order_status', 'completed')
            ->whereMonth('orders.created_at', now()->month)
            ->groupBy('outlets.id', 'outlets.name')
            ->get()->toArray();

        $this->salesByDay = Order::where('order_status', 'completed')
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')->orderBy('date')
            ->get()->toArray();
    }
}
