<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value',
        'max_uses', 'used_count',
        'min_subscription_months',
        'applicable_plans',
        'valid_from', 'valid_until',
        'is_active',
    ];

    protected $casts = [
        'value' => 'integer',
        'max_uses' => 'integer',
        'used_count' => 'integer',
        'applicable_plans' => 'array',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        if ($this->valid_from && now()->lessThan($this->valid_from)) return false;
        if ($this->valid_until && now()->greaterThan($this->valid_until)) return false;
        return true;
    }

    public function calculateDiscount(int $amount): int
    {
        if ($this->type === 'percentage') {
            return (int) ($amount * $this->value / 100);
        }
        return min($this->value, $amount);
    }
}
