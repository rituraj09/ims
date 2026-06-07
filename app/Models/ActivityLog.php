<?php
// app/Models/ActivityLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    const UPDATED_AT = null; // Only created_at

    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'module',
        'subject_type',
        'subject_id',
        'subject_label',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'description',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    // ── Relationships ─────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ── Static Helpers ────────────────────────────────────────────────────

    /**
     * Easily log an activity from anywhere
     */
    public static function log(
        string  $action,
        string  $module,
        ?Model  $subject      = null,
        array   $oldValues    = [],
        array   $newValues    = [],
        ?string $description  = null
    ): self {
        $user = auth()->user();

        return self::create([
            'user_id'       => $user?->id,
            'user_name'     => $user?->name,
            'action'        => $action,
            'module'        => $module,
            'subject_type'  => $subject ? get_class($subject) : null,
            'subject_id'    => $subject?->id,
            'subject_label' => $subject
                ? ($subject->asset_tag ?? $subject->name ?? (string)$subject->id)
                : null,
            'old_values'    => $oldValues ?: null,
            'new_values'    => $newValues ?: null,
            'ip_address'    => request()->ip(),
            'user_agent'    => request()->userAgent(),
            'description'   => $description,
        ]);
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    public function scopeForModule($query, string $module)
    {
        return $query->where('module', $module);
    }

    public function scopeForSubject($query, string $type, int $id)
    {
        return $query->where('subject_type', $type)
                     ->where('subject_id', $id);
    }

    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // ── Accessors ─────────────────────────────────────────────────────────

    public function getActionColorAttribute(): string
    {
        return match ($this->action) {
            'created'    => 'success',
            'updated'    => 'info',
            'deleted'    => 'danger',
            'assigned'   => 'primary',
            'transferred' => 'warning',
            'disposed'   => 'dark',
            default      => 'secondary',
        };
    }
}
