<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionOrder extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'production_number', 'tenant_id', 'outlet_id', 'user_id',
        'recipe_item_id', 'planned_quantity', 'actual_quantity',
        'waste_quantity', 'status', 'planned_start_date', 'planned_end_date',
        'started_at', 'completed_at', 'notes',
    ];

    protected $casts = [
        'planned_quantity' => 'integer',
        'actual_quantity' => 'integer',
        'waste_quantity' => 'integer',
        'planned_start_date' => 'date',
        'planned_end_date' => 'date',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function outlet(): BelongsTo { return $this->belongsTo(Outlet::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function recipeItem(): BelongsTo { return $this->belongsTo(RecipeItem::class); }
    public function materials(): HasMany { return $this->hasMany(ProductionMaterial::class); }
}
