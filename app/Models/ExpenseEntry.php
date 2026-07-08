<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseEntry extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'expense_number', 'tenant_id', 'outlet_id', 'cash_account_id',
        'chart_of_account_id', 'user_id', 'transaction_date', 'amount',
        'category', 'payment_method', 'recipient', 'reference_number',
        'description', 'attachment', 'status', 'approved_by', 'approved_at', 'journal_entry_id',
    ];

    protected $casts = ['transaction_date' => 'date', 'amount' => 'decimal:2', 'approved_at' => 'datetime'];
    public function cashAccount(): BelongsTo { return $this->belongsTo(CashAccount::class); }
    public function chartOfAccount(): BelongsTo { return $this->belongsTo(ChartOfAccount::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function outlet(): BelongsTo { return $this->belongsTo(Outlet::class); }
    public function approvedBy(): BelongsTo { return $this->belongsTo(User::class, 'approved_by'); }
}
