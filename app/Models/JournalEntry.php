<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JournalEntry extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $fillable = [
        'journal_number', 'tenant_id', 'outlet_id', 'user_id',
        'journal_date', 'reference_type', 'reference_id', 'description',
        'status', 'total_debit', 'total_credit', 'notes',
        'posted_at', 'posted_by',
    ];

    protected $casts = [
        'journal_date' => 'date', 'total_debit' => 'decimal:2', 'total_credit' => 'decimal:2',
        'posted_at' => 'datetime',
    ];

    public function outlet(): BelongsTo { return $this->belongsTo(Outlet::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function postedBy(): BelongsTo { return $this->belongsTo(User::class, 'posted_by'); }
    public function items(): HasMany { return $this->hasMany(JournalEntryItem::class); }
}
