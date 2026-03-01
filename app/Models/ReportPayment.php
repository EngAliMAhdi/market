<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportPayment extends Model
{
    protected $fillable = [
        'daily_report_id',
        'payment_method_id',
        'amount',
    ];

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
