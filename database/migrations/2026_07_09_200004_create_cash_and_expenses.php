<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignId('outlet_id')->nullable()->constrained('outlets')->nullOnDelete();
            $table->foreignId('chart_of_account_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('type')->default('cash'); // cash, bank, ewallet
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_holder')->nullable();
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('income_entries', function (Blueprint $table) {
            $table->id();
            $table->string('income_number')->unique();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignId('outlet_id')->nullable()->constrained('outlets')->nullOnDelete();
            $table->foreignId('cash_account_id')->nullable()->constrained('cash_accounts')->nullOnDelete();
            $table->foreignId('chart_of_account_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('transaction_date');
            $table->decimal('amount', 15, 2);
            $table->string('source'); // sales, other_income, receivable_collection, owner_deposit
            $table->string('payment_method')->nullable();
            $table->string('reference_number')->nullable();
            $table->text('description');
            $table->foreignId('journal_entry_id')->nullable()->constrained('journal_entries')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('transaction_date');
        });

        Schema::create('expense_entries', function (Blueprint $table) {
            $table->id();
            $table->string('expense_number')->unique();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignId('outlet_id')->nullable()->constrained('outlets')->nullOnDelete();
            $table->foreignId('cash_account_id')->nullable()->constrained('cash_accounts')->nullOnDelete();
            $table->foreignId('chart_of_account_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('transaction_date');
            $table->decimal('amount', 15, 2);
            $table->string('category'); // salary, rent, utility, marketing, maintenance, other
            $table->string('payment_method')->nullable();
            $table->string('recipient')->nullable();
            $table->string('reference_number')->nullable();
            $table->text('description');
            $table->string('attachment')->nullable();
            $table->string('status')->default('draft'); // draft, approved, paid
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('journal_entry_id')->nullable()->constrained('journal_entries')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('transaction_date');
            $table->index('category');
        });

        Schema::create('cash_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_number')->unique();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->foreignId('from_cash_account_id')->constrained('cash_accounts')->restrictOnDelete();
            $table->foreignId('to_cash_account_id')->constrained('cash_accounts')->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('transfer_date');
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0);
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('journal_entry_id')->nullable()->constrained('journal_entries')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tax_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->string('name'); // PPN, PPh 21, PPh 23, etc.
            $table->string('code');
            $table->decimal('rate', 5, 2); // 11.00 for 11%
            $table->string('type')->default('output'); // output, input
            $table->foreignId('input_coa_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();
            $table->foreignId('output_coa_id')->nullable()->constrained('chart_of_accounts')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_configurations');
        Schema::dropIfExists('cash_transfers');
        Schema::dropIfExists('expense_entries');
        Schema::dropIfExists('income_entries');
        Schema::dropIfExists('cash_accounts');
    }
};
