<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberPromo extends Model
{
    use BelongsToTenant;

    protected $table = 'member_promos';

    protected $fillable = [
        'tenant_id', 'name', 'membership_tier_id',
        'discount_type', 'discount_value', 'min_purchase', 'max_discount',
        'max_usage_per_day', 'applicable_days',
        'valid_from', 'valid_until',
        'is_active', 'is_stackable',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'max_usage_per_day' => 'integer',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'is_stackable' => 'boolean',
    ];

    public function membershipTier(): BelongsTo
    {
        return $this->belongsTo(MembershipTier::class);
    }
}
