<div class="container px-4 py-6 mx-auto md:px-6 md:py-8">
<div class="container px-4 py-6 mx-auto md:px-6 md:py-8">

    {{-- Header --}}
    <div class="flex flex-col items-start justify-between gap-4 mb-6 md:flex-row md:items-center">
        <h2 class="text-3xl font-bold text-gray-800">
           {{ __('reports.title') }}
        </h2>
<div class="flex flex-wrap gap-2">
    <button onclick="downloadExcel()"
        class="flex items-center gap-2 px-6 py-2 font-bold text-white rounded-lg gradient-green hover:opacity-90">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
        </svg>
        <span data-translate="exportExcel">{{ __('reports.export_excel') }}</span>
    </button>
    <button onclick="downloadPDF()"
        class="flex items-center gap-2 px-6 py-2 font-bold text-white rounded-lg gradient-bg hover:opacity-90">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
        </svg>
        <span data-translate="exportPDF">{{ __('reports.export_pdf') }}</span>
    </button>
</div>

    </div>

    {{-- Filters --}}
<div class="p-6 mb-4 bg-white border border-gray-200 shadow-sm rounded-xl">
                    <div class="grid items-end grid-cols-1 gap-4 md:grid-cols-5">

            {{-- Report Type --}}
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">
                   {{ __('reports.report_type') }}
                </label>
                <select wire:model.live="reportType" class="w-full p-2 border border-gray-300 rounded-lg">
                    <option value="daily">{{ __('reports.daily') }}</option>
                    <option value="monthly">{{ __('reports.monthly') }}</option>
                    <option value="yearly">{{ __('reports.yearly') }}</option>
                    <option value="comparison">{{ __('reports.comparison') }}</option>
                </select>
            </div>

            {{-- Date --}}
            @if($reportType === 'daily')
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">
                   {{ __('reports.date') }}
                </label>
                <input type="date" wire:model="reportDate" class="w-full p-2 border border-gray-300 rounded-lg">
            </div>
            @endif

            {{-- Month --}}
            @if($reportType === 'monthly')
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">
                   {{ __('reports.month') }}
                </label>
                <input type="month" wire:model="reportMonth" class="w-full p-2 border border-gray-300 rounded-lg">
            </div>
            @endif

            {{-- Year --}}
            @if($reportType === 'yearly')
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">
                     {{ __('reports.year') }}
                </label>
                <input type="number" wire:model="reportYear" class="w-full p-2 border border-gray-300 rounded-lg"
                    placeholder="2026">
            </div>
            @endif
            {{-- Comparison Periods --}}
            @if($reportType === 'comparison')
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">
                    {{ __('reports.date') }}
                </label>
                <input type="month" wire:model="reportMonth" class="w-full p-2 border border-gray-300 rounded-lg"> <br>
                <input type="month" wire:model="comparisonPeriod2" class="w-full p-2 border border-gray-300 rounded-lg mt-2">
            </div>
            @endif
            {{-- Branch --}}
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">
                   {{ __('reports.branch') }}
                </label>
                <select wire:model.live="branch" class="w-full p-2 border border-gray-300 rounded-lg">
                    <option value="all">{{ __('reports.all_branches') }}</option>
                    @foreach($branches as $branchItem)
                    <option value="{{ $branchItem->id }}">
                        {{ $branchItem->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
<button wire:click="generateReport"
    class="flex items-center justify-center w-full gap-2 px-6 py-3 font-bold text-white transition rounded-lg shadow-lg gradient-blue hover:opacity-90">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <span data-translate="viewReport">{{ __('reports.view_report') }}</span>
</button>
            </div>
        </div>
    </div>

    @if ($showAnalysis && $reportType !== 'comparison')
    <div id="trend-analysis-section mb-4">
        <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">
            <div class="p-6 text-white  bg-blue-600 ">
                <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                    <div>
                        <h3 class="text-xl font-bold">{{ __('reports.trend_analysis') }}</h3>
                        <p class="mt-1 text-blue-100" id="trend-period-label">{{ __('reports.compare_previous') }}</p>
                    </div>
                    <span class="px-4 py-2 text-sm font-bold rounded-full bg-white/20" id="trend-status-badge"></span>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
                    <div class="p-4 border border-blue-100 rounded-lg bg-blue-50">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-blue-700">{{ __('reports.current_sales') }}</span>
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>

                        <p class="text-2xl font-bold text-blue-600" id="current-sales">

                            {{ number_format($totalSales, 2) }}


                    </p>
                    </div>
                    <div class="p-4 border border-green-100 rounded-lg bg-green-50">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-green-700">{{ __('reports.current_owned') }}</span>
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-green-600" id="current-owned">{{ number_format($totalOwned, 2) }}</p>
                    </div>
                    <div class="p-4 border border-orange-100 rounded-lg bg-orange-50">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-orange-700">{{ __('reports.current_rented') }}</span>
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-orange-600" id="current-rented">{{ number_format($totalRented, 2) }}</p>
                    </div>
                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">{{ __('reports.previous_sales') }}</span>
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-2xl font-bold text-gray-600" id="previous-sales">{{ number_format($previousTotalSales, 2) }}</p>
                    </div>
                </div>

                <!-- التحليل التفصيلي -->
                <div class="p-6 border border-gray-200 bg-gradient-to-r from-gray-50 to-white rounded-xl">
                    <h4 class="mb-4 text-lg font-bold text-gray-800">{{ __('reports.trend_analysis') }}</h4>
                    <div id="trend-analysis-content" class="space-y-4"></div>
                </div>
            </div>
        </div>
    </div>

    @endif

    <div id="report-content" class="space-y-6 mt-4">
        <!-- Charts Section -->

        @if ($reportType === 'comparison')
           <div id="comparison-section" class="">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <h3 class="mb-4 text-lg font-bold text-gray-800">{{ __('reports.sales_comparison') }}</h3>
                        <div class="h-64">
                            <canvas id="comparisonBarChart"></canvas>
                        </div>
                    </div>
                    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <h3 class="mb-4 text-lg font-bold text-gray-800">{{ __('reports.sales_distribution') }}</h3>
                        <div class="h-64">
                            <canvas id="comparisonPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($reportType != 'daily')
        <div id="charts-section" class="grid  grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">{{ __('reports.monthly_sales_trend') }}</h3>
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="salesLineChart"></canvas>
                        </div>
                    </div>
                    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">{{ __('reports.sales_by_branch') }}</h3>
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="branchBarChart"></canvas>
                        </div>
                    </div>
                    <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800">{{ __('reports.owned_vs_rented') }}</h3>
                            <div class="p-2 bg-orange-100 rounded-lg">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="categoryPieChart"></canvas>
                        </div>
                    </div>
                </div>
        @endif


    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3 mt-5">

        <div class="stat-card gradient-blue">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-white text-opacity-90">
                        {{ __('reports.total_sales') }}
                    </p>
                    <p class="text-white text-2xl font-bold">
                      {{ number_format($totalSales, 2) }}
                    @if ($reportType=='comparison')
                    → {{ number_format($comparisonTotal1, 2) }}


                    @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="stat-card gradient-green">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-white text-opacity-90">
                        {{ __('reports.total_owned') }}
                    </p>
                    <p class="text-white text-2xl font-bold">
                        {{ number_format($totalOwned, 2) }}
                    @if ($reportType=='comparison')
                    → {{ number_format($comparisonOwned1, 2) }}
                    @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="stat-card gradient-orange">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-white text-opacity-90">
                        {{ __('reports.total_rented') }}
                    </p>
                    <p class="text-white text-2xl font-bold">
                        {{ number_format($totalRented, 2) }}
                    @if ($reportType=='comparison')
                    → {{ number_format($comparisonRented1, 2) }}
                    @endif
                    </p>
                </div>
            </div>
        </div>

    </div>
    </div>
    {{-- Detailed Table --}}
    <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-xl">

        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <h3 class="text-xl font-bold text-gray-800">
                {{ __('reports.detailed_sales') }}
        </div>

        <div class="overflow-x-auto" >
            <div id="report-table-wrapper">
            <table class="w-full">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-right text-gray-600">{{ __('reports.branch') }}</th>
                        <th class="px-6 py-3 text-right text-gray-600">{{ __('reports.date') }}</th>
                        <th class="px-6 py-3 text-right text-gray-600">{{ __('reports.owned') }}</th>
                        <th class="px-6 py-3 text-right text-gray-600">{{ __('reports.rented') }}</th>
                        <th class="px-6 py-3 text-right text-gray-600">{{ __('reports.total') }}</th>
                        <th class="px-6 py-3 text-right text-gray-600">{{ __('reports.actions') }}</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">

                    @forelse($entries as $entry)
                    <tr>
                        <td class="px-6 py-4">
                            {{ $entry->branch->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $entry->report_date }}
                        </td>
                        <td class="px-6 py-4 text-green-600 font-medium">
                            {{ number_format($entry->total_owned, 2) }}
                        </td>
                        <td class="px-6 py-4 text-orange-600 font-medium">
                            {{ number_format($entry->total_rented, 2) }}
                        </td>
                        <td class="px-6 py-4 text-blue-600 font-bold">
                            {{ number_format($entry->total_revenue, 2) }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="showReport({{ $entry->id }})"
                                class="px-4 py-2 text-sm font-bold text-white transition bg-blue-600 rounded-lg hover:opacity-90">
                              <i class="ri-eye-line"></i> {{ __('reports.view') }}
                            </button>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                            {{ __('reports.no_data') }}
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
            </div>
        </div>
    </div>

    {{-- Admin Controls --}}
    @if(auth()->user()->role === 'admin')
    <div class="p-6 mt-8 bg-white border border-red-200 shadow-sm rounded-xl">



        <div id="admin-controls" class=" p-8 bg-white border border-red-200 shadow-sm rounded-xl">
            <div class="flex items-center mb-6">
                <svg class="w-8 h-8 ml-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.928-.833-2.698 0L4.354 16.5c-.77.833.192 2.5 1.732 2.5z">
                    </path>
                </svg>
                <h3 class="text-xl font-bold text-red-800">{{ __('reports.admin_controls') }}</h3>
            </div>
            <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
                <button wire:click="resetAllAmounts" wire:confirm="{{ __('messages.reports.reset_message') }}"
                    class="flex flex-col items-center justify-center px-6 py-8 font-bold text-white transition transform shadow-lg bg-yellow-500  rounded-xl hover:opacity-90 hover:-translate-y-1">
                    <svg class="w-10 h-10 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    <span>{{ __('reports.reset_amounts') }}</span>
                    <span class="mt-2 text-sm opacity-90">{{ __('reports.reset_only_numbers') }}</span>
                </button>
                <button wire:click="resetAllReports" wire:confirm="{{ __('messages.reports.delete_message') }}"
                    class="flex flex-col items-center justify-center px-6 py-8 font-bold text-white transition transform shadow-lg bg-red-500  rounded-xl hover:opacity-90 hover:-translate-y-1">
                    <svg class="w-10 h-10 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                    <span>{{ __('reports.delete_reports') }}</span>
                    <span class="mt-2 text-sm opacity-90">{{ __('reports.delete_sales_records') }}</span>
                </button>
                <button wire:click="resetAllData" wire:confirm="{{ __('messages.reports.reset_all_message') }}"
                    class="flex flex-col items-center justify-center px-6 py-8 font-bold text-white transition transform shadow-lg bg-purple-500  rounded-xl hover:opacity-90 hover:-translate-y-1">
                    <svg class="w-10 h-10 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    <span>{{ __('reports.fresh_start') }}</span>
                    <span class="mt-2 text-sm opacity-90">{{ __('reports.full_reset') }}</span>
                </button>
            </div>
            <div class="p-5 border border-red-200 bg-red-50 rounded-xl">
                <div class="flex items-start">
                    <svg class="w-6 h-6 mt-1 ml-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.928-.833-2.698 0L4.354 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                    <div>
                        <p class="text-sm font-bold text-red-600">{{ __('reports.important_warning') }}</p>
                        <p class="text-sm text-red-600">{{ __('reports.warning_text') }}</p>
                    </div>
                </div>
            </div>
        </div>
@if($showViewModal)
<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

    <div class="w-full max-w-4xl p-6 bg-white rounded-xl shadow-xl">

        <!-- Header -->
        <div class="flex items-center justify-between pb-4 mb-6 border-b">
            <h2 class="text-xl font-bold">{{ __('reports.report_details') }}</h2>
            <button wire:click="$set('showViewModal', false)" class="text-red-500 text-xl">×</button>
        </div>

        <!-- Basic Info -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <strong>{{ __('reports.branch') }}:</strong>
                {{ $viewReport->branch->name }}
            </div>
            <div>
                <strong>{{ __('reports.date') }}:</strong>
                {{ $viewReport->report_date }}
            </div>
            <div>
                <strong>{{ __('reports.before_tax') }}:</strong>
                {{ number_format($viewReport->total_before_tax,2) }}
            </div>
            <div>
                <strong>{{ __('reports.tax') }}:</strong>
                {{ number_format($viewReport->tax,2) }}
            </div>
            <div>
                <strong>{{ __('reports.after_tax') }}:</strong>
                {{ number_format($viewReport->total_after_tax,2) }}
            </div>
            <div>
                <strong>{{ __('reports.net_sales') }}:</strong>
                {{ number_format($viewReport->net_sales,2) }}
            </div>
        </div>

        <!-- Payments -->
        <div class="mb-6">
            <h3 class="mb-3 font-bold text-blue-600">{{ __('reports.payment_methods') }}</h3>
            @foreach($viewPayments as $payment)
            <div class="flex justify-between p-2 border-b">
                <span>{{ $payment->paymentMethod->name }}</span>
                <span>{{ number_format($payment->amount,2) }}</span>
            </div>
            @endforeach
        </div>

        <!-- Departments -->
        <div class="mb-6">
            <h3 class="mb-3 font-bold text-green-600">{{ __('reports.departments') }}</h3>
            @foreach($viewDepartments as $dept)
            <div class="flex justify-between p-2 border-b">
                <span>{{ $dept->department->name }}</span>
                <span>{{ number_format($dept->revenue,2) }}</span>
            </div>
            @endforeach
        </div>

        <!-- Custody -->
        <div>
            <h3 class="mb-3 font-bold text-purple-600">{{ __('reports.custody') }}</h3>
            @foreach($viewCustodies as $custody)
            <div class="flex justify-between p-2 border-b">
                <span>{{ $custody->custody->name }}</span>
                <span>{{ number_format($custody->revenue,2) }}</span>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endif
    </div>
    @endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:init', () => {

        Livewire.on('updateCharts', (event) => {
            renderCharts(event.data);
        });
Livewire.on('updateComparisonCharts', (event) => {
renderComparisonCharts(
event.entries1,
event.entries2,
event.month1,
event.month2
);
});
    });
</script>

<script>


   let charts = {};

    function renderCharts(entries) {
    document.getElementById('charts-section').classList.remove('hidden');

    // تنسيق ألوان متناسقة للرسوم البيانية
    const chartColors = {
    primary: '#3b82f6',
    success: '#10b981',
    warning: '#f59e0b',
    danger: '#ef4444',
    info: '#6366f1',
    lightBlue: '#93c5fd',
    lightGreen: '#86efac',
    lightOrange: '#fde68a'
    };

    // 1. Sales Trend (Line Chart)
    const ctxLine = document.getElementById('salesLineChart').getContext('2d');
    if (charts.line) charts.line.destroy();

    const salesByDate = {};
    entries.forEach(e => {
    const d = new Date(e.date);
    const key = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}`;
    if (!salesByDate[key]) salesByDate[key] = 0;
    salesByDate[key] += (e.totals ? e.totals.grand : 0);
    });
    const labelsLine = Object.keys(salesByDate).sort();
    const dataLine = labelsLine.map(k => salesByDate[k]);

    charts.line = new Chart(ctxLine, {
    type: 'line',
    data: {
    labels: labelsLine,
    datasets: [{
    label: 'المبيعات',
    data: dataLine,
    borderColor: chartColors.primary,
    backgroundColor: 'rgba(59, 130, 246, 0.1)',
    borderWidth: 3,
    fill: true,
    tension: 0.4,
    pointBackgroundColor: chartColors.primary,
    pointBorderColor: '#ffffff',
    pointBorderWidth: 2,
    pointRadius: 6,
    pointHoverRadius: 8
    }]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
    legend: {
    display: true,
    position: 'top',
    labels: {
    font: {
    family: 'Cairo',
    size: 12
    },
    color: '#4b5563'
    }
    }
    },
    scales: {
    y: {
    beginAtZero: true,
    grid: {
    color: 'rgba(0, 0, 0, 0.05)'
    },
    ticks: {
    font: {
    family: 'Cairo',
    size: 11
    },
    color: '#6b7280'
    }
    },
    x: {
    grid: {
    color: 'rgba(0, 0, 0, 0.05)'
    },
    ticks: {
    font: {
    family: 'Cairo',
    size: 11
    },
    color: '#6b7280'
    }
    }
    }
    }
    });

    // 2. Sales per Branch (Bar Chart)
    const ctxBar = document.getElementById('branchBarChart').getContext('2d');
    if (charts.bar) charts.bar.destroy();

    const salesByBranch = {};
    entries.forEach(e => {
    if (!salesByBranch[e.branch]) salesByBranch[e.branch] = 0;
    salesByBranch[e.branch] += (e.totals ? e.totals.grand : 0);
    });
    const labelsBar = Object.keys(salesByBranch);
    const dataBar = labelsBar.map(k => salesByBranch[k]);

    charts.bar = new Chart(ctxBar, {
    type: 'bar',
    data: {
    labels: labelsBar,
    datasets: [{
    label: 'المبيعات',
    data: dataBar,
    backgroundColor: [
    chartColors.primary,
    chartColors.success,
    chartColors.warning,
    chartColors.info,
    chartColors.danger,
    chartColors.lightBlue,
    chartColors.lightGreen,
    chartColors.lightOrange
    ],
    borderColor: '#ffffff',
    borderWidth: 1,
    borderRadius: 8,
    borderSkipped: false
    }]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
    legend: {
    display: true,
    position: 'top',
    labels: {
    font: {
    family: 'Cairo',
    size: 12
    },
    color: '#4b5563'
    }
    }
    },
    scales: {
    y: {
    beginAtZero: true,
    grid: {
    color: 'rgba(0, 0, 0, 0.05)'
    },
    ticks: {
    font: {
    family: 'Cairo',
    size: 11
    },
    color: '#6b7280',
    callback: function(value) {
    return value.toLocaleString('ar-EG') + ' ر.س';
    }
    }
    },
    x: {
    grid: {
    display: false
    },
    ticks: {
    font: {
    family: 'Cairo',
    size: 11
    },
    color: '#6b7280'
    }
    }
    }
    }
    });

    // 3. Owned vs Rented (Doughnut)
    const ctxPie = document.getElementById('categoryPieChart').getContext('2d');
    if (charts.pie) charts.pie.destroy();

    const totalOwned = entries.reduce((sum, e) => sum + (e.totals ? e.totals.owned : 0), 0);
    const totalRented = entries.reduce((sum, e) => sum + (e.totals ? e.totals.rented : 0), 0);

    charts.pie = new Chart(ctxPie, {
    type: 'doughnut',
    data: {
    labels: ['المملوك', 'المؤجر'],
    datasets: [{
    data: [totalOwned, totalRented],
    backgroundColor: [chartColors.success, chartColors.warning],
    borderColor: '#ffffff',
    borderWidth: 2,
    hoverOffset: 15
    }]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '70%',
    plugins: {
    legend: {
    position: 'bottom',
    labels: {
    font: {
    family: 'Cairo',
    size: 12
    },
    color: '#4b5563',
    padding: 20
    }
    },
    tooltip: {
    callbacks: {
    label: function(context) {
    const label = context.label || '';
    const value = context.raw || 0;
    const total = context.dataset.data.reduce((a, b) => a + b, 0);
    const percentage = Math.round((value / total) * 100);
    return `${label}: ${value.toLocaleString('ar-EG')} ر.س (${percentage}%)`;
    }
    }
    }
    }
    }
    });
    }

    function renderComparisonCharts(entries1, entries2, month1, month2) {
    document.getElementById('comparison-section').classList.remove('hidden');

    const total1 = entries1.reduce((sum, e) => sum + (e.totals ? e.totals.grand : 0), 0);
    const total2 = entries2.reduce((sum, e) => sum + (e.totals ? e.totals.grand : 0), 0);
    const owned1 = entries1.reduce((sum, e) => sum + (e.totals ? e.totals.owned : 0), 0);
    const owned2 = entries2.reduce((sum, e) => sum + (e.totals ? e.totals.owned : 0), 0);
    const rented1 = entries1.reduce((sum, e) => sum + (e.totals ? e.totals.rented : 0), 0);
    const rented2 = entries2.reduce((sum, e) => sum + (e.totals ? e.totals.rented : 0), 0);

    // Comparison Bar Chart
    const ctxBar = document.getElementById('comparisonBarChart').getContext('2d');
    if (charts.comparisonBar) charts.comparisonBar.destroy();

    charts.comparisonBar = new Chart(ctxBar, {
    type: 'bar',
    data: {
    labels: ['المبيعات الكلية', 'المملوك', 'المؤجر'],
    datasets: [
    {
    label: month1,
    data: [total1, owned1, rented1],
    backgroundColor: '#3b82f6',
    borderRadius: 6
    },
    {
    label: month2,
    data: [total2, owned2, rented2],
    backgroundColor: '#10b981',
    borderRadius: 6
    }
    ]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
    y: {
    beginAtZero: true,
    grid: {
    color: 'rgba(0, 0, 0, 0.05)'
    },
    ticks: {
    font: {
    family: 'Cairo',
    size: 11
    },
    color: '#6b7280'
    }
    },
    x: {
    grid: {
    display: false
    },
    ticks: {
    font: {
    family: 'Cairo',
    size: 11
    },
    color: '#6b7280'
    }
    }
    },
    plugins: {
    legend: {
    position: 'top',
    labels: {
    font: {
    family: 'Cairo',
    size: 12
    },
    color: '#4b5563'
    }
    }
    }
    }
    });

    // Comparison Pie Chart
    const ctxPie = document.getElementById('comparisonPieChart').getContext('2d');
    if (charts.comparisonPie) charts.comparisonPie.destroy();

    charts.comparisonPie = new Chart(ctxPie, {
    type: 'pie',
    data: {
    labels: [month1, month2],
    datasets: [{
    data: [total1, total2],
    backgroundColor: ['#3b82f6', '#10b981'],
    borderColor: '#ffffff',
    borderWidth: 2
    }]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
    legend: {
    position: 'bottom',
    labels: {
    font: {
    family: 'Cairo',
    size: 12
    },
    color: '#4b5563',
    padding: 20
    }
    }
    }
    }
    });
    }

    function downloadExcel() {

    let table = document.querySelector('#report-table-wrapper table');
    if (!table) return;

    let csv = [];
    csv.push('\uFEFF'); // دعم اللغة العربية

    // ===== العنوان =====
    csv.push(`"تقرير المبيعات"`);
    csv.push(`"تاريخ التصدير: ${new Date().toLocaleDateString('ar-EG')}"`);
    csv.push("");

    // ===== رؤوس الأعمدة =====
    let headerRow = [];
    table.querySelectorAll('thead th').forEach(th => {
    headerRow.push(`"${th.innerText.trim()}"`);
    });
    csv.push(headerRow.join(","));

    // ===== البيانات =====
    table.querySelectorAll('tbody tr').forEach(tr => {
    let row = [];
    tr.querySelectorAll('td').forEach((td, index) => {

    // تجاهل عمود الإجراءات
    if (index === 5) return;

    row.push(`"${td.innerText.trim()}"`);
    });
    csv.push(row.join(","));
    });

    // ===== إنشاء الملف =====
    const blob = new Blob([csv.join("\n")], { type: "text/csv;charset=utf-8;" });
    const url = window.URL.createObjectURL(blob);

    const a = document.createElement("a");
    a.href = url;
    a.download = `sales-report-${new Date().toISOString().split('T')[0]}.csv`;

    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);

    window.URL.revokeObjectURL(url);
    }

function downloadPDF() {

const element = document.getElementById('report-table-wrapper');

const opt = {
margin: 0.5,
filename: `report-${new Date().toISOString().split('T')[0]}.pdf`,
image: { type: 'jpeg', quality: 0.98 },
html2canvas: {
scale: 2,
useCORS: true
},
jsPDF: {
unit: 'in',
format: 'a4',
orientation: 'portrait'
}
};

html2pdf().set(opt).from(element).save();
}
    // ==================== TREND ANALYSIS ====================
    function renderTrendAnalysis(entries, reportType, currentPeriod) {
    const trendSection = document.getElementById('trend-analysis-section');
    const analysisContent = document.getElementById('trend-analysis-content');

    if (entries.length === 0) {
    trendSection.classList.add('hidden');
    return;
    }

    trendSection.classList.remove('hidden');

    // Calculate current period totals
    const currentTotal = entries.reduce((sum, e) => sum + (e.totals ? e.totals.grand : 0), 0);
    const currentOwned = entries.reduce((sum, e) => sum + (e.totals ? e.totals.owned : 0), 0);
    const currentRented = entries.reduce((sum, e) => sum + (e.totals ? e.totals.rented : 0), 0);

    // Calculate previous period
    let previousEntries = [];
    const currentDate = new Date(currentPeriod);

    if (reportType === 'monthly') {
    const previousDate = new Date(currentDate);
    previousDate.setMonth(previousDate.getMonth() - 1);
    const previousMonth = previousDate.toISOString().slice(0, 7);

    previousEntries = dailyEntries.filter(e => {
    if (document.getElementById('report-branch').value !== 'all' && e.branch !==
    document.getElementById('report-branch').value) return false;
    const entryDate = new Date(e.date);
    return entryDate.getFullYear() === previousDate.getFullYear() &&
    entryDate.getMonth() === previousDate.getMonth();
    });
    }

    const previousTotal = previousEntries.reduce((sum, e) => sum + (e.totals ? e.totals.grand : 0), 0);
    const previousOwned = previousEntries.reduce((sum, e) => sum + (e.totals ? e.totals.owned : 0), 0);
    const previousRented = previousEntries.reduce((sum, e) => sum + (e.totals ? e.totals.rented : 0), 0);

    // Update UI
    document.getElementById('current-sales').textContent = currentTotal.toLocaleString('ar-EG', { minimumFractionDigits: 2
    });
    document.getElementById('current-owned').textContent = currentOwned.toLocaleString('ar-EG', { minimumFractionDigits: 2
    });
    document.getElementById('current-rented').textContent = currentRented.toLocaleString('ar-EG', { minimumFractionDigits: 2
    });

    document.getElementById('previous-sales').textContent = previousTotal.toLocaleString('ar-EG', { minimumFractionDigits: 2
    });
    document.getElementById('previous-owned').textContent = previousOwned.toLocaleString('ar-EG', { minimumFractionDigits: 2
    });
    document.getElementById('previous-rented').textContent = previousRented.toLocaleString('ar-EG', { minimumFractionDigits:
    2 });

    // Analysis and recommendations
    let analysisHTML = '';
    let statusBadge = '';

    if (previousTotal > 0 && currentTotal > 0) {
    const growthRate = ((currentTotal - previousTotal) / previousTotal) * 100;
    const ownedGrowth = ((currentOwned - previousOwned) / previousOwned) * 100;
    const rentedGrowth = ((currentRented - previousRented) / previousRented) * 100;

    if (growthRate > 0) {
    statusBadge = `<span class="px-3 py-1 text-sm font-bold text-green-800 bg-green-100 rounded-full">▲
        +${growthRate.toFixed(1)}%</span>`;
    analysisHTML += `
    <div class="flex items-center p-4 border border-green-200 rounded-lg bg-green-50">
        <svg class="w-6 h-6 ml-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
        </svg>
        <div>
            <p class="font-bold text-green-800">ارتفاع في المبيعات</p>
            <p class="text-sm text-green-600">نمو بنسبة ${growthRate.toFixed(1)}% مقارنة بالفترة السابقة</p>
        </div>
    </div>
    `;
    } else {
    statusBadge = `<span class="px-3 py-1 text-sm font-bold text-red-800 bg-red-100 rounded-full">▼
        ${growthRate.toFixed(1)}%</span>`;
    analysisHTML += `
    <div class="flex items-center p-4 border border-red-200 rounded-lg bg-red-50 animate-pulse-slow">
        <svg class="w-6 h-6 ml-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6">
            </path>
        </svg>
        <div>
            <p class="font-bold text-red-800">انخفاض في المبيعات</p>
            <p class="text-sm text-red-600">انخفاض بنسبة ${Math.abs(growthRate).toFixed(1)}% مقارنة بالفترة السابقة</p>
        </div>
    </div>
    <div class="p-4 mt-4 border border-red-200 rounded-lg bg-red-50">
        <p class="mb-2 text-sm font-bold text-red-700">توصية:</p>
        <p class="text-sm text-red-600">يرجى مراجعة وتحديث نواقص الرفوف فوراً وتحليل أسباب الانخفاض</p>
    </div>
    `;
    }

    // إضافة تحليل للمملوك والمؤجر
    analysisHTML += `
    <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-2">
        <div
            class="${ownedGrowth >= 0 ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200'} p-4 rounded-lg border">
            <div class="flex items-center justify-between">
                <span class="font-medium ${ownedGrowth >= 0 ? 'text-green-700' : 'text-red-700'}">المملوك</span>
                <span class="${ownedGrowth >= 0 ? 'text-green-600' : 'text-red-600'} font-bold">${ownedGrowth >= 0 ? '+' :
                    ''}${ownedGrowth.toFixed(1)}%</span>
            </div>
            <p class="text-sm ${ownedGrowth >= 0 ? 'text-green-600' : 'text-red-600'} mt-1">${ownedGrowth >= 0 ? 'نمو' :
                'انخفاض'} في المبيعات المملوكة</p>
        </div>
        <div
            class="${rentedGrowth >= 0 ? 'bg-orange-50 border-orange-200' : 'bg-red-50 border-red-200'} p-4 rounded-lg border">
            <div class="flex items-center justify-between">
                <span class="font-medium ${rentedGrowth >= 0 ? 'text-orange-700' : 'text-red-700'}">المؤجر</span>
                <span class="${rentedGrowth >= 0 ? 'text-orange-600' : 'text-red-600'} font-bold">${rentedGrowth >= 0 ? '+'
                    : ''}${rentedGrowth.toFixed(1)}%</span>
            </div>
            <p class="text-sm ${rentedGrowth >= 0 ? 'text-orange-600' : 'text-red-600'} mt-1">${rentedGrowth >= 0 ? 'نمو' :
                'انخفاض'} في المبيعات المؤجرة</p>
        </div>
    </div>
    `;
    } else if (currentTotal > 0) {
    statusBadge = `<span class="px-3 py-1 text-sm font-bold text-blue-800 bg-blue-100 rounded-full">بداية</span>`;
    analysisHTML = `
    <div class="flex items-center p-4 border border-blue-200 rounded-lg bg-blue-50">
        <svg class="w-6 h-6 ml-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <p class="font-bold text-blue-800">بداية جديدة</p>
            <p class="text-sm text-blue-600">لا توجد بيانات كافية للمقارنة مع الفترة السابقة</p>
        </div>
    </div>
    `;
    } else {
    trendSection.classList.add('hidden');
    return;
    }

    document.getElementById('trend-status-badge').innerHTML = statusBadge;
    analysisContent.innerHTML = analysisHTML;
    }

    // ==================== ADMIN CONTROLS ====================
    function showConfirmationModal(title, message, action) {
    document.getElementById('confirmation-title').textContent = title;
    document.getElementById('confirmation-message').textContent = message;
    pendingAction = action;
    document.getElementById('confirmation-modal').classList.remove('hidden');
    }

    function confirmAction() {
    if (pendingAction) {
    pendingAction();
    }
    closeModal('confirmation-modal');
    pendingAction = null;
    }

    function resetAllAmounts() {
    showConfirmationModal(
    'تصفير جميع المبالغ',
    'هل أنت متأكد من تصفير جميع المبالغ؟ هذا سيضبط جميع الأرقام إلى صفر ولكن سيحتفظ بالبيانات الهيكلية.',
    () => {
    const paymentBatch = db.batch();
    paymentMethods.forEach(pm => {
    const ref = db.collection('paymentMethods').doc(pm.id);
    paymentBatch.update(ref, { amount: 0 });
    });

    const deptBatch = db.batch();
    departments.forEach(dept => {
    const ref = db.collection('departments').doc(dept.id);
    deptBatch.update(ref, { amount: 0 });
    });

    const custodyBatch = db.batch();
    custodyItems.forEach(item => {
    const ref = db.collection('custodyItems').doc(item.id);
    custodyBatch.update(ref, { amount: 0 });
    });

    Promise.all([
    paymentBatch.commit(),
    deptBatch.commit(),
    custodyBatch.commit()
    ]).then(() => {
    alert('تم تصفير جميع المبالغ بنجاح');
    }).catch(error => {
    console.error("Error resetting amounts: ", error);
    alert("حدث خطأ أثناء التصفير");
    });
    }
    );
    }

    function deleteAllEntries() {
    showConfirmationModal(
    'حذف جميع التقارير',
    'هل أنت متأكد من حذف جميع التقارير اليومية؟ هذا سيحذف كل سجلات المبيعات والتقارير.',
    () => {
    const batch = db.batch();
    dailyEntries.forEach(entry => {
    const ref = db.collection('dailyEntries').doc(entry.id);
    batch.delete(ref);
    });

    batch.commit().then(() => {
    alert('تم حذف جميع التقارير بنجاح');
    }).catch(error => {
    console.error("Error deleting entries: ", error);
    alert("حدث خطأ أثناء الحذف");
    });
    }
    );
    }

    function resetAllData() {
    showConfirmationModal(
    'بداية جديدة',
    'هل أنت متأكد من بداية جديدة؟ هذا سيحذف جميع التقارير ويصفّر جميع المبالغ.',
    () => {
    const resetPromises = [];

    paymentMethods.forEach(pm => {
    resetPromises.push(
    db.collection('paymentMethods').doc(pm.id).update({ amount: 0 })
    );
    });

    departments.forEach(dept => {
    resetPromises.push(
    db.collection('departments').doc(dept.id).update({ amount: 0 })
    );
    });

    custodyItems.forEach(item => {
    resetPromises.push(
    db.collection('custodyItems').doc(item.id).update({ amount: 0 })
    );
    });

    const deleteBatch = db.batch();
    dailyEntries.forEach(entry => {
    const ref = db.collection('dailyEntries').doc(entry.id);
    deleteBatch.delete(ref);
    });

    Promise.all([
    ...resetPromises,
    deleteBatch.commit()
    ]).then(() => {
    alert('تم إتمام عملية البداية الجديدة بنجاح');
    }).catch(error => {
    console.error("Error resetting data: ", error);
    alert("حدث خطأ أثناء عملية البداية الجديدة");
    });
    }
    );
    }
</script>
</div>
