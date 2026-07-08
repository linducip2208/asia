<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionInvoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_number', 'tenant_id', 'subscription_plan_id',
        'amount', 'paid_amount', 'status',
        'billing_period', 'period_start', 'period_end',
        'paid_at', 'payment_method', 'payment_reference', 'due_date',
    ];

    protected $casts = [
        'amount' => 'integer',
        'paid_amount' => 'integer',
        'period_start' => 'date',
        'period_end' => 'date',
        'paid_at' => 'datetime',
        'due_date' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    public function isOverdue(): bool
    {
        return $this->status === 'overdue' || ($this->status === 'unpaid' && now()->greaterThan($this->due_date));
    }

    public function remainingAmount(): int
    {
        return $this->amount - $this->paid_amount;
    }
}
