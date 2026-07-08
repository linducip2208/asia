<?php

namespace App\Filament\Super\Pages;

use App\Models\SubscriptionInvoice;
use App\Models\Tenant;
use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class SubscriptionDashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    protected static string|UnitEnum|null $navigationGroup = '📊 Monitoring';
    protected static ?string $navigationLabel = 'Subscription Dashboard';
    protected static ?string $title = 'Subscription Dashboard';
    protected static ?int $navigationSort = 10;
    protected string $view = 'filament.super.subscription-dashboard';

    public int $totalActive = 0;
    public int $totalTrial = 0;
    public int $totalSuspended = 0;
    public int $totalExpired = 0;
    public float $mrr = 0;
    public float $churnRate = 0;
    public $recentInvoices = [];

    public function mount(): void
    {
        $this->totalActive = Tenant::query()->where('status', 'active')->count();
        $this->totalTrial = Tenant::query()->where('status', 'trial')->count();
        $this->totalSuspended = Tenant::query()->where('status', 'suspended')->count();
        $this->totalExpired = Tenant::query()->where('status', 'expired')->count();

        $this->mrr = (float) SubscriptionInvoice::query()
            ->where('status', 'paid')
            ->whereBetween('paid_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('paid_amount');

        $totalTenants = Tenant::query()->count();
        $churned = Tenant::query()->whereIn('status', ['expired', 'suspended'])->count();
        $this->churnRate = $totalTenants > 0 ? round(($churned / $totalTenants) * 100, 2) : 0;

        $this->recentInvoices = SubscriptionInvoice::query()
            ->with(['tenant:id,name', 'subscriptionPlan:id,name'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
    }
}
