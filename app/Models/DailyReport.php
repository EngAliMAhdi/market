<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $fillable = [
        'branch_id',
        'report_date',
        'total_before_tax',
        'tax',
        'total_after_tax',
        'net_sales',
    ];
    protected $appends = [
        'total_owned',
        'total_rented',
        'total_revenue',
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function payments()
    {
        return $this->hasMany(ReportPayment::class);
    }

    public function departments()
    {
        return $this->hasMany(ReportDepartment::class);
    }

    public function custodyDepartments()
    {
        return $this->hasMany(CustodyDepartment::class);
    }

    public function getTotalOwnedAttribute()
    {
        return $this->departments()
            ->whereHas('department', function ($q) {
                $q->where('type', 'owned');
            })
            ->sum('revenue');
    }

    public function getTotalRentedAttribute()
    {
        return $this->departments()
            ->whereHas('department', function ($q) {
                $q->where('type', 'rented');
            })
            ->sum('revenue');
    }

    public function getTotalRevenueAttribute()
    {
        return $this->departments()->sum('revenue');
    }
}
