<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'name'];

    public static function getValue($key, $default = null)
    {
        return optional(self::where('key', $key)->first())->value ?? $default;
    }
    public static function getAllDefaults(): array
    {
        return [
            'vat_rate' => [
                'name' => 'Thuế VAT (%)',
                'value' => 10
            ],
            'random_mode' => [
                'name' => 'Loại Nội dung chuyển khoản',
                'value' => 'alphanum'
            ],
            'random_length' => [
                'name' => 'Độ dài nội dung chuyển khoản',
                'value' => 12
            ],
            'random_prefix' => [
                'name' => 'Tiền tố nội dung chuyển khoản',
                'value' => 'NAP-'
            ],
        ];
    }



    public static function generateTransactionId(): string
    {
        $length = min(20, max(6, (int) self::getValue('random_length', 12)));
        $mode = self::getValue('random_mode', 'alphanum');
        $prefix = self::getValue('random_prefix', '');

        switch ($mode) {
            case 'alpha':
                $random = Str::upper(Str::random($length));
                break;
            case 'num':
                $random = '';
                while (strlen($random) < $length) {
                    $random .= mt_rand(0, 9);
                }
                $random = substr($random, 0, $length);
                break;
            case 'alphanum':
            default:
                $random = Str::upper(Str::random($length));
                break;
        }

        return $prefix . $random;
    }

}

