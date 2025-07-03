<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_account_id',
        'trans_id',
        'amount',
        'trans_time',
        'type',
        'description',
        'is_used',
        'matched_payment_id',
    ];

    protected $casts = [
        'trans_time' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Giao dịch thuộc về tài khoản ngân hàng
     */
    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }


}

