<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_orders', function (Blueprint $table) {
            $table->id();
            $table->string('production_number')->unique();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignId('outlet_id')->nullable()->constrained('outlets')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('recipe_item_id')->nullable()->constrained('recipe_items')->nullOnDelete();
            $table->integer('planned_quantity');
            $table->integer('actual_quantity')->nullable();
            $table->integer('waste_quantity')->default(0);
            $table->string('status')->default('planned');
            $table->date('planned_start_date')->nullable();
            $table->date('planned_end_date')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('production_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_order_id')->constrained('production_orders')->cascadeOnDelete();
            $table->foreignId('raw_material_id')->nullable()->constrained('products')->nullOnDelete();
            $table->decimal('planned_quantity', 12, 3);
            $table->decimal('actual_quantity', 12, 3)->nullable();
            $table->decimal('waste_quantity', 12, 3)->default(0);
            $table->string('unit')->nullable();
            $table->timestamps();
        });

        Schema::create('gift_vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('type')->default('fixed');
            $table->decimal('value', 15, 2);
            $table->decimal('min_purchase', 15, 2)->default(0);
            $table->integer('max_uses')->default(1);
            $table->integer('used_count')->default(0);
            $table->integer('total_generated')->default(0);
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('terms_conditions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('gift_voucher_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gift_voucher_id')->constrained('gift_vouchers')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->decimal('discount_amount', 15, 2);
            $table->timestamp('used_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gift_voucher_usages');
        Schema::dropIfExists('gift_vouchers');
        Schema::dropIfExists('production_materials');
        Schema::dropIfExists('production_orders');
    }
};
