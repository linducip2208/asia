<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Announcement extends Model
{
    protected $fillable = [
        'title', 'content', 'type',
        'target_tenant_ids', 'target_plan_ids',
        'publish_at', 'expire_at',
        'is_published', 'created_by',
    ];

    protected $casts = [
        'target_tenant_ids' => 'array',
        'target_plan_ids' => 'array',
        'publish_at' => 'datetime',
        'expire_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class, 'announcement_tenant')
            ->withPivot('is_read', 'read_at')
            ->withTimestamps();
    }

    public function isVisible(): bool
    {
        if (!$this->is_published) return false;
        if ($this->publish_at && now()->lessThan($this->publish_at)) return false;
        if ($this->expire_at && now()->greaterThan($this->expire_at)) return false;
        return true;
    }
}
