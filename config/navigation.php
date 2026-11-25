<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sidebar Navigation Registry
    |--------------------------------------------------------------------------
    |
    | Daftarkan menu sidebar di sini. Setiap menu WAJIB terikat dengan
    | hak akses permission ('permission' => '{module}.view').
    |
    | Aturan Otomatis:
    | 1. Jika permission bernilai null, menu tampil untuk semua user yang telah login (misal Dashboard).
    | 2. Jika permission diset (misal 'users.view'), menu HANYA tampil jika Auth::user()->can('users.view').
    | 3. Jika seluruh menu dalam suatu grup tidak diizinkan, judul grup otomatis disembunyikan.
    |
    */

    'Menu Utama' => [
        [
            'title'      => 'Dashboard Utama',
            'route'      => 'dashboard',
            'active'     => 'dashboard',
            'permission' => null, // Akses untuk semua user yang login
            'icon'       => 'home',
        ],
    ],

    'Akses & RBAC' => [
        [
            'title'      => 'Manajemen Pengguna',
            'route'      => 'users.index',
            'active'     => 'users.*',
            'permission' => 'users.view',
            'icon'       => 'users',
        ],
        [
            'title'      => 'Role / Peran',
            'route'      => 'roles.index',
            'active'     => 'roles.*',
            'permission' => 'roles.view',
            'icon'       => 'shield',
        ],
        [
            'title'      => 'Permission Matrix',
            'route'      => 'permissions.index',
            'active'     => 'permissions.*',
            'permission' => 'permissions.view',
            'icon'       => 'matrix',
            'badge'      => ['text' => 'Live', 'variant' => 'emerald'],
        ],
    ],

    'Sistem' => [
        [
            'title'      => 'Pengaturan Aplikasi',
            'route'      => 'settings.index',
            'active'     => 'settings.*',
            'permission' => 'settings.view',
            'icon'       => 'cog',
        ],
        [
            'title'      => 'Audit Log Aktivitas',
            'route'      => 'activity-logs.index',
            'active'     => 'activity-logs.*',
            'permission' => 'activity_logs.view',
            'icon'       => 'clock',
        ],
    ],
];
