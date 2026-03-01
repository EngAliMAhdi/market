<div class="container px-4 py-6 mx-auto md:px-6 md:py-8">

    <div id="users-page" class=" space-y-8">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold text-gray-800">{{ __('user.title') }}</h2>
            <button wire:click="openModal"
                class="flex items-center gap-2 px-6 py-3 font-bold text-white rounded-lg shadow-lg gradient-blue hover:opacity-90">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('user.add_user') }}
            </button>
        </div>
        <div id="users-list" class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($users as $user)
              <div class="branch-card bg-white p-6 rounded-xl shadow">

                    <h3 class="pb-3 mb-4 text-lg font-bold text-gray-800 border-b">
                        {{ $user->name }}
                    </h3>

                    <div class="space-y-3">

                        <!-- اسم المستخدم -->
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('user.full_name') }}</p>
                                <p class="font-medium">{{ $user->username }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-purple-100 rounded-lg">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('user.phone') }}</p>
                                <p class="font-medium">{{ $user->phone }}</p>
                            </div>
                        </div>
                        <!-- الصلاحية -->
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('user.role') }}</p>
                                <p class="font-medium">{{ $user->role === 'manager' ? __('user.manager') : __('user.accountant') }}</p>
                            </div>
                        </div>

                        <!-- الفرع -->
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-orange-100 rounded-lg">
                                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">{{ __('user.branch') }}</p>
                                <p class="font-medium">{{ $user->branch->name }}</p>
                            </div>
                        </div>

                    </div>

                    <button wire:click="deleteUser({{ $user->id }})" wire:confirm="{{ __('user.delete_confirm') }}"
                        class="w-full px-4 py-3 mt-6 font-bold text-white transition rounded-lg bg-red-500 hover:opacity-90">
                        {{ __('user.delete_user') }}
                    </button>

                </div>
            @endforeach
        </div>
    </div>
@if($showModal)
<div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">

    <div class="w-full max-w-md p-8 bg-white shadow-2xl rounded-2xl">
            <div class="flex items-center mb-4">
                <div class="p-3 ml-4 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800">{{ __('user.add_new_user') }}</h3>
            </div>
            <div class="space-y-3">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('user.full_name') }}</label>
                    <input type="text" id="new-user-name" wire:model="name"
                        class="w-full p-2 transition border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('user.username') }}</label>
                    <input type="text" id="new-user-username" wire:model="username"
                        class="w-full p-2 transition border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('user.phone') }}</label>
                    <input type="text" id="new-user-phone" wire:model="phone"
                        class="w-full p-2 transition border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('user.password') }}</label>
                    <input type="password" id="new-user-password" wire:model="password"
                        class="w-full p-2 transition border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('user.role') }}</label>
                    <select id="new-user-role" wire:model="role"
                        class="w-full p-2 transition border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="manager">{{ __('user.manager') }}</option>
                        <option value="accountant">{{ __('user.accountant') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('user.branch') }}</label>
                    <select wire:model="branch_id"
                        class="w-full p-2 transition border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">{{ __('user.select_branch') }}</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">
                        {{ $branch->name }}
                        </option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="flex justify-end pt-6 mt-8 space-x-3 space-x-reverse border-t border-gray-200">
                <button wire:click="closeModal"
                    class="px-6 py-2 font-bold text-gray-700 transition bg-gray-200 rounded-lg hover:bg-gray-300">{{ __('user.cancel') }}</button>
                <button wire:click="saveUser"
                    class="px-6 py-2 font-bold text-white transition rounded-lg shadow-lg gradient-blue hover:opacity-90">{{ __('user.save_user') }}</button>
            </div>
        </div>
    </div>
    @endif
</div>
