<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionMaterial extends Model
{
    protected $fillable = [
        'production_order_id', 'raw_material_id', 'planned_quantity',
        'actual_quantity', 'waste_quantity', 'unit',
    ];

    protected $casts = [
        'planned_quantity' => 'decimal:3',
        'actual_quantity' => 'decimal:3',
        'waste_quantity' => 'decimal:3',
    ];

    public function productionOrder(): BelongsTo { return $this->belongsTo(ProductionOrder::class); }
    public function rawMaterial(): BelongsTo { return $this->belongsTo(Product::class, 'raw_material_id'); }
}
