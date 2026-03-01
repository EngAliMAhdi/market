<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DailyReport;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportDepartment;
use Illuminate\Support\Facades\DB;
use App\Models\CustodyDepartment;
use App\Models\ReportPayment;

class Reports extends Component
{
    public $reportType = 'monthly';
    public $reportDate;
    public $reportMonth;
    public $reportYear;
    public $branch = 'all';

    public $branches = [];
    public $entries = [];

    public $totalSales = 0;
    public $totalOwned = 0;
    public $totalRented = 0;
    public $previousTotalSales = 0;
    public $showAnalysis = false;
    public $comparisonPeriod2;

    public $comparisonTotal1 = 0;
    public $comparisonOwned1 = 0;
    public $comparisonRented1 = 0;

    public $comparisonTotal2 = 0;
    public $viewReport = null;
    public $viewPayments = [];
    public $viewDepartments = [];
    public $viewCustodies = [];
    public $showViewModal = false;
    public function mount()
    {
        $this->branches = Branch::all();
        $this->reportMonth = now()->format('Y-m');
        $this->reportYear = now()->format('Y');
        $this->reportDate = now()->format('Y-m-d');
        $this->comparisonPeriod2 = Carbon::now()->subMonth()->format('Y-m');
        $query = DailyReport::query()->with('branch');

        $query->whereMonth('report_date', Carbon::parse($this->reportMonth)->month)
            ->whereYear('report_date', Carbon::parse($this->reportMonth)->year);
        $this->entries = $query->get();
        $this->calculateTotals();
        $this->dispatchChartData();
    }

    public function generateReport()
    {
        $query = DailyReport::query()->with('branch');

        // فلترة حسب الفرع
        if ($this->branch !== 'all') {
            $query->where('branch_id', $this->branch);
        }

        // فلترة حسب نوع التقرير
        if ($this->reportType === 'daily') {
            $query->whereDate('report_date', $this->reportDate);
        }

        if ($this->reportType === 'monthly') {
            $query->whereMonth('report_date', Carbon::parse($this->reportMonth)->month)
                ->whereYear('report_date', Carbon::parse($this->reportMonth)->year);
        }

        if ($this->reportType === 'yearly') {
            $query->whereYear('report_date', $this->reportYear);
        }
        if ($this->reportType === 'comparison') {

            $month1 = Carbon::parse($this->reportMonth);
            $month2 = Carbon::parse($this->comparisonPeriod2);

            $queryMonth1 = DailyReport::query();
            $queryMonth2 = DailyReport::query();

            if ($this->branch !== 'all') {
                $queryMonth1->where('branch_id', $this->branch);
                $queryMonth2->where('branch_id', $this->branch);
            }

            // ===== الشهر الأول =====
            $reportsMonth1 = $queryMonth1
                ->whereMonth('report_date', $month1->month)
                ->whereYear('report_date', $month1->year)
                ->get();

            // ===== الشهر الثاني =====
            $reportsMonth2 = $queryMonth2
                ->whereMonth('report_date', $month2->month)
                ->whereYear('report_date', $month2->year)
                ->get();

            // خزّن القيم
            $this->totalSales   = $reportsMonth1->sum('total_revenue');
            $this->totalOwned   = $reportsMonth1->sum('total_owned');
            $this->totalRented  = $reportsMonth1->sum('total_rented');

            $this->comparisonTotal1  = $reportsMonth2->sum('total_revenue');
            $this->comparisonOwned1  = $reportsMonth2->sum('total_owned');
            $this->comparisonRented1 = $reportsMonth2->sum('total_rented');

            // أرسل بيانات المخطط
            $this->dispatchComparisonCharts($reportsMonth1, $reportsMonth2);
            $this->entries = $query->get();

            return;
        }
        $this->entries = $query->get();

        $this->calculateTotals();
        $this->dispatchChartData();
    }

    private function dispatchChartData()
    {
        $chartData = $this->entries->map(function ($report) {
            return [
                'date' => $report->report_date,
                'branch' => $report->branch->name ?? '',
                'totals' => [
                    'grand' => $report->total_revenue,
                    'owned' => $report->total_owned,
                    'rented' => $report->total_rented,
                ]
            ];
        });

        $this->dispatch('updateCharts', data: $chartData);
    }


