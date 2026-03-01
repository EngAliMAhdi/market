<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('layout.app_name') }} - {{ __('layout.app_desc') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Firebase SDKs -->
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-analytics-compat.js"></script>
    <!-- pdf export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap');

        body {
            font-family: 'Cairo', sans-serif;
        }

        .card {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .hidden {
            display: none !important;
        }

        .owned-badge {
            background-color: #10b981;
            color: white;
        }

        .rented-badge {
            background-color: #f59e0b;
            color: white;
        }

        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* تحسين المظهر العام */
        .stat-card {
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .branch-card {
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .branch-card:hover {
            border-color: #10b981;
        }

        .dashboard-number {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1;
        }

        @media (max-width: 768px) {
            .dashboard-number {
                font-size: 2rem;
            }
        }

        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }

        .trend-up {
            color: #10b981;
            background: rgba(16, 185, 129, 0.1);
        }

        .trend-down {
            color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .gradient-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .gradient-orange {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

    </style>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50">

    <div class=" min-h-screen">
        <!-- Header -->
        <header class="text-white shadow-lg gradient-bg">
            <div class="container px-6 py-4 mx-auto">
                <div class="flex flex-col items-center justify-between md:flex-row">
                    <div class="flex items-center mb-4 md:mb-0">
                        <svg class="w-10 h-10 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                        <div>
                            <h1 class="text-2xl font-bold" data-translate="appName">{{ __('layout.app_name') }}</h1>
                            <p class="text-sm text-blue-100" data-translate="appDesc">{{ __('layout.app_desc') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 space-x-reverse">
                      @php
                    $locale = app()->getLocale();
                    $newLocale = $locale === 'ar' ? 'en' : 'ar';
                    @endphp

                    <a href="{{ route('lang.switch', $newLocale) }}"
                        class="flex items-center mx-2 gap-2 px-4 py-2 font-bold text-blue-600 transition bg-white rounded-lg hover:bg-blue-50">

                        <span>
                            {{ __('layout.language') }}
                        </span>

                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                            </path>
                        </svg>
                    </a>
                   <button onclick="openPasswordModal()" class="flex items-center gap-2">

                    <div class="px-4 py-2 rounded-lg bg-white/20 flex items-center gap-2">

                        <!-- أيقونة الإعدادات -->
                        <i class="ri-settings-2-line text-lg transition-transform duration-500 hover:rotate-[360deg]"></i>

                        <span class="text-sm font-medium">
                            {{ Auth::user()->name }}
                        </span>

                    </div>

                </button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 font-bold text-red-600 transition bg-white rounded-lg hover:bg-red-50">
                                <span>{{ __('layout.logout') }}</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200 shadow-md">
            <div class="container px-6 mx-auto">
                <div class="flex py-2 space-x-1 space-x-reverse overflow-x-auto scrollbar-thin">

                    {{-- Dashboard --}}
                    @if(in_array(auth()->user()->role, ['admin','accountant']))
                    <a href="{{ route('dashboard') }}"
                        class="px-5 py-3 rounded-lg font-bold transition bg-gray-100 text-gray-700 hover:bg-gray-200 whitespace-nowrap">
                        {{ __('layout.dashboard') }}
                    </a>
                    @endif

                    {{-- Branches --}}
                    @if(in_array(auth()->user()->role, ['admin','accountant']))
                    <a href="{{ route('branch') }}"
                        class="px-5 py-3 rounded-lg font-bold transition bg-gray-100 text-gray-700 hover:bg-gray-200 whitespace-nowrap">
                        {{ __('layout.branches') }}
                    </a>
                    @endif

                    {{-- Daily Entry --}}
                    @if(in_array(auth()->user()->role, ['admin','manager']))
                    <a href="{{ route('sale') }}"
                        class="px-5 py-3 rounded-lg font-bold transition bg-gray-100 text-gray-700 hover:bg-gray-200 whitespace-nowrap">
                        {{ __('layout.daily_entry') }}
                    </a>
                    @endif

                    {{-- Users --}}
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('users') }}"
                        class="px-5 py-3 rounded-lg font-bold transition bg-gray-100 text-gray-700 hover:bg-gray-200 whitespace-nowrap">
                        {{ __('layout.users') }}
                    </a>
                    @endif

                    {{-- Reports --}}
                    @if(in_array(auth()->user()->role, ['admin','accountant','manager']))
                    <a href="{{ route('report') }}"
                        class="px-5 py-3 rounded-lg font-bold transition bg-gray-100 text-gray-700 hover:bg-gray-200 whitespace-nowrap">
                        {{ __('layout.reports') }}
                    </a>
                    @endif

                </div>
            </div>
        </nav>

  @yield('contain')
<div id="passwordModal" class="fixed inset-0 z-50 flex items-center justify-center hidden p-4 bg-black bg-opacity-50">

    <div class="w-full max-w-md p-8 bg-white shadow-2xl rounded-2xl">

        <h3 class="mb-6 text-xl font-bold text-gray-800">
            تغيير كلمة المرور
        </h3>

        <form method="POST" action="{{ route('password.update1') }}">
            @csrf

            <div class="space-y-4">

                {{-- كلمة المرور الجديدة --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        كلمة المرور الجديدة
                    </label>
                    <input type="password" name="password" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                </div>

                {{-- تأكيد كلمة المرور --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        تأكيد كلمة المرور
                    </label>
                    <input type="password" name="password_confirmation" required
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                </div>

            </div>

            <div class="flex justify-end mt-6 space-x-3 space-x-reverse">

                <button type="button" onclick="closePasswordModal()" class="px-5 py-2 bg-gray-200 rounded-lg">
                    إلغاء
                </button>

                <button type="submit" class="px-5 py-2 text-white bg-green-600 rounded-lg">
                    حفظ
                </button>

            </div>

        </form>
    </div>
</div>
    </div>

        @livewireScripts

        @vite('resources/js/app.js')
        <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
            <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

            <script>
                document.addEventListener('DOMContentLoaded', () => {
                  toastr.options = {
                "progressBar": true,
                "positionClass": "toast-top-right",
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                };
                @if(Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
                @endif
                @if(Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
                @endif
                    });

            </script>

            <script>
                function openPasswordModal() {
                document.getElementById('passwordModal').classList.remove('hidden');
            }

            function closePasswordModal() {
                document.getElementById('passwordModal').classList.add('hidden');
            }
            </script>
</body>
</html>
