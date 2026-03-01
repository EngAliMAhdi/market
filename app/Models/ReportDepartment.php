<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportDepartment extends Model
{
    protected $fillable = [
        'daily_report_id',
        'department_id',
        'revenue',
    ];

    public function dailyReport()
    {
        return $this->belongsTo(DailyReport::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
