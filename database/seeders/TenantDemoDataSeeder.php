<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantDemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $plan = SubscriptionPlan::where('slug', 'enterprise')->first()
            ?? SubscriptionPlan::first();

        $tenant = Tenant::create([
            'name' => 'Toko Demo ERPAsia',
            'slug' => 'demo',
            'email' => 'demo@erpasia.test',
            'phone' => '081234567890',
            'address' => 'Jl. Demo No. 123, Jakarta',
            'npwp' => '12.345.678.9-012.000',
            'status' => 'active',
            'subscription_plan_id' => $plan?->id,
            'trial_ends_at' => now()->addYears(1),
            'subscription_ends_at' => now()->addYears(10),
            'max_outlets' => 999,
            'max_users' => 999,
            'max_products' => 999999,
            'max_transactions_per_day' => 999999,
            'settings' => [
                'tax_percent' => 11,
                'currency' => 'IDR',
                'timezone' => 'Asia/Jakarta',
                'language' => 'id',
            ],
        ]);

        $users = [
            [
                'name' => 'Owner Demo',
                'email' => 'owner@erpasia.test',
                'password' => Hash::make('password'),
                'role' => 'owner',
            ],
            [
                'name' => 'Manager Demo',
                'email' => 'manager@erpasia.test',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ],
            [
                'name' => 'Admin Demo',
                'email' => 'admin@erpasia.test',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Kasir Demo',
                'email' => 'kasir@erpasia.test',
                'password' => Hash::make('password'),
                'role' => 'kasir',
            ],
            [
                'name' => 'Gudang Demo',
                'email' => 'gudang@erpasia.test',
                'password' => Hash::make('password'),
                'role' => 'gudang',
            ],
            [
                'name' => 'Keuangan Demo',
                'email' => 'keuangan@erpasia.test',
                'password' => Hash::make('password'),
                'role' => 'keuangan',
            ],
        ];

        foreach ($users as $userData) {
            $userData['tenant_id'] = $tenant->id;
            User::create($userData);
        }

        $super = User::create([
            'name' => 'Super Admin',
            'email' => 'super@erpasia.test',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'tenant_id' => null,
        ]);

        $this->command->info("Tenant demo created: {$tenant->name} (slug: {$tenant->slug})");
        $this->command->info('Super Admin: super@erpasia.test / password');
        $this->command->info('Tenant users: owner/manager/admin/kasir/gudang/keuangan@erpasia.test / password');
    }
}
