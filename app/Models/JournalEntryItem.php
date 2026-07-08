<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class JournalEntryItem extends Model
{
    protected $fillable = [
        'journal_entry_id', 'chart_of_account_id', 'description',
        'debit', 'credit', 'contact_id', 'contact_type',
    ];

    protected $casts = ['debit' => 'decimal:2', 'credit' => 'decimal:2'];

    public function journalEntry(): BelongsTo { return $this->belongsTo(JournalEntry::class); }
    public function chartOfAccount(): BelongsTo { return $this->belongsTo(ChartOfAccount::class); }
    public function contact(): MorphTo { return $this->morphTo(); }
}
