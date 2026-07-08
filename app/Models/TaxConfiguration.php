<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaxConfiguration extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id', 'name', 'code', 'rate', 'type',
        'input_coa_id', 'output_coa_id', 'is_active', 'description',
    ];

    protected $casts = ['rate' => 'decimal:2', 'is_active' => 'boolean'];
    public function inputCoa(): BelongsTo { return $this->belongsTo(ChartOfAccount::class, 'input_coa_id'); }
    public function outputCoa(): BelongsTo { return $this->belongsTo(ChartOfAccount::class, 'output_coa_id'); }
}
