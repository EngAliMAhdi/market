@extends('layouts.admin')

@section('contain')


    <!-- Content Container -->
    <div class="container px-4 py-6 mx-auto md:px-6 md:py-8">
        <!-- Dashboard Page -->
        <div id="dashboard-page" class=" space-y-8">
            <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                <h2 class="text-3xl font-bold text-gray-800">{{ __('dashboard.title') }}</h2>
                <div class="px-4 py-2 text-sm text-gray-500 bg-gray-100 rounded-lg">
                     {{ __('dashboard.last_update') }}: <span id="last-update">{{ date('Y-m-d') }}</span>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="stat-card gradient-green">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-white text-opacity-90">{{ __('dashboard.owned_sections') }}</p>
                            <p class="text-white dashboard-number" id="dashboard-owned-sections">{{ $countDepartmentsOwned }}</p>
                        </div>
                        <svg class="w-12 h-12 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <div class="pt-4 border-t border-white border-opacity-20">
                        <p class="text-sm text-white text-opacity-80">{{ __('dashboard.avg_performance') }}: <span class="font-bold">{{ __('dashboard.good') }}</span></p>
                    </div>
                </div>
                <div class="stat-card gradient-orange">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-white text-opacity-90">{{ __('dashboard.rented_sections') }}</p>
                            <p class="text-white dashboard-number" id="dashboard-rented-sections">{{ $countDepartmentsRented }}</p>
                        </div>
                        <svg class="w-12 h-12 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="pt-4 border-t border-white border-opacity-20">
                        <p class="text-sm text-white text-opacity-80">{{ __('dashboard.active_rentals') }}: <span
                                class="font-bold">{{ __('dashboard.all_active') }}</span></p>
                    </div>
                </div>
                <div class="stat-card gradient-blue">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-white text-opacity-90">{{ __('dashboard.branches_count') }}</p>
                            <p class="text-white dashboard-number" id="dashboard-branches-count">{{ $countBranches }}</p>
                        </div>
                        <svg class="w-12 h-12 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <div class="pt-4 border-t border-white border-opacity-20">
                        <p class="text-sm text-white text-opacity-80">{{ __('dashboard.active_branches') }}: <span class="font-bold"
                                id="active-branches">{{ $countBranches }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Branches Page -->

    </div>
@endsection
