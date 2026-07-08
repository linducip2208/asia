<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReceipt extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'receipt_number', 'tenant_id', 'purchase_order_id', 'supplier_id',
        'outlet_id', 'warehouse_id', 'user_id', 'receipt_date',
        'supplier_invoice_number', 'total_amount', 'status', 'notes',
    ];

    protected $casts = [
        'receipt_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function purchaseOrder(): BelongsTo { return $this->belongsTo(PurchaseOrder::class); }
    public function supplier(): BelongsTo { return $this->belongsTo(Supplier::class); }
    public function outlet(): BelongsTo { return $this->belongsTo(Outlet::class); }
    public function warehouse(): BelongsTo { return $this->belongsTo(Warehouse::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function items(): HasMany { return $this->hasMany(PurchaseReceiptItem::class); }
}
