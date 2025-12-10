<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group'];

    public static function get($key, $default = null)
    {
        $setting = cache()->remember("setting.{$key}", 3600, fn() => static::where('key', $key)->first());
        return $setting?->value ?? $default;
    }

    public static function set($key, $value)
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        cache()->forget("setting.{$key}");
    }
}