<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');             // Free, Starter, Professional, Business, Enterprise, Lifetime
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->bigInteger('price_monthly')->default(0);   // in IDR
            $table->bigInteger('price_yearly')->default(0);
            $table->bigInteger('price_lifetime')->default(0);
            $table->integer('max_outlets')->default(1);
            $table->integer('max_users')->default(5);
            $table->integer('max_products')->default(1000);
            $table->integer('max_transactions_per_day')->default(200);
            $table->json('features');            // list of enabled feature keys
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
