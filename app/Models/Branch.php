<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'location',
        'manager',
        'phone',
    ];

    // علاقة الفرع مع المستخدمين
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function dailyReports()
    {
        return $this->hasMany(DailyReport::class);
    }

    public function totalOwnedSales()
    {
        return ReportDepartment::whereHas('dailyReport', function ($q) {
            $q->where('branch_id', $this->id);
        })
            ->whereHas('department', function ($q) {
                $q->where('type', 'owned');
            })
            ->sum('revenue');
    }

    public function totalRentedSales()
    {
        return ReportDepartment::whereHas('dailyReport', function ($q) {
            $q->where('branch_id', $this->id);
        })
            ->whereHas('department', function ($q) {
                $q->where('type', 'rented');
            })
            ->sum('revenue');
    }

    public function totalNetSales()
    {
        return $this->dailyReports()->sum('net_sales');
    }

    public function totalSales()
    {
        return $this->dailyReports()->sum('total_after_tax');
    }
}
