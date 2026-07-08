<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationItem extends Model
{
    protected $fillable = [
        'quotation_id', 'product_id', 'description',
        'quantity', 'unit_price', 'discount_percent', 'discount_amount', 'subtotal',
    ];

    protected $casts = [
        'quantity' => 'integer', 'unit_price' => 'decimal:2',
        'discount_percent' => 'decimal:2', 'discount_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function quotation(): BelongsTo { return $this->belongsTo(Quotation::class); }
    public function product(): BelongsTo { return $this->belongsTo(Product::class); }
}
