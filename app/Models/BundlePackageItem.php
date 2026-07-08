<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BundlePackageItem extends Model
{
    protected $table = 'bundle_package_items';

    protected $fillable = [
        'bundle_package_id', 'product_id', 'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function bundlePackage(): BelongsTo
    {
        return $this->belongsTo(BundlePackage::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
