<?php
// app/Models/AssetDocument.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetDocument extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asset_id',
        'document_type',
        'title',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'assignment_id',
        'maintenance_id',
        'uploaded_by',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    // ── Relationships ─────────────────────────────────────────────────────

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function assignment()
    {
        return $this->belongsTo(AssetAssignment::class, 'assignment_id');
    }

    public function maintenance()
    {
        return $this->belongsTo(AssetMaintenance::class, 'maintenance_id');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // ── Accessors ─────────────────────────────────────────────────────────

    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size ?? 0;
        if ($bytes >= 1048576)  return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)     return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }

    public function getIconClassAttribute(): string
    {
        return match (true) {
            str_contains($this->file_type, 'pdf')   => 'fas fa-file-pdf text-danger',
            str_contains($this->file_type, 'image') => 'fas fa-file-image text-info',
            str_contains($this->file_type, 'word')  => 'fas fa-file-word text-primary',
            str_contains($this->file_type, 'excel') => 'fas fa-file-excel text-success',
            default                                  => 'fas fa-file text-secondary',
        };
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    public function scopeOfType($query, string $type)
    {
        return $query->where('document_type', $type);
    }
}
