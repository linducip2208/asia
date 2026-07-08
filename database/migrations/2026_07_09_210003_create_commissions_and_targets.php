<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('period'); // YYYY-MM
            $table->decimal('total_sales', 15, 2)->default(0);
            $table->decimal('total_profit', 15, 2)->default(0);
            $table->decimal('commission_amount', 15, 2)->default(0);
            $table->decimal('bonus_amount', 15, 2)->default(0);
            $table->decimal('total_commission', 15, 2)->default(0);
            $table->string('status')->default('calculated');
            $table->text('calculation_detail')->nullable();
            $table->timestamps();
        });

        Schema::create('sales_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('outlet_id')->nullable()->constrained('outlets')->nullOnDelete();
            $table->string('period');
            $table->decimal('target_amount', 15, 2);
            $table->decimal('achieved_amount', 15, 2)->default(0);
            $table->decimal('achievement_percent', 5, 2)->default(0);
            $table->decimal('bonus_amount', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('gift_voucher_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->string('name');
            $table->string('prefix')->default('VCR');
            $table->integer('quantity');
            $table->decimal('value', 15, 2);
            $table->string('type')->default('fixed');
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->decimal('min_purchase', 15, 2)->default(0);
            $table->timestamp('generated_at')->nullable();
            $table->foreignId('generated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gift_voucher_batches');
        Schema::dropIfExists('sales_targets');
        Schema::dropIfExists('commissions');
    }
};
