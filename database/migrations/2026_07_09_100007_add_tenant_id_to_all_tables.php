<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add tenant_id to users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')->constrained('tenants')->nullOnDelete();
        });

        // Master Data tables
        $masterTables = [
            'outlets', 'categories', 'brands', 'units',
            'customer_groups', 'payment_methods', 'loyalty_rewards',
            'suppliers', 'membership_tiers',
        ];

        foreach ($masterTables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'tenant_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreignId('tenant_id')->nullable()->after('id')->constrained('tenants')->nullOnDelete();
                });
            }
        }

        // Transaction tables
        $transactionTables = [
            'products', 'product_variants', 'customers',
            'orders', 'order_items', 'payments',
            'purchase_orders', 'purchase_order_items',
            'stock_movements', 'stock_opnames', 'stock_opname_items',
            'stock_transfers', 'stock_transfer_items',
            'loyalty_points', 'held_carts',
            'shifts', 'cash_drawer_transactions',
            'returs', 'return_items',
            'supplier_payables', 'payable_payments',
            'discount_templates', 'recipe_items', 'raw_materials',
            'attendances', 'kitchen_tickets',
            'table_restos', 'table_areas',
            'providers', 'system_settings',
            'audit_logs', 'blog_posts', 'blog_categories',
            'payment_proofs', 'notifications',
        ];

        foreach ($transactionTables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'tenant_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreignId('tenant_id')->nullable()->after('id')->constrained('tenants')->nullOnDelete();
                });
            }
        }

        // Pivot tables
        $pivotTables = ['outlet_user'];
        foreach ($pivotTables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'tenant_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreignId('tenant_id')->nullable()->after('user_id')->constrained('tenants')->nullOnDelete();
                });
            }
        }
    }

    public function down(): void
    {
        $allTables = [
            'users', 'outlets', 'categories', 'brands', 'units',
            'customer_groups', 'payment_methods', 'loyalty_rewards',
            'suppliers', 'membership_tiers',
            'products', 'product_variants', 'customers',
            'orders', 'order_items', 'payments',
            'purchase_orders', 'purchase_order_items',
            'stock_movements', 'stock_opnames', 'stock_opname_items',
            'stock_transfers', 'stock_transfer_items',
            'loyalty_points', 'held_carts',
            'shifts', 'cash_drawer_transactions',
            'returs', 'return_items',
            'supplier_payables', 'payable_payments',
            'discount_templates', 'recipe_items', 'raw_materials',
            'attendances', 'kitchen_tickets',
            'table_restos', 'table_areas',
            'providers', 'system_settings',
            'audit_logs', 'blog_posts', 'blog_categories',
            'payment_proofs', 'notifications',
            'outlet_user',
        ];

        foreach ($allTables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'tenant_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropForeign(['tenant_id']);
                    $table->dropColumn('tenant_id');
                });
            }
        }
    }
};
