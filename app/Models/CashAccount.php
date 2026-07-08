<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashAccount extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'tenant_id', 'outlet_id', 'chart_of_account_id',
        'name', 'code', 'type', 'bank_name', 'account_number', 'account_holder',
        'opening_balance', 'current_balance', 'is_active', 'is_default', 'notes',
    ];

    protected $casts = [
        'opening_balance' => 'decimal:2', 'current_balance' => 'decimal:2',
        'is_active' => 'boolean', 'is_default' => 'boolean',
    ];

    public function outlet(): BelongsTo { return $this->belongsTo(Outlet::class); }
    public function chartOfAccount(): BelongsTo { return $this->belongsTo(ChartOfAccount::class); }
}
