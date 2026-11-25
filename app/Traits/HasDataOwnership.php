<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Trait HasDataOwnership
 *
 * Memberikan kemampuan Row-Level Data Authorization secara otomatis.
 * Model yang menggunakan trait ini dapat memanggil query `Model::forCurrentUser(...)`.
 */
trait HasDataOwnership
{
    /**
     * Scope query untuk membatasi data sesuai wewenang pengguna yang sedang login.
     *
     * Aturan:
     * 1. Super Admin otomatis melihat semua data (God Mode).
     * 2. Jika user memiliki permission view_all (contoh: 'appointments.view_all'), tampilkan semua data.
     * 3. Jika user memiliki permission view_own (contoh: 'appointments.view_own'), filter berdasarkan kolom pemilik.
     * 4. Jika user tidak memiliki hak akses yang sesuai, query mengembalikan 0 hasil (aman dari kebocoran data).
     *
     * @param Builder $query
     * @param string|null $viewAllPermission Contoh: 'appointments.view_all' atau 'teaching.view_all'
     * @param string|null $viewOwnPermission Contoh: 'appointments.view_own' atau 'teaching.view_own'
     * @param string $ownerColumn Kolom foreign key pemilik data (default: 'user_id')
     * @return Builder
     */
    public function scopeForCurrentUser(
        Builder $query,
        ?string $viewAllPermission = null,
        ?string $viewOwnPermission = null,
        string $ownerColumn = 'user_id'
    ): Builder {
        /** @var User|null $user */
        $user = Auth::user();

        // Guest / belum login tidak boleh melihat data
        if (!$user) {
            return $query->whereRaw('1 = 0');
        }

        // 1. Super Admin selalu mendapatkan semua data
        if ($user->isSuperAdmin()) {
            return $query;
        }

        // 2. Jika user memiliki permission melihat semua data global
        if ($viewAllPermission && $user->can($viewAllPermission)) {
            return $query;
        }

        // 3. Jika user hanya memiliki permission melihat data miliknya sendiri
        if ($viewOwnPermission && $user->can($viewOwnPermission)) {
            return $query->where($this->qualifyColumn($ownerColumn), $user->id);
        }

        // 4. Default: Jika tidak dispesifikasikan nama permission, filter langsung ke user_id
        if (!$viewAllPermission && !$viewOwnPermission) {
            return $query->where($this->qualifyColumn($ownerColumn), $user->id);
        }

        // 5. Blokir jika tidak memenuhi izin di atas
        return $query->whereRaw('1 = 0');
    }
}
