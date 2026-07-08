<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('domain')->nullable();
            $table->string('custom_domain')->nullable()->unique();
            $table->string('logo_url')->nullable();
            $table->string('favicon_url')->nullable();
            $table->string('primary_color', 7)->default('#3B82F6');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('npwp', 30)->nullable();
            $table->string('status')->default('trial'); // trial, active, suspended, expired
            $table->dateTime('trial_ends_at')->nullable();
            $table->dateTime('subscription_ends_at')->nullable();
            $table->foreignId('subscription_plan_id')->nullable()->constrained('subscription_plans')->nullOnDelete();
            $table->json('settings')->nullable(); // tax_percent, currency, timezone, language
            $table->json('features_override')->nullable(); // override per tenant
            $table->integer('max_outlets')->default(1);
            $table->integer('max_users')->default(5);
            $table->integer('max_products')->default(1000);
            $table->integer('max_transactions_per_day')->default(200);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
