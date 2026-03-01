<div class="container px-4 py-6 mx-auto md:px-6 md:py-8">
<div id="entry-page" class=" space-y-8">
    <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
        <h2 class="text-3xl font-bold text-gray-800">{{ __('sale.title') }}</h2>
        <div class="px-4 py-2 text-sm text-gray-500 bg-gray-100 rounded-lg">
            {{ __('sale.today_date') }}: <span id="current-date">{{ date('Y-m-d') }}</span>
        </div>
    </div>

    <div class="p-6 bg-white border border-gray-200 shadow-lg card rounded-xl">
        <form wire:submit.prevent="saveReport" class="space-y-6">
            <!-- المعلومات الأساسية -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">{{ __('sale.branch') }}</label>
                    <select id="entry-branch" required wire:model.live="branch_id"
                        class="w-full p-3 transition border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    @if (Auth::user()->role=='admin')
                    <option value=""> {{ __('sale.select_branch') }}</option>
                    @foreach($branches as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                    @else
                    <option value="{{ Auth::user()->branch_id }}" selected>{{ Auth::user()->branch->name }}</option >
                        @endif
                    </select>
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-700">{{ __('sale.date') }}</label>
                    <input type="date" value="{{ date('Y-m-d') }}" wire:model="report_date" id="entry-date" required
                        class="w-full p-3 transition border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            <!-- Sales Summary -->
            <div class="p-6 border border-blue-200 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl">
                <h3 class="pb-3 mb-6 text-lg font-bold text-gray-800 border-b">{{ __('sale.daily_sales_summary') }}</h3>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('sale.sales_before_tax') }}</label>
                        <input type="number" step="0.01" id="sales-before-tax" wire:model="total_before_tax"
                            class="w-full p-3 text-lg text-center transition border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0.00">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('sale.vat') }}</label>
                        <input type="number" step="0.01" id="sales-vat" wire:model="tax"
                            class="w-full p-3 text-lg text-center transition border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0.00">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('sale.sales_after_tax') }}</label>
                        <input type="number" step="0.01" id="sales-after-tax" wire:model="total_after_tax"
                            class="w-full p-3 text-lg font-bold text-center text-green-600 transition border border-gray-300 rounded-lg bg-green-50 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="0.00">
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">{{ __('sale.net_sales') }}</label>
                        <input type="number" step="0.01" id="sales-net" wire:model="net_sales"
                            class="w-full p-3 text-lg font-bold text-center text-blue-600 transition border border-gray-300 rounded-lg bg-blue-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0.00">
                    </div>
                </div>
            </div>

            <!-- Payment Methods & Departments Grid -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Payment Methods -->
                <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b">
                        <h3 class="text-lg font-bold text-gray-800">{{ __('sale.payment_methods') }}</h3>
                        <button type="button" wire:click="openModal('payment')"
                            class="flex items-center gap-2 px-4 py-2 font-bold text-white transition rounded-lg gradient-bg hover:opacity-90">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            {{ __('sale.add_payment_method') }}
                        </button>
                    </div>
                    <div id="payment-methods-list" class="space-y-3">
                        @foreach($paymentMethods as $method)
                        <div class="payment-item flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200">

                            <!-- أيقونة -->
                            <div class="p-2 bg-white border rounded-lg">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>

                            <!-- الاسم -->
                            <input type="text" value='{{ $method->name }}'
                                class="flex-1 px-3 py-2 text-sm transition border rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">

                            <!-- المبلغ -->
                            <input type="number" step="0.01" value="0.00" wire:model="payments.{{ $method->id }}"
                                class="px-3 py-2 text-sm font-medium text-right transition border rounded-lg w-28 focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                placeholder="0.00">

                            <!-- زر الإخفاء -->
                            <button class="p-2 text-red-500 transition hover:text-red-700">×</button>

                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Dynamic Departments -->
                <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b">
                        <h3 class="text-lg font-bold text-gray-800">{{ __('sale.departments_revenues') }}</h3>
                        <button type="button" wire:click="openModal('department')"
                            class="flex items-center gap-2 px-4 py-2 font-bold text-white transition rounded-lg gradient-green hover:opacity-90">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            إضافة قسم
                        </button>
                    </div>
                    <div id="departments-list" class="space-y-3">
                        @foreach($departments as $index => $dept)

                        <div class="department-item flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-lg">

                            {{-- النوع --}}
                            <span class="px-3 py-1 text-xs font-bold rounded-lg
                                        {{ $dept['type'] === 'owned'
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-orange-100 text-orange-800' }}">

                                {{ $dept['type'] === 'owned' ? __('sale.owned') : __('sale.rented') }}
                            </span>

                            {{-- الاسم --}}
                            <input type="text" value="{{ $dept['name'] }}"
                                class="flex-1 px-3 py-2 text-sm transition border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                @disabled(auth()->user()?->role === 'accountant')>

                            {{-- المبلغ --}}
                            <input type="number" step="0.01"  data-type="{{ $dept['type'] }}" oninput="calculateTotals()" wire:model="departmentRevenues.{{ $dept['id'] }}"
                                value="{{ $dept['amount'] ?? 0 }}"
                                class="dept-amount w-28 px-3 py-2 text-sm font-medium text-right transition border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="0.00" @disabled(auth()->user()?->role === 'accountant')>

                            {{-- حذف --}}
                            @if(auth()->user()?->role !== 'accountant')
                            <button type="button" onclick="hideDepartment(this)" class="p-2 text-red-500 transition hover:text-red-700">
                                ×
                            </button>
                            @endif

                        </div>

                        @endforeach
                    </div>
                    <div class="p-4 pt-6 mt-6 space-y-4 border-t rounded-lg bg-gray-50">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-green-600">{{ __('sale.total_owned') }}:</span>
                            <span id="owned-total" class="text-xl font-bold text-green-600">0.00</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-orange-600">{{ __('sale.total_rented') }}:</span>
                            <span id="rented-total" class="text-xl font-bold text-orange-600">0.00</span>
                        </div>
                        <div class="flex items-center justify-between pt-4 text-lg border-t">
                            <span class="font-bold text-blue-600">{{ __('sale.total') }}:</span>
                            <span id="grand-total" class="text-2xl font-bold text-blue-600">0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Custody Management -->
            <div class="p-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                <div class="flex items-center justify-between pb-4 mb-6 border-b">
                    <h3 class="text-lg font-bold text-gray-800">{{ __('sale.custody') }}</h3>
                    <button type="button" wire:click="openModal('custody')"
                        class="flex items-center gap-2 px-4 py-2 font-bold text-white transition rounded-lg gradient-bg hover:opacity-90">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        {{ __('sale.add_custody') }}
                    </button>
                </div>
                <div id="custody-list" class="space-y-3">
                    @foreach($custodys as $index => $item)

                    <div class="custody-item flex items-center gap-3 p-3 bg-gray-50 border border-gray-200 rounded-lg">

                        {{-- الرقم --}}
                        <span class="px-3 py-1 text-sm font-bold text-blue-800 bg-blue-100 rounded-lg">
                            {{ $index + 1 }}
                        </span>

                        {{-- الاسم --}}
                        <input type="text"  value="{{ $item['name'] }}"
                            class="flex-1 px-3 py-2 text-sm transition border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            @disabled(auth()->user()?->role === 'accountant')>

                        {{-- المبلغ --}}
                        <input type="number" step="0.01"
                            value="{{ $item['amount'] ?? 0 }}" wire:model="custodyRevenues.{{ $item['id'] }}"
                            class="w-28 px-3 py-2 text-sm font-medium text-right transition border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="0.00" @disabled(auth()->user()?->role === 'accountant')>

                        {{-- إخفاء --}}
                        @if(auth()->user()?->role !== 'accountant')
                        <button type="button" onclick="hideCustody(this)" class="p-2 text-gray-500 transition hover:text-gray-700">
                            ×
                        </button>


                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <button type="submit"
                class="w-full px-8 py-4 text-lg font-bold text-white transition transform rounded-lg shadow-lg gradient-green hover:opacity-90 hover:-translate-y-1">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                        </path>
                    </svg>
                    {{ __('sale.save_daily_report') }}
                </span>
            </button>
        </form>
    </div>


    @if($activeModal === 'payment')
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">{{ __('sale.add_payment_method') }}</h3>
            <input type="text" wire:model="newName" placeholder="{{ __('sale.payment_name') }}" class="w-full p-3 border rounded-lg mb-4">
            <div class="flex justify-end gap-3">
                <button wire:click="closeModal" class="px-4 py-2 bg-gray-200 rounded-lg">{{ __('sale.cancel') }}</button>
                <button wire:click="savePaymentMethod" class="px-4 py-2 bg-purple-600 text-white rounded-lg">{{ __('sale.save') }}</button>
            </div>
        </div>
    </div>
    @endif

    <!-- مودل Department -->
    @if($activeModal === 'department')
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">{{ __('sale.add_department') }}</h3>
            <input type="text" wire:model="newName" placeholder="{{ __('sale.department_name') }}" class="w-full p-3 border rounded-lg mb-4">
            <select wire:model="newDeptType" class="w-full p-3 border rounded-lg mb-4">
                <option value="owned">{{ __('sale.owned') }}</option>
                <option value="rented">{{ __('sale.rented') }}</option>
            </select>
            <div class="flex justify-end gap-3">
                <button wire:click="closeModal" class="px-4 py-2 bg-gray-200 rounded-lg">{{ __('sale.cancel') }}</button>
                <button wire:click="saveDepartment" class="px-4 py-2 bg-blue-600 text-white rounded-lg">{{ __('sale.save') }}</button>
            </div>
        </div>
    </div>
    @endif

    <!-- مودل Custody -->
    @if($activeModal === 'custody')
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-xl w-full max-w-md">
            <h3 class="text-xl font-bold mb-4">{{ __('sale.add_custody') }}</h3>
            <input type="text" wire:model="newName" placeholder="{{ __('sale.custody_name') }}" class="w-full p-3 border rounded-lg mb-4">
            <div class="flex justify-end gap-3">
                <button wire:click="closeModal" class="px-4 py-2 bg-gray-200 rounded-lg">{{ __('sale.cancel') }}</button>
                <button wire:click="saveCustody" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">{{ __('sale.save') }}</button>
            </div>
        </div>
    </div>
    @endif
</div>
<script>
    function hideCustody(button) {
    // نخفي العنصر الأب مباشرة
    button.closest('.custody-item').style.display = 'none';
}
function hideDepartment(button) {
    // نخفي العنصر الأب مباشرة
    button.closest('.department-item').style.display = 'none';
    }
function calculateTotals() {
let ownedTotal = 0;
let rentedTotal = 0;

document.querySelectorAll('.dept-amount').forEach(input => {
let value = parseFloat(input.value) || 0;
let type = input.dataset.type;

if (type === 'owned') {
ownedTotal += value;
} else if (type === 'rented') {
rentedTotal += value;
}
});

let grandTotal = ownedTotal + rentedTotal;

document.getElementById('owned-total').textContent = ownedTotal.toFixed(2);
document.getElementById('rented-total').textContent = rentedTotal.toFixed(2);
document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
}

document.addEventListener('DOMContentLoaded', calculateTotals);
</script>
</div>
