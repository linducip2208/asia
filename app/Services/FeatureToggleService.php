<?php

namespace App\Services;

use App\Models\Tenant;

class FeatureToggleService
{
    protected ?Tenant $tenant = null;

    public function forTenant(?Tenant $tenant): static
    {
        $this->tenant = $tenant;
        return $this;
    }

    public function isEnabled(string $feature): bool
    {
        $tenant = $this->resolveTenant();

        if (!$tenant) {
            return true;
        }

        $features = $tenant->features_override ?? [];

        if (array_key_exists($feature, $features)) {
            return (bool) $features[$feature];
        }

        $plan = $tenant->subscriptionPlan;

        if (!$plan) {
            return false;
        }

        return $plan->hasFeature($feature);
    }

    public function getAllFeatures(): array
    {
        return [
            'manufacturing' => ['label' => 'Produksi / Manufaktur', 'icon' => 'heroicon-o-beaker'],
            'multi_warehouse' => ['label' => 'Multi Gudang', 'icon' => 'heroicon-o-building-office'],
            'batch_expiry' => ['label' => 'Batch & Expiry', 'icon' => 'heroicon-o-clock'],
            'delivery_order' => ['label' => 'Delivery Order', 'icon' => 'heroicon-o-truck'],
            'quotation' => ['label' => 'Quotation', 'icon' => 'heroicon-o-document-text'],
            'gift_voucher' => ['label' => 'Gift Voucher', 'icon' => 'heroicon-o-gift'],
            'customer_ar' => ['label' => 'Piutang Customer', 'icon' => 'heroicon-o-credit-card'],
            'supplier_performance' => ['label' => 'Supplier Performance', 'icon' => 'heroicon-o-chart-bar'],
            'commission' => ['label' => 'Komisi', 'icon' => 'heroicon-o-currency-dollar'],
            'sales_target' => ['label' => 'Target Penjualan', 'icon' => 'heroicon-o-flag'],
            'promo_engine' => ['label' => 'Promo Engine', 'icon' => 'heroicon-o-ticket'],
            'double_entry' => ['label' => 'Double Entry Finance', 'icon' => 'heroicon-o-calculator'],
            'bank_reconciliation' => ['label' => 'Rekonsiliasi Bank', 'icon' => 'heroicon-o-banknotes'],
            'production' => ['label' => 'Produksi', 'icon' => 'heroicon-o-wrench-screwdriver'],
            'table_management' => ['label' => 'Table Management', 'icon' => 'heroicon-o-table-cells'],
            'kitchen_display' => ['label' => 'Kitchen Display', 'icon' => 'heroicon-o-fire'],
            'api_access' => ['label' => 'API Access', 'icon' => 'heroicon-o-code-bracket'],
            'webhook' => ['label' => 'Webhook', 'icon' => 'heroicon-o-link'],
            'white_label' => ['label' => 'White Label', 'icon' => 'heroicon-o-paint-brush'],
            'custom_domain' => ['label' => 'Custom Domain', 'icon' => 'heroicon-o-globe-alt'],
            'custom_smtp' => ['label' => 'Custom SMTP', 'icon' => 'heroicon-o-envelope'],
            'marketplace_sync' => ['label' => 'Marketplace Sync', 'icon' => 'heroicon-o-shopping-bag'],
        ];
    }

    public function getPlanFeatures(): array
    {
        return array_keys($this->getAllFeatures());
    }

    protected function resolveTenant(): ?Tenant
    {
        if ($this->tenant) {
            return $this->tenant;
        }

        if (auth()->check() && auth()->user()->tenant_id) {
            return Tenant::find(auth()->user()->tenant_id);
        }

        return null;
    }
}
