<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class BankAccount extends Model
{
    use HasFactory;

    /**
     * Các trường cho phép gán hàng loạt (mass assignable)
     */
    protected $fillable = [
        'bank',
        'account_number',
        'token',
        'password',
        'branch',
        'image',
        'is_active',
    ];

    /**
     * Set giá trị token (mã hóa)
     */
    public function setTokenAttribute($value)
    {
        $this->attributes['token'] = Crypt::encryptString($value);
    }

    /**
     * Get giá trị token (giải mã)
     */
    public function getTokenAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    /**
     * Set mật khẩu (mã hóa)
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Crypt::encryptString($value);
    }

    /**
     * Get mật khẩu (giải mã nếu có)
     */
    public function getPasswordAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    /**
     * Mối quan hệ với giao dịch (bank_logs)
     */
    public function transactions()
    {
        return $this->hasMany(BankLog::class);
    }
}
