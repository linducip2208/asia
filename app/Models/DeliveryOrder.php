<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryOrder extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'do_number', 'tenant_id', 'order_id', 'outlet_id', 'customer_id',
        'recipient_name', 'recipient_phone', 'shipping_address',
        'courier', 'tracking_number', 'shipping_cost',
        'status', 'packed_at', 'shipped_at', 'delivered_at',
        'notes', 'packed_by',
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'packed_at' => 'datetime', 'shipped_at' => 'datetime', 'delivered_at' => 'datetime',
    ];

    public function order(): BelongsTo { return $this->belongsTo(Order::class); }
    public function outlet(): BelongsTo { return $this->belongsTo(Outlet::class); }
    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function items(): HasMany { return $this->hasMany(DeliveryOrderItem::class); }
    public function packedBy(): BelongsTo { return $this->belongsTo(User::class, 'packed_by'); }
}
