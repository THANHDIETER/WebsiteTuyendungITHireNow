<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    public $timestamps = true;
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $fillable = [
        'user_id',
        'package_id',
        'amount',
        'currency',
        'vat_percent',
        'payment_method',
        'payment_gateway',
        'transaction_id',
        'status',
        'paid_at',
        'invoice_number'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function statusLabel(): string
    {
        $labels = [
            'pending' => [
                'label' => '<i class="fas fa-hourglass-half me-1"></i> Chờ thanh toán',
                'class' => 'badge bg-warning text-dark',
            ],
            'paid' => [
                'label' => '<i class="fas fa-check-circle me-1"></i> Đã thanh toán',
                'class' => 'badge bg-success',
            ],
            'failed' => [
                'label' => '<i class="fas fa-times-circle me-1"></i> Thất bại',
                'class' => 'badge bg-danger',
            ],
            'expired' => [
                'label' => '<i class="fas fa-clock me-1"></i> Hết hạn',
                'class' => 'badge bg-secondary',
            ],
            'canceled' => [
                'label' => '<i class="fas fa-ban me-1"></i> Đã hủy',
                'class' => 'badge bg-dark',
            ],
        ];

        $status = $labels[$this->status] ?? [
            'label' => '<i class="fas fa-question-circle me-1"></i> Không xác định',
            'class' => 'badge bg-light text-dark',
        ];

        return "<span class=\"{$status['class']} fs-7\">{$status['label']}</span>";
    }

    public function package()
    {
        return $this->belongsTo(ServicePackage::class, 'package_id');
    }

}
