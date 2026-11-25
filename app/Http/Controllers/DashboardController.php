<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // 1. Core Starterkit Metrics
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_roles' => Role::count(),
            'recent_logs_count' => ActivityLog::whereDate('created_at', today())->count(),
        ];

        // 2. Recent Audit Trail Activities
        $recentActivities = ActivityLog::with('user')
            ->latest('id')
            ->take(8)
            ->get();

        // 3. System Runtime & Server Health
        $dbStatus = 'Online (MySQL)';
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            $dbStatus = 'Offline';
        }

        $systemHealth = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'db_status' => $dbStatus,
            'app_env' => config('app.env'),
            'disk_free' => @disk_free_space(base_path()) ? round(disk_free_space(base_path()) / (1024 * 1024 * 1024), 2) . ' GB' : 'N/A',
        ];

        return view('dashboard', compact(
            'user',
            'stats',
            'recentActivities',
            'systemHealth'
        ));
    }
}
