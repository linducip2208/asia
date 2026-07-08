<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class GiftVoucher extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'tenant_id', 'name', 'code', 'type', 'value', 'min_purchase',
        'max_uses', 'used_count', 'total_generated', 'valid_from',
        'valid_until', 'is_active', 'terms_conditions',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_uses' => 'integer',
        'used_count' => 'integer',
        'total_generated' => 'integer',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];

    public function usages(): HasMany { return $this->hasMany(GiftVoucherUsage::class); }
}
