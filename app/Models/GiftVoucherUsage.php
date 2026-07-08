<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftVoucherUsage extends Model
{
    protected $fillable = [
        'gift_voucher_id', 'customer_id', 'order_id',
        'discount_amount', 'used_at',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'used_at' => 'datetime',
    ];

    public function giftVoucher(): BelongsTo { return $this->belongsTo(GiftVoucher::class); }
    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function order(): BelongsTo { return $this->belongsTo(Order::class); }
}
