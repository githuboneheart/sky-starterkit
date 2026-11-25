<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    /**
     * Start impersonating a user (Super Admin only).
     */
    public function impersonate(Request $request, User $user): RedirectResponse
    {
        $current = Auth::user();

        // 1. Strict Authorization: Only Super Admin can impersonate
        if (!$current || !$current->isSuperAdmin()) {
            abort(403, 'Hanya Super Administrator yang berhak menggunakan fitur impersonasi.');
        }

        // 2. Prevent impersonating self
        if ($current->id === $user->id) {
            return back()->with('error', 'Anda tidak dapat login sebagai diri sendiri.');
        }

        // 3. Prevent impersonating another Super Admin
        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Demi keamanan, sesama Super Administrator tidak dapat diimpersonasi.');
        }

        // Store original admin ID in session
        session()->put('impersonated_by_id', $current->id);

        // Record audit activity
        activity_log('IMPERSONATE', 'Auth', "Super Admin [{$current->name}] login sebagai [{$user->name}] ({$user->roles->pluck('name')->implode(', ')})", [
            'original_user_id' => $current->id,
            'target_user_id' => $user->id,
        ]);

        // Login as target user
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', "Sekarang Anda sedang melihat sistem sebagai {$user->name}.");
    }

    /**
     * Stop impersonating and return to Super Admin.
     */
    public function leave(Request $request): RedirectResponse
    {
        $originalAdminId = session()->pull('impersonated_by_id');

        if (!$originalAdminId) {
            return redirect()->route('dashboard');
        }

        $admin = User::find($originalAdminId);

        if (!$admin || !$admin->isSuperAdmin()) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Sesi impersonasi telah kedaluwarsa.');
        }

        $impersonatedUser = Auth::user();

        // Re-login as original Super Admin
        Auth::login($admin);

        // Record audit activity
        activity_log('LEAVE_IMPERSONATE', 'Auth', "Super Admin [{$admin->name}] kembali ke akun utama dari [{$impersonatedUser?->name}]");

        return redirect()->route('users.index')->with('success', 'Berhasil kembali ke akun Super Administrator.');
    }
}
