<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'package_id', 'amount', 'currency', 'vat_percent',
        'payment_method', 'payment_gateway', 'transaction_id',
        'status', 'paid_at', 'invoice_number'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function package() {
        return $this->belongsTo(EmployerPackage::class, 'package_id');
    }
}
