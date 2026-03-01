<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Branch;
use App\Models\Department;
use App\Models\PaymentMethod;
use App\Models\Custody;
use App\Models\DailyReport;
use App\Models\ReportPayment;
use App\Models\ReportDepartment;
use App\Models\CustodyDepartment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class Sale extends Component
{
    public $branches;
    public $departments;
    public $paymentMethods;
    public $custodys;

    public $activeModal = null;

    public $newName = '';
    public $newDeptType = 'owned';

    public $branch_id;
    public $report_date;
    public $total_before_tax = 0;
    public $tax = 0;
    public $total_after_tax = 0;
    public $net_sales = 0;

    public $payments = [];
    public $departmentRevenues = [];
    public $custodyRevenues = [];

    public function mount()
    {
        $this->branches = Branch::all();
        $this->departments = Department::all();
        $this->paymentMethods = PaymentMethod::all();
        $this->custodys = Custody::all();
        $this->report_date = now()->toDateString();
        if (Auth::user()->role !== 'admin') {
            $this->branch_id = Auth::user()->branch_id;
        }
    }
    public function render()
    {
        $branches = Branch::all();
        $departments = Department::all();
        $paymentMethods = PaymentMethod::all();
        $custodys = Custody::all();

        return view('livewire.sale', compact('branches', 'departments', 'paymentMethods', 'custodys'));
    }

    public function openModal($type)
    {
        $this->resetFields();
        $this->activeModal = $type;
    }

    public function closeModal()
    {
        $this->activeModal = null;
    }

    public function resetFields()
    {
        $this->newName = '';
        $this->newDeptType = 'owned';
    }

    public function savePaymentMethod()
    {
        PaymentMethod::create(['name' => $this->newName]);
        $this->closeModal();
    }

    public function saveDepartment()
    {
        Department::create([
            'name' => $this->newName,
            'type' => $this->newDeptType,
        ]);
        $this->closeModal();
    }

    public function saveCustody()
    {
        Custody::create(['name' => $this->newName]);
        $this->closeModal();
    }

    public function saveReport()
    {
        DB::transaction(function () {
            $report = DailyReport::updateOrCreate(
                [
                    'branch_id' => $this->branch_id,
                    'report_date' => $this->report_date,
                ],
                [
                    'total_before_tax' => $this->total_before_tax,
                    'tax' => $this->tax,
                    'total_after_tax' => $this->total_after_tax,
                    'net_sales' => $this->net_sales,
                ]
            );
            // Payments
            foreach ($this->payments as $methodId => $amount) {
                if ($amount > 0) {
                    ReportPayment::create([
                        'daily_report_id' => $report->id,
                        'payment_method_id' => $methodId,
                        'amount' => $amount,
                    ]);
                }
            }

            // Departments
            foreach ($this->departmentRevenues as $departmentId => $amount) {
                if ($amount > 0) {
                    ReportDepartment::create([
                        'daily_report_id' => $report->id,
                        'department_id' => $departmentId,
                        'revenue' => $amount,
                    ]);
                }
            }

            // Custody
            foreach ($this->custodyRevenues as $custodyId => $amount) {
                if ($amount > 0) {
                    CustodyDepartment::create([
                        'daily_report_id' => $report->id,
                        'custody_id' => $custodyId,
                        'revenue' => $amount,
                    ]);
                }
            }
        });

        session()->flash('success', __('messages.reports.success_create'));
        return redirect()->route('sale');
    }
}
