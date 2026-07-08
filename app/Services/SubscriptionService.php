<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\SubscriptionInvoice;
use App\Models\Coupon;
use Illuminate\Support\Str;

class SubscriptionService
{
    public function generateInvoice(Tenant $tenant, ?Coupon $coupon = null): SubscriptionInvoice
    {
        $plan = $tenant->subscriptionPlan;

        if (!$plan) {
            throw new \Exception('Tenant tidak memiliki subscription plan.');
        }

        $billingPeriod = $plan->price_monthly > 0 ? 'monthly' : ($plan->price_yearly > 0 ? 'yearly' : 'lifetime');
        $amount = match ($billingPeriod) {
            'monthly' => $plan->price_monthly,
            'yearly' => $plan->price_yearly,
            'lifetime' => $plan->price_lifetime,
            default => 0,
        };

        if ($coupon && $coupon->isValid()) {
            $amount = $amount - $coupon->calculateDiscount($amount);
            $coupon->increment('used_count');
        }

        $invoice = SubscriptionInvoice::create([
            'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
            'tenant_id' => $tenant->id,
            'subscription_plan_id' => $plan->id,
            'amount' => $amount,
            'paid_amount' => 0,
            'status' => 'unpaid',
            'billing_period' => $billingPeriod,
            'period_start' => now()->startOfDay(),
            'period_end' => match ($billingPeriod) {
                'monthly' => now()->addDays(30)->endOfDay(),
                'yearly' => now()->addDays(365)->endOfDay(),
                default => now()->addYears(100)->endOfDay(),
            },
            'due_date' => now()->addDays(7),
        ]);

        return $invoice;
    }

    public function markAsPaid(SubscriptionInvoice $invoice, array $paymentData): SubscriptionInvoice
    {
        $invoice->update([
            'status' => 'paid',
            'paid_amount' => $invoice->amount,
            'paid_at' => now(),
            'payment_method' => $paymentData['method'] ?? 'unknown',
            'payment_reference' => $paymentData['reference'] ?? null,
        ]);

        $tenant = $invoice->tenant;
        $tenant->update([
            'status' => 'active',
            'subscription_ends_at' => $invoice->period_end,
        ]);

        return $invoice;
    }

    public function checkExpiredSubscriptions(): void
    {
        $tenants = Tenant::where('status', 'active')
            ->whereNotNull('subscription_ends_at')
            ->where('subscription_ends_at', '<', now())
            ->get();

        foreach ($tenants as $tenant) {
            $tenant->update(['status' => 'expired']);
        }

        $graceTenants = Tenant::where('status', 'expired')
            ->where('subscription_ends_at', '<', now()->subDays(3))
            ->get();

        foreach ($graceTenants as $tenant) {
            $tenant->update(['status' => 'suspended']);
        }
    }

    public function getProratedAmount(Tenant $tenant, SubscriptionPlan $newPlan): int
    {
        if (!$tenant->subscription_ends_at) {
            return $newPlan->price_monthly;
        }

        $remainingDays = max(0, now()->diffInDays($tenant->subscription_ends_at, false));
        $totalDays = match ($tenant->subscriptionPlan?->price_monthly > 0 ? 'monthly' : 'yearly') {
            'monthly' => 30,
            'yearly' => 365,
            default => 30,
        };

        $remainingValue = ($tenant->subscriptionPlan->price_monthly * $remainingDays / $totalDays);
        return max(0, (int) ($newPlan->price_monthly - $remainingValue));
    }
}
