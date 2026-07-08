<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Paket gratis untuk mencoba. 1 outlet, 2 user, 100 produk.',
                'price_monthly' => 0,
                'price_yearly' => 0,
                'price_lifetime' => 0,
                'max_outlets' => 1,
                'max_users' => 2,
                'max_products' => 100,
                'max_transactions_per_day' => 50,
                'features' => [
                    'pos-access', 'dashboard-access',
                ],
                'is_active' => true,
                'is_public' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Untuk usaha kecil. 1 outlet, 5 user, 1.000 produk.',
                'price_monthly' => 149000,
                'price_yearly' => 1490000,
                'price_lifetime' => 0,
                'max_outlets' => 1,
                'max_users' => 5,
                'max_products' => 1000,
                'max_transactions_per_day' => 200,
                'features' => [
                    'pos-access', 'dashboard-access',
                    'batch_expiry', 'promo_engine',
                ],
                'is_active' => true,
                'is_public' => true,
                'sort_order' => 20,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Untuk usaha menengah. 3 outlet, 15 user, 10.000 produk.',
                'price_monthly' => 399000,
                'price_yearly' => 3990000,
                'price_lifetime' => 0,
                'max_outlets' => 3,
                'max_users' => 15,
                'max_products' => 10000,
                'max_transactions_per_day' => 1000,
                'features' => [
                    'pos-access', 'dashboard-access',
                    'manufacturing', 'multi_warehouse',
                    'batch_expiry', 'delivery_order',
                    'promo_engine', 'gift_voucher',
                    'commission', 'sales_target',
                    'api_access', 'webhook',
                    'table_management', 'kitchen_display',
                ],
                'is_active' => true,
                'is_public' => true,
                'sort_order' => 30,
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'Untuk usaha besar. 10 outlet, 50 user, 50.000 produk.',
                'price_monthly' => 999000,
                'price_yearly' => 9990000,
                'price_lifetime' => 0,
                'max_outlets' => 10,
                'max_users' => 50,
                'max_products' => 50000,
                'max_transactions_per_day' => 5000,
                'features' => [
                    'pos-access', 'dashboard-access',
                    'manufacturing', 'multi_warehouse',
                    'batch_expiry', 'delivery_order',
                    'quotation', 'promo_engine',
                    'gift_voucher', 'customer_ar',
                    'supplier_performance', 'commission',
                    'sales_target', 'double_entry',
                    'bank_reconciliation', 'production',
                    'table_management', 'kitchen_display',
                    'api_access', 'webhook',
                    'custom_domain', 'custom_smtp',
                    'marketplace_sync',
                ],
                'is_active' => true,
                'is_public' => true,
                'sort_order' => 40,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Untuk korporasi. Unlimited outlet, user, produk. Semua fitur.',
                'price_monthly' => 2499000,
                'price_yearly' => 24990000,
                'price_lifetime' => 0,
                'max_outlets' => 999,
                'max_users' => 999,
                'max_products' => 999999,
                'max_transactions_per_day' => 999999,
                'features' => [
                    'pos-access', 'dashboard-access',
                    'manufacturing', 'multi_warehouse',
                    'batch_expiry', 'delivery_order',
                    'quotation', 'promo_engine',
                    'gift_voucher', 'customer_ar',
                    'supplier_performance', 'commission',
                    'sales_target', 'double_entry',
                    'bank_reconciliation', 'production',
                    'table_management', 'kitchen_display',
                    'api_access', 'webhook',
                    'white_label', 'custom_domain',
                    'custom_smtp', 'marketplace_sync',
                ],
                'is_active' => true,
                'is_public' => true,
                'sort_order' => 50,
            ],
            [
                'name' => 'Lifetime',
                'slug' => 'lifetime',
                'description' => 'Satu kali bayar selamanya. Unlimited semua. Full source code & white label.',
                'price_monthly' => 0,
                'price_yearly' => 0,
                'price_lifetime' => 14999000,
                'max_outlets' => 999,
                'max_users' => 999,
                'max_products' => 999999,
                'max_transactions_per_day' => 999999,
                'features' => [
                    'pos-access', 'dashboard-access',
                    'manufacturing', 'multi_warehouse',
                    'batch_expiry', 'delivery_order',
                    'quotation', 'promo_engine',
                    'gift_voucher', 'customer_ar',
                    'supplier_performance', 'commission',
                    'sales_target', 'double_entry',
                    'bank_reconciliation', 'production',
                    'table_management', 'kitchen_display',
                    'api_access', 'webhook',
                    'white_label', 'custom_domain',
                    'custom_smtp', 'marketplace_sync',
                ],
                'is_active' => true,
                'is_public' => true,
                'sort_order' => 60,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }

        $this->command->info('Subscription plans seeded: ' . count($plans) . ' plans');
    }
}
