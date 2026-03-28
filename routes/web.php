<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;

use App\Http\Controllers\user\Auth\UserAuthController;

// Redirect root ke user login
Route::get('/', function () {
    return redirect()->route('admin.auth.login');
});

// ============================================
// ADMIN AUTH ROUTES
// ============================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('auth.login');
    Route::post('login', [AdminLoginController::class, 'login'])->name('login.post');
});

// ============================================
// PROTECTED ADMIN ROUTES (Dengan Middleware)
// ============================================
Route::middleware(['admin.auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard.dashboard');
    })->name('dashboard'); 




    // Logout
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

    // User Management (uncomment when ready)
    // Route::resource('users', UserController::class);

    // Schedule Management (uncomment when ready)
    // Route::resource('schedules', ScheduleController::class);

    // Lab Monitoring (uncomment when ready)
    // Route::get('lab/status', [AdminLabController::class, 'status'])->name('lab.status');

    // Route::get('lab', [AdminLabController::class, 'index'])->name('lab.index');
});