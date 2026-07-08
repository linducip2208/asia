<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChartOfAccount extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'tenant_id', 'parent_id', 'code', 'name', 'type',
        'normal_balance', 'is_active', 'is_system',
        'opening_balance', 'current_balance', 'description', 'level',
    ];

    protected $casts = [
        'is_active' => 'boolean', 'is_system' => 'boolean',
        'opening_balance' => 'decimal:2', 'current_balance' => 'decimal:2',
        'level' => 'integer',
    ];

    public function parent(): BelongsTo { return $this->belongsTo(self::class, 'parent_id'); }
    public function children(): HasMany { return $this->hasMany(self::class, 'parent_id'); }
    public function journalItems(): HasMany { return $this->hasMany(JournalEntryItem::class); }
}
