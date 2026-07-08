<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeEntry extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'income_number', 'tenant_id', 'outlet_id', 'cash_account_id',
        'chart_of_account_id', 'user_id', 'transaction_date', 'amount',
        'source', 'payment_method', 'reference_number', 'description', 'journal_entry_id',
    ];

    protected $casts = ['transaction_date' => 'date', 'amount' => 'decimal:2'];
    public function cashAccount(): BelongsTo { return $this->belongsTo(CashAccount::class); }
    public function chartOfAccount(): BelongsTo { return $this->belongsTo(ChartOfAccount::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function outlet(): BelongsTo { return $this->belongsTo(Outlet::class); }
}
