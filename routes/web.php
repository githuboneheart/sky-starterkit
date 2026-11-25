<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root to dashboard or login
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Impersonation (Super Admin only)
    Route::post('/impersonate/{user}', [ImpersonateController::class, 'impersonate'])->name('impersonate');
    Route::post('/impersonate-leave', [ImpersonateController::class, 'leave'])->name('impersonate.leave');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // User Management
    Route::get('/users', function () {
        return view('users.index');
    })->middleware('can:users.view')->name('users.index');

    // Role Management
    Route::get('/roles', function () {
        return view('roles.index');
    })->middleware('can:roles.view')->name('roles.index');

    // Permission Matrix
    Route::get('/permissions', function () {
        return view('permissions.index');
    })->middleware('can:permissions.view')->name('permissions.index');

    // App Settings
    Route::get('/settings', function () {
        return view('settings.index');
    })->middleware('can:settings.view')->name('settings.index');

    // Activity Logs
    Route::get('/activity-logs', function () {
        return view('activity-logs.index');
    })->middleware('can:activity_logs.view')->name('activity-logs.index');
});
