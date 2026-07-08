<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'tenant_id', 'outlet_id', 'name', 'code', 'address', 'type',
        'is_active', 'capacity', 'manager_name', 'manager_phone',
    ];

    protected $casts = ['is_active' => 'boolean', 'capacity' => 'integer'];

    public function outlet(): BelongsTo { return $this->belongsTo(Outlet::class); }
    public function batchNumbers() { return $this->hasMany(BatchNumber::class); }
}
