<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionInvoice;
use Illuminate\Support\Str;

class TenantService
{
    public function create(array $data): Tenant
    {
        $plan = SubscriptionPlan::where('slug', 'free')->first();

        $tenant = Tenant::create([
            'name' => $data['name'],
            'slug' => $data['slug'] ?? Str::slug($data['name']),
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'status' => 'active',
            'subscription_plan_id' => $plan?->id,
            'trial_ends_at' => now()->addDays(14),
            'max_outlets' => $plan?->max_outlets ?? 1,
            'max_users' => $plan?->max_users ?? 5,
            'max_products' => $plan?->max_products ?? 1000,
            'max_transactions_per_day' => $plan?->max_transactions_per_day ?? 200,
            'settings' => [
                'tax_percent' => 11,
                'currency' => 'IDR',
                'timezone' => 'Asia/Jakarta',
                'language' => 'id',
            ],
        ]);

        return $tenant;
    }

    public function updateWhiteLabel(Tenant $tenant, array $data): Tenant
    {
        $tenant->update([
            'logo_url' => $data['logo_url'] ?? $tenant->logo_url,
            'favicon_url' => $data['favicon_url'] ?? $tenant->favicon_url,
            'primary_color' => $data['primary_color'] ?? $tenant->primary_color,
            'custom_domain' => $data['custom_domain'] ?? $tenant->custom_domain,
        ]);

        return $tenant;
    }

    public function getCurrentTenant(): ?Tenant
    {
        if (!auth()->check()) {
            return null;
        }

        return auth()->user()->tenant;
    }

    public function getTenantSetting(string $key, mixed $default = null): mixed
    {
        $tenant = $this->getCurrentTenant();

        if (!$tenant || !$tenant->settings) {
            return $default;
        }

        return $tenant->settings[$key] ?? $default;
    }
}
