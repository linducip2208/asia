<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatchNumber extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'tenant_id', 'product_id', 'warehouse_id',
        'batch_number', 'production_date', 'expiry_date',
        'initial_quantity', 'current_quantity', 'cost_price',
        'purchase_order_id', 'notes',
    ];

    protected $casts = [
        'production_date' => 'date', 'expiry_date' => 'date',
        'initial_quantity' => 'integer', 'current_quantity' => 'integer',
        'cost_price' => 'decimal:2',
    ];

    public function product(): BelongsTo { return $this->belongsTo(Product::class); }
    public function warehouse(): BelongsTo { return $this->belongsTo(Warehouse::class); }
    public function purchaseOrder(): BelongsTo { return $this->belongsTo(PurchaseOrder::class); }

    public function isExpired(): bool { return $this->expiry_date && $this->expiry_date->isPast(); }
    public function isExpiringSoon(int $days = 30): bool
    {
        return $this->expiry_date && $this->expiry_date->diffInDays(now(), false) <= $days;
    }
}
