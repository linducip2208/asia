<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuyXGetYPromo extends Model
{
    use BelongsToTenant;

    protected $table = 'buy_x_get_y_promos';

    protected $fillable = [
        'tenant_id', 'name',
        'buy_product_id', 'buy_quantity',
        'get_product_id', 'get_quantity',
        'discount_type', 'discount_value', 'apply_to_same_product',
        'max_usage_per_transaction', 'total_usage_limit',
        'valid_from', 'valid_until',
        'is_active', 'is_stackable', 'applicable_outlet_ids',
    ];

    protected $casts = [
        'buy_quantity' => 'integer',
        'get_quantity' => 'integer',
        'discount_value' => 'decimal:2',
        'apply_to_same_product' => 'boolean',
        'max_usage_per_transaction' => 'integer',
        'total_usage_limit' => 'integer',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
        'is_stackable' => 'boolean',
        'applicable_outlet_ids' => 'array',
    ];

    public function buyProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'buy_product_id');
    }

    public function getProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'get_product_id');
    }
}
