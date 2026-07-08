<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashTransfer extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'transfer_number', 'tenant_id', 'from_cash_account_id', 'to_cash_account_id',
        'user_id', 'transfer_date', 'amount', 'fee',
        'reference_number', 'notes', 'journal_entry_id',
    ];

    protected $casts = ['transfer_date' => 'date', 'amount' => 'decimal:2', 'fee' => 'decimal:2'];
    public function fromAccount(): BelongsTo { return $this->belongsTo(CashAccount::class, 'from_cash_account_id'); }
    public function toAccount(): BelongsTo { return $this->belongsTo(CashAccount::class, 'to_cash_account_id'); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
