<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesTarget extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id', 'user_id', 'outlet_id', 'period', 'target_amount',
        'achieved_amount', 'achievement_percent', 'bonus_amount',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'achieved_amount' => 'decimal:2',
        'achievement_percent' => 'decimal:2',
        'bonus_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function outlet(): BelongsTo { return $this->belongsTo(Outlet::class); }
}
