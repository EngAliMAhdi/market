<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $countBranches = \App\Models\Branch::count();
        $countDepartmentsOwned = \App\Models\Department::where('type', 'owned')->count();
        $countDepartmentsRented = \App\Models\Department::where('type', 'rented')->count();
        return view('pages.dashboard', compact('countBranches', 'countDepartmentsOwned', 'countDepartmentsRented'));
    }
}
