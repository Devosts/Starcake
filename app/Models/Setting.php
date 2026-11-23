<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    /** Get a setting value by key (cached for 1 hour). */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("setting:$key", 3600, function () use ($key, $default) {
            $row = self::where('key', $key)->first();

            return $row ? $row->value : $default;
        });
    }

    /** Clear cached setting. */
    public static function forget(string $key): void
    {
        Cache::forget("setting:$key");
        Cache::forget('settings_all');
    }

    /** Clear all settings cache. */
    public static function flushCache(): void
    {
        foreach (self::pluck('key') as $key) {
            Cache::forget("setting:$key");
        }

        Cache::forget('settings_all');
    }
}
