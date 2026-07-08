<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quotation extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'quotation_number', 'tenant_id', 'customer_id', 'outlet_id', 'user_id',
        'subtotal', 'discount_amount', 'tax_amount', 'total_amount',
        'status', 'valid_until', 'notes', 'terms_conditions',
        'sent_at', 'accepted_at', 'converted_order_id',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2', 'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2', 'total_amount' => 'decimal:2',
        'valid_until' => 'date', 'sent_at' => 'datetime', 'accepted_at' => 'datetime',
    ];

    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function outlet(): BelongsTo { return $this->belongsTo(Outlet::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function items(): HasMany { return $this->hasMany(QuotationItem::class); }
    public function convertedOrder(): BelongsTo { return $this->belongsTo(Order::class, 'converted_order_id'); }
}
