<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftVoucherBatch extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id', 'name', 'prefix', 'quantity', 'value', 'type',
        'valid_from', 'valid_until', 'min_purchase', 'generated_at', 'generated_by',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'generated_at' => 'datetime',
    ];

    public function generatedBy(): BelongsTo { return $this->belongsTo(User::class, 'generated_by'); }
}
