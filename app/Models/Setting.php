<?php
// app/Models/Setting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'label',
        'description',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    // ── Static Helpers ────────────────────────────────────────────────────

    /**
     * Get a setting value with optional default
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        [$group, $name] = self::parseKey($key);

        $cacheKey = "setting.{$group}.{$name}";

        return Cache::rememberForever($cacheKey, function () use ($group, $name, $default) {
            $setting = self::where('group', $group)
                           ->where('key', $name)
                           ->first();

            if (!$setting) {
                return $default;
            }

            return self::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, mixed $value): void
    {
        [$group, $name] = self::parseKey($key);

        self::updateOrCreate(
            ['group' => $group, 'key' => $name],
            ['value' => is_array($value) ? json_encode($value) : $value]
        );

        Cache::forget("setting.{$group}.{$name}");
    }

    /**
     * Get all settings for a group
     */
    public static function getGroup(string $group): array
    {
        $cacheKey = "settings.group.{$group}";

        return Cache::rememberForever($cacheKey, function () use ($group) {
            return self::where('group', $group)
                       ->get()
                       ->mapWithKeys(fn($s) => [
                           $s->key => self::castValue($s->value, $s->type)
                       ])
                       ->toArray();
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        Cache::flush();
    }

    // ── Private Helpers ───────────────────────────────────────────────────

    private static function parseKey(string $key): array
    {
        if (str_contains($key, '.')) {
            [$group, $name] = explode('.', $key, 2);
            return [$group, $name];
        }
        return ['general', $key];
    }

    private static function castValue(mixed $value, string $type): mixed
    {
        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'json'    => json_decode($value, true),
            'float'   => (float) $value,
            default   => $value,
        };
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    public function scopeInGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}
