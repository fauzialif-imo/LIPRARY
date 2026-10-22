<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'key';
    protected $keyType    = 'string';
    public $incrementing  = false;
    protected $fillable   = ['key', 'value'];

    protected static array $cache  = [];
    protected static bool  $loaded = false;

    protected static function loadAll(): void
    {
        if (static::$loaded) return;
        try {
            static::$cache  = static::pluck('value', 'key')->toArray();
            static::$loaded = true;
        } catch (\Throwable $e) {
            static::$loaded = true;
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        static::loadAll();
        if (!array_key_exists($key, static::$cache)) return $default;
        return static::$cache[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        static::$cache[$key] = $value;
    }

    public static function clearCache(): void
    {
        static::$cache  = [];
        static::$loaded = false;
    }
}
