<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'name', 'slug', 'description',
        'price_monthly', 'price_yearly', 'price_lifetime',
        'max_outlets', 'max_users', 'max_products', 'max_transactions_per_day',
        'features', 'is_active', 'is_public', 'sort_order',
    ];

    protected $casts = [
        'price_monthly' => 'integer',
        'price_yearly' => 'integer',
        'price_lifetime' => 'integer',
        'features' => 'array',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
    ];

    public function tenants(): HasMany
    {
        return $this->hasMany(Tenant::class);
    }

    public function subscriptionInvoices(): HasMany
    {
        return $this->hasMany(SubscriptionInvoice::class);
    }

    public function hasFeature(string $feature): bool
    {
        return in_array($feature, $this->features ?? []);
    }

    public function formattedPriceMonthly(): string
    {
        return $this->price_monthly > 0 ? 'Rp ' . number_format($this->price_monthly, 0, ',', '.') : 'Gratis';
    }

    public function formattedPriceYearly(): string
    {
        return $this->price_yearly > 0 ? 'Rp ' . number_format($this->price_yearly, 0, ',', '.') : 'Gratis';
    }
}
