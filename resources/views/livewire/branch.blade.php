<div class="container px-4 py-6 mx-auto md:px-6 md:py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-bold text-gray-800">{{ __('branch.title') }}</h2>

        <button wire:click="openModal"
            class="px-6 py-3 text-white transition rounded-lg shadow-lg gradient-green hover:opacity-90">
            + {{ __('branch.add_new') }}
        </button>
    </div>

    {{-- إحصائية --}}
   <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="p-4 bg-white border border-gray-200 shadow-sm rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">{{ __('branch.total_sales') }}</p>
                    <p class="text-2xl font-bold text-blue-600" id="branches-total-sales">{{ number_format($this->totalBranchSale, 2) }}</p>
                </div>
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 shadow-sm rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">{{ __('branch.total_owned') }}</p>
                    <p class="text-2xl font-bold text-green-600" id="branches-total-owned">{{ number_format($this->totalBranchOwned, 2) }}</p>
                </div>
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 shadow-sm rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">{{ __('branch.total_rented') }}</p>
                    <p class="text-2xl font-bold text-orange-600" id="branches-total-rented">{{ number_format($this->totalBranchRented, 2) }}</p>
                </div>
                <div class="p-2 bg-orange-100 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 shadow-sm rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">{{ __('branch.net_sales') }}</p>
                    <p class="text-2xl font-bold text-purple-600" id="branches-net-sales">{{ number_format($this->totalBranchNet, 2) }}</p>
                </div>
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- قائمة الفروع --}}
   <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

    @foreach($branches as $branch)

    @php
    // مؤقتاً أرقام وهمية – لاحقاً تربطها بالمبيعات الفعلية
    $totalOwned = 0;
    $totalRented = 0;
    $totalSales = 0;
    $totalNet = 0;
    @endphp

    <div class="branch-card bg-white shadow-sm hover:shadow-md transition-all duration-300 rounded-xl overflow-hidden">

        <div class="flex-grow p-6">

            {{-- Header --}}
            <div class="flex items-start justify-between pb-4 mb-6 border-b">
                <div>
                    <h3 class="mb-1 text-xl font-bold text-gray-800">
                        {{ $branch->name }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        {{ $branch->location }}
                    </p>
                </div>

                <div class="flex gap-2">

                    {{-- تحميل (تربطها لاحقاً) --}}
                   <button onclick="downloadBranchCard(this)" class="text-gray-400 hover:text-blue-600 transition" title="تحميل صورة">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                </button>

                    {{-- حذف --}}
                    <button wire:click="delete({{ $branch->id }})" wire:confirm="{{ __('branch.delete_confirm') }}"
                        class="text-gray-400 transition hover:text-red-600" title="حذف الفرع">
                        ×
                    </button>

                </div>
            </div>

            {{-- المدير --}}
            <div class="space-y-4">

                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">{{ __('branch.manager') }}</p>
                        <p class="font-medium">
                            {{ $branch->manager ?? '-' }}
                        </p>
                    </div>
                </div>

                {{-- الهاتف --}}
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 p-2 rounded-lg">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">{{ __('branch.phone') }}</p>
                        <p class="font-medium">
                            {{ $branch->phone ?? '-' }}
                        </p>
                    </div>
                </div>

            </div>

            {{-- الإحصائيات --}}
            <div class="p-4 pt-6 mt-8 space-y-4 border-t rounded-lg bg-gray-50">

                <div class="grid grid-cols-2 gap-4">

                    <div class="text-center">
                        <p class="mb-1 text-sm text-gray-500">{{ __('branch.total_owned') }}</p>
                        <p class="text-lg font-bold text-green-600">
                           {{ number_format($branch->totalOwnedSales(), 2) }}
                        </p>
                    </div>

                    <div class="text-center">
                        <p class="mb-1 text-sm text-gray-500">{{ __('branch.total_rented') }}</p>
                        <p class="text-lg font-bold text-orange-600">
                           {{ number_format($branch->totalRentedSales(), 2) }}
                        </p>
                    </div>

                </div>

                <div class="pt-4 border-t">

                    <div class="text-center">
                        <p class="mb-1 text-sm text-gray-500">{{ __('branch.total_sales') }}</p>
                        <p class="text-xl font-bold text-blue-600">
                            {{ number_format($branch->totalSales(), 2) }}
                        </p>
                    </div>

                    <div class="mt-2 text-center">
                        <p class="mb-1 text-sm text-gray-500">{{ __('branch.net_sales') }}</p>
                        <p class="font-medium text-gray-700">
                            {{ number_format($branch->totalNetSales(), 2) }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div class="pt-6 mt-6 border-t">
                <p class="text-sm text-center text-gray-500">
                  <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>  {{ __('branch.detailed_analysis') }}
                </p>
            </div>

        </div>
    </div>

    @endforeach

</div>

    {{-- Modal --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
        <div class="w-full max-w-md p-8 bg-white shadow-2xl rounded-2xl">

            <h3 class="mb-6 text-xl font-bold">{{ __('branch.add_branch') }}</h3>

            <div class="space-y-4">
                <div>
                    <input type="text" wire:model="name" placeholder="{{ __('branch.branch_name') }}" class="w-full p-3 border rounded-lg">
                    @error('name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                </div>

                <input type="text" wire:model="location" placeholder="{{ __('branch.location') }}" class="w-full p-3 border rounded-lg">

                <input type="text" wire:model="manager" placeholder="{{ __('branch.manager') }}" class="w-full p-3 border rounded-lg">

                <input type="text" wire:model="phone" placeholder="{{ __('branch.phone') }}" class="w-full p-3 border rounded-lg">
            </div>

            <div class="flex justify-end mt-6 space-x-3 space-x-reverse">
                <button wire:click="closeModal" class="px-5 py-2 bg-gray-200 rounded-lg">
                    {{ __('branch.cancel') }}
                </button>

                <button wire:click="save" class="px-5 py-2 text-white bg-green-600 rounded-lg">
                    {{ __('branch.save') }}
                </button>
            </div>
        </div>
    </div>
    @endif
<script>
    function downloadBranchCard(btn) {
    const card = btn.closest('.branch-card');
    const buttons = card.querySelectorAll('button');
    buttons.forEach(b => b.style.opacity = '0');

    html2canvas(card, {
    scale: 2,
    backgroundColor: '#ffffff',
    useCORS: true
    }).then(canvas => {
    buttons.forEach(b => b.style.opacity = '1');
    const link = document.createElement('a');
    link.download = `فرع-${new Date().getTime()}.png`;
    link.href = canvas.toDataURL();
    link.click();
    });
    }
</script>
</div>
