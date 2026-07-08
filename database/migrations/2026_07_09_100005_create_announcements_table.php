<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('type')->default('info'); // info, warning, success, danger
            $table->json('target_tenant_ids')->nullable(); // null = all tenants
            $table->json('target_plan_ids')->nullable();
            $table->dateTime('publish_at')->nullable();
            $table->dateTime('expire_at')->nullable();
            $table->boolean('is_published')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('announcement_tenant', function (Blueprint $table) {
            $table->foreignId('announcement_id')->constrained('announcements')->cascadeOnDelete();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->primary(['announcement_id', 'tenant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_tenant');
        Schema::dropIfExists('announcements');
    }
};
