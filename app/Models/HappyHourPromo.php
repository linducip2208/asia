<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class HappyHourPromo extends Model
{
    use BelongsToTenant;

    protected $table = 'happy_hour_promos';

    protected $fillable = [
        'tenant_id', 'name',
        'day_of_week', 'start_time', 'end_time',
        'discount_percent', 'max_discount_amount', 'min_purchase_amount',
        'applicable_category_ids', 'applicable_product_ids',
        'is_active', 'is_stackable',
    ];

    protected $casts = [
        'discount_percent' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'min_purchase_amount' => 'decimal:2',
        'applicable_category_ids' => 'array',
        'applicable_product_ids' => 'array',
        'is_active' => 'boolean',
        'is_stackable' => 'boolean',
    ];
}
