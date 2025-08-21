<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiConfig extends Model
{
    protected $fillable = ['key', 'value', 'name'];

    /**
     * Lấy giá trị theo key
     */
    public static function getValue(string $key, $default = null)
    {
        return optional(self::where('key', $key)->first())->value ?? $default;
    }

    /**
     * Cập nhật giá trị theo key
     */
    public static function setValue(string $key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
