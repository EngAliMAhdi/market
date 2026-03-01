<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Livewire\Branch;

// Route::view('/', 'welcome')->name('home');
Route::get('/lang/{locale}', function ($locale) {

    if (! in_array($locale, ['ar', 'en'])) {
        abort(400);
    }

    session(['locale' => $locale]);

    return redirect()->back();
})->name('lang.switch');
Route::middleware('guest', 'locale')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::middleware(['auth', 'verified', 'locale'])->group(function () {


    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
        Route::get('/branch', [App\Http\Controllers\BranchController::class, 'index'])->name('branch');
    });
    Route::middleware('role:admin,manager')->group(function () {
        Route::get('/sale', [App\Http\Controllers\SaleController::class, 'index'])->name('sale');
    });
    Route::get('/report', [App\Http\Controllers\ReportController::class, 'index'])->name('report');
    Route::post('/updated-password', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('password.update1');
    // Route::get('/branch', Branch::class)->name('branch');
    // Route::get('/branch', function () {
    //     return view('pages.branch');
    // })->name('branch');
    // Route::get('/branch', [App\Http\Controllers\BranchController::class, 'index'])->name('branch');
    // Route::get('/sale', [App\Http\Controllers\SaleController::class, 'index'])->name('sale');
    // Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');

});
// Route::get('/login', [App\Http\Controllers\LoginController::class, 'showLoginForm']);
// Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');



// require __DIR__ . '/settings.php';
