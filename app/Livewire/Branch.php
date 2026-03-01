<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Branch as BranchModel;
use App\Models\DailyReport;
use App\Models\ReportDepartment;
use Illuminate\Support\Facades\Auth;
#[Layout('layouts.admin')]
class Branch extends Component
{
    public $showModal = false;

    public $name;
    public $location;
    public $manager;
    public $phone;
    public $totalBranchSale;
    public $totalBranchOwned;
    public $totalBranchRented;
    public $totalBranchNet;
    protected $rules = [
        'name' => 'required|string|max:255',
        'location' => 'nullable|string|max:255',
        'manager' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:255',
    ];
    public function mount()
    {
        $user = Auth::user();

        $branchIds = $user->role === 'admin'
            ? BranchModel::pluck('id')
            : collect([$user->branch_id]);

        $this->totalBranchSale = DailyReport::whereIn('branch_id', $branchIds)
            ->sum('total_after_tax');

        $this->totalBranchOwned = ReportDepartment::whereHas('dailyReport', function ($q) use ($branchIds) {
            $q->whereIn('branch_id', $branchIds);
        })
            ->whereHas('department', function ($q) {
                $q->where('type', 'owned');
            })
            ->sum('revenue');

        $this->totalBranchRented = ReportDepartment::whereHas('dailyReport', function ($q) use ($branchIds) {
            $q->whereIn('branch_id', $branchIds);
        })
            ->whereHas('department', function ($q) {
                $q->where('type', 'rented');
            })
            ->sum('revenue');

        $this->totalBranchNet = DailyReport::whereIn('branch_id', $branchIds)
            ->sum('net_sales');
    }
    public function openModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function resetFields()
    {
        $this->reset(['name', 'location', 'manager', 'phone']);
    }

    public function save()
    {
        $this->validate();

        BranchModel::create([
            'name' => $this->name,
            'location' => $this->location,
            'manager' => $this->manager,
            'phone' => $this->phone,
        ]);

        $this->closeModal();
        $this->resetFields();
        return redirect()->route('branch')->with('success', __('messages.banches.success_create'));
    }

    public function delete($id)
    {
        BranchModel::find($id)?->delete();
        return redirect()->route('branch')->with('success', __('messages.banches.success_delete'));
    }

    public function render()
    {
        return view('livewire.branch', [
            'branches' => BranchModel::with('dailyReports')->latest()->get(),
            'totalBranches' => BranchModel::count(),
        ]);
    }
}
