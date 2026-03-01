<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustodyDepartment extends Model
{
    protected $fillable = [
        'daily_report_id',
        'custody_id',
        'revenue',
    ];

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }

    public function custody()
    {
        return $this->belongsTo(Custody::class);
    }
}
