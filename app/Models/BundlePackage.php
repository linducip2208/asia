<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BundlePackage extends Model
{
    use BelongsToTenant;

    protected $table = 'bundle_packages';

    protected $fillable = [
        'tenant_id', 'name',
        'bundle_price', 'original_price',
        'valid_from', 'valid_until', 'is_active',
    ];

    protected $casts = [
        'bundle_price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(BundlePackageItem::class);
    }
}
