<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id', 'user_id', 'period', 'total_sales', 'total_profit',
        'commission_amount', 'bonus_amount', 'total_commission',
        'status', 'calculation_detail',
    ];

    protected $casts = [
        'total_sales' => 'decimal:2',
        'total_profit' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'bonus_amount' => 'decimal:2',
        'total_commission' => 'decimal:2',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
