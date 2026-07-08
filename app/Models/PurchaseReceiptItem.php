<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseReceiptItem extends Model
{
    protected $fillable = [
        'purchase_receipt_id', 'product_id', 'quantity_ordered',
        'quantity_received', 'unit_price', 'subtotal',
        'batch_number', 'expiry_date',
    ];

    protected $casts = [
        'quantity_ordered' => 'integer',
        'quantity_received' => 'integer',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'expiry_date' => 'date',
    ];

    public function purchaseReceipt(): BelongsTo { return $this->belongsTo(PurchaseReceipt::class); }
    public function product(): BelongsTo { return $this->belongsTo(Product::class); }
}
