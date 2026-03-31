<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\StudentsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;

// Redirect root ke login admin
Route::get('/', function () {
    return redirect()->route('admin.auth.login');
});

// =============================
// ADMIN AUTH
// =============================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('auth.login');
    Route::post('login', [AdminLoginController::class, 'login'])->name('login.post');
});

// =============================
// PROTECTED ADMIN
// =============================
Route::prefix('admin')
    ->name('admin.')
    ->middleware('admin.auth')
    ->group(function () {

        Route::get('dashboard', function () {
            return view('admin.dashboard.dashboard');
        })->name('dashboard');

        // Students
        Route::resource('students', StudentsController::class);

        // Report
        Route::resource('report', ReportController::class);

        // ✅ TAMBAHAN REPORT
        Route::post('report/{id}/status', [ReportController::class, 'updateStatus'])
            ->name('report.updateStatus');

        Route::get('report/{id}/bukti', [ReportController::class, 'viewBukti'])
            ->name('report.viewBukti');


        Route::get('report/view-bukti/{id}', [ReportController::class, 'viewBukti'])
            ->name('report.viewBukti');

        Route::post('report/update-status/{id}', [ReportController::class, 'updateStatus'])
            ->name('report.updateStatus');

        // Settings
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings/update-profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');
        Route::put('settings/update-password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');

        // Logout
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');
    });