    private function dispatchComparisonCharts($month1Reports, $month2Reports)
    {
        $entries1 = $month1Reports->map(function ($r) {
            return [
                'date' => $r->report_date,
                'totals' => [
                    'grand' => $r->total_revenue,
                    'owned' => $r->total_owned,
                    'rented' => $r->total_rented,
                ]
            ];
        });

        $entries2 = $month2Reports->map(function ($r) {
            return [
                'date' => $r->report_date,
                'totals' => [
                    'grand' => $r->total_revenue,
                    'owned' => $r->total_owned,
                    'rented' => $r->total_rented,
                ]
            ];
        });

        $this->dispatch(
            'updateComparisonCharts',
            entries1: $entries1,
            entries2: $entries2,
            month1: Carbon::parse($this->reportMonth)->format('Y-m'),
            month2: Carbon::parse($this->comparisonPeriod2)->format('Y-m')
        );
    }
    private function calculateTotals()
    {
        $this->showAnalysis = false;
        $this->totalSales = $this->entries->sum('total_revenue');
        $this->totalOwned = $this->entries->sum('total_owned');
        $this->totalRented = $this->entries->sum('total_rented');
        $previousQuery = DailyReport::query();

        if ($this->branch !== 'all') {
            $previousQuery->where('branch_id', $this->branch);
        }

        if ($this->reportType === 'daily') {

            $previousDate = Carbon::parse($this->reportDate)->subDay();

            $previousQuery->whereDate('report_date', $previousDate);
        }

        if ($this->reportType === 'monthly') {

            $previousMonth = Carbon::parse($this->reportMonth)->subMonth();

            $previousQuery->whereMonth('report_date', $previousMonth->month)
                ->whereYear('report_date', $previousMonth->year);
        }

        if ($this->reportType === 'yearly') {

            $previousYear = Carbon::parse($this->reportYear . '-01-01')->subYear();

            $previousQuery->whereYear('report_date', $previousYear->year);
        }

        $this->previousTotalSales = $previousQuery->sum('total_after_tax');
        $this->showAnalysis = true;
    }
    public function resetAllReports()
    {
        if (Auth::user()->role !== 'admin') return;

        DailyReport::truncate();
        $this->entries = [];
        $this->totalSales = 0;
        $this->totalOwned = 0;
        $this->totalRented = 0;
        $this->previousTotalSales = 0;
        $this->showAnalysis = false;
        $this->comparisonTotal1 = 0;
        $this->comparisonOwned1 = 0;
        return redirect()->route('report')->with('success', __('messages.reports.success_delete'));
    }
    public function resetAllAmounts()
    {
        if (Auth::user()->role !== 'admin') return;

        DB::transaction(function () {

            DailyReport::query()->update([
                'total_before_tax' => 0,
                'tax' => 0,
                'total_after_tax' => 0,
                'net_sales' => 0,
            ]);

            ReportDepartment::query()->update([
                'revenue' => 0,
            ]);
            ReportPayment::query()->update([
                'amount' => 0,
            ]);
            CustodyDepartment::query()->update([
                'revenue' => 0,
            ]);
        });

        return redirect()->route('report')->with('success', __('messages.reports.success_reset_amounts'));
    }

    public function resetAllData()
    {
        if (Auth::user()->role !== 'admin') return;

        DB::transaction(function () {

            // حذف كل التقارير
            ReportDepartment::truncate();
            CustodyDepartment::truncate();
            ReportPayment::truncate();
            DailyReport::truncate();
            // إنشاء تقارير اليوم لكل الفروع
            $today = now()->toDateString();
            $branches = Branch::all();

            foreach ($branches as $branch) {

                DailyReport::create([
                    'branch_id' => $branch->id,
                    'report_date' => $today,
                    'total_before_tax' => 0,
                    'tax' => 0,
                    'total_after_tax' => 0,
                    'net_sales' => 0,
                ]);
            }
        });

        return redirect()->route('report')->with('success', __('messages.reports.success_reset_all'));
    }
    public function showReport($id)
    {
        $this->viewReport = DailyReport::with([
            'branch',
            'payments.paymentMethod',
            'departments.department',
            'custodyDepartments.custody'
        ])->findOrFail($id);

        $this->viewPayments = $this->viewReport->payments;
        $this->viewDepartments = $this->viewReport->departments;
        $this->viewCustodies = $this->viewReport->custodyDepartments;

        $this->showViewModal = true;
    }
    public function render()
    {
        return view('livewire.reports');
    }
}
