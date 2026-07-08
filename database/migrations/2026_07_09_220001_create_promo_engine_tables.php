<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buy_x_get_y_promos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->string('name');
            $table->foreignId('buy_product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->integer('buy_quantity');
            $table->foreignId('get_product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->integer('get_quantity');
            $table->string('discount_type')->default('free'); // free, percent
            $table->decimal('discount_value', 5, 2)->default(100);
            $table->boolean('apply_to_same_product')->default(false);
            $table->integer('max_usage_per_transaction')->default(1);
            $table->integer('total_usage_limit')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_stackable')->default(false);
            $table->json('applicable_outlet_ids')->nullable();
            $table->timestamps();
        });

        Schema::create('happy_hour_promos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->string('name');
            $table->string('day_of_week'); // monday,tuesday,... or all
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('discount_percent', 5, 2);
            $table->decimal('max_discount_amount', 15, 2)->nullable();
            $table->decimal('min_purchase_amount', 15, 2)->default(0);
            $table->json('applicable_category_ids')->nullable();
            $table->json('applicable_product_ids')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_stackable')->default(false);
            $table->timestamps();
        });

        Schema::create('member_promos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->string('name');
            $table->foreignId('membership_tier_id')->nullable()->constrained('membership_tiers')->nullOnDelete();
            $table->string('discount_type')->default('percent'); // percent, fixed
            $table->decimal('discount_value', 15, 2);
            $table->decimal('min_purchase', 15, 2)->default(0);
            $table->decimal('max_discount', 15, 2)->nullable();
            $table->integer('max_usage_per_day')->nullable();
            $table->string('applicable_days')->nullable(); // null=all, or specific days
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_stackable')->default(false);
            $table->timestamps();
        });

        Schema::create('bundle_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->string('name');
            $table->decimal('bundle_price', 15, 2);
            $table->decimal('original_price', 15, 2)->default(0);
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('bundle_package_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_package_id')->constrained('bundle_packages')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bundle_package_items');
        Schema::dropIfExists('bundle_packages');
        Schema::dropIfExists('member_promos');
        Schema::dropIfExists('happy_hour_promos');
        Schema::dropIfExists('buy_x_get_y_promos');
    }
};
