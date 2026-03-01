@extends('layouts.login')

@section('contain')
<div id="login-page" class="flex items-center justify-center min-h-screen gradient-bg">
    <div class="w-full max-w-md p-10 mx-4 bg-white shadow-2xl rounded-2xl">
        <div class="mb-8 text-center">
            <div class="mb-4">
                <svg class="w-16 h-16 mx-auto text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
            </div>
            <h1 class="mb-2 text-3xl font-bold text-gray-800" data-translate="appName">{{ __('auth.app_name') }} </h1>
            <p class="text-gray-600" data-translate="appDesc">{{ __('auth.app_desc') }}</p>
        </div>
        @if ($errors->any())
        <div class="px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded-lg animate-pulse">
            {{ $errors->first() }}
        </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
        <div class="space-y-6">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700" data-translate="username">{{ __('auth.phone') }}
                    </label>
              <input type="text" name="phone" id="phone"
                class="w-full p-3 transءition border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                placeholder="07xxxxxxxx">
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700" data-translate="password">{{ __('auth.password') }}</label>
                    </label>
                <input type="password" id="password" name="password"
                    class="w-full p-3 transition border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                    placeholder="password" >
            </div>
            <div id="login-error" class="hidden px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded">
                {{ __('auth.login_error') }}
            </div>
            <div id="loading-message" class="hidden font-bold text-center text-blue-600">
                {{ __('auth.loading') }}
            </div>
            <button type="submit"
                class="w-full gradient-green text-white py-3 rounded-lg font-bold hover:opacity-90 transition shadow-lg transform hover:-translate-y-0.5">
                {{ __('auth.login') }}
            </button>
        </div>
        </form>
    </div>
</div>
@endsection
