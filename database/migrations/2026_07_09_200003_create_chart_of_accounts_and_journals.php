<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();
            $table->string('code');                  // 1-1000, 1-1100, etc.
            $table->string('name');
            $table->string('type');                  // asset, liability, equity, revenue, expense
            $table->string('normal_balance')->default('debit'); // debit, credit
            $table->boolean('is_active')->default(true);
            $table->boolean('is_system')->default(false);
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->integer('level')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'code']);
            $table->index('type');
            $table->index('parent_id');
        });

        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->string('journal_number')->unique();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignId('outlet_id')->nullable()->constrained('outlets')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('journal_date');
            $table->string('reference_type')->nullable();   // sales, purchase, expense, manual
            $table->bigInteger('reference_id')->nullable();
            $table->string('description');
            $table->string('status')->default('draft');    // draft, posted, void
            $table->decimal('total_debit', 15, 2)->default(0);
            $table->decimal('total_credit', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->foreignId('posted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('journal_date');
            $table->index(['reference_type', 'reference_id']);
        });

        Schema::create('journal_entry_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_entry_id')->constrained('journal_entries')->cascadeOnDelete();
            $table->foreignId('chart_of_account_id')->constrained('chart_of_accounts')->restrictOnDelete();
            $table->string('description')->nullable();
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->foreignId('contact_id')->nullable(); // customer or supplier
            $table->string('contact_type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_entry_items');
        Schema::dropIfExists('journal_entries');
        Schema::dropIfExists('chart_of_accounts');
    }
};
