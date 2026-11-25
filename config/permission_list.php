<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Master Permission List (Single Source of Truth)
    |--------------------------------------------------------------------------
    |
    | Daftarkan seluruh hak akses modul aplikasi di sini.
    | Format:
    |   'Nama Modul / Grup' => [
    |       '{modul}.{aksi}' => 'Deskripsi penjelasan hak akses',
    |   ]
    |
    | Aturan Otomatis (Auto-Sync):
    | 1. Setiap kali halaman /permissions dibuka oleh Super Admin, sistem otomatis
    |    menyinkronkan permission baru ke database & memberikannya ke Super Admin.
    | 2. TIDAK PERLU lagi mengetik perintah seeder di terminal secara manual!
    | 3. AI Agent (SkyAgent) WAJIB menambahkan permission baru ke file ini
    |    setiap kali membuat model, menu, atau fitur baru.
    |
    */

    'User Management' => [
        'users.view'        => 'Melihat daftar pengguna dan staf',
        'users.create'      => 'Menambahkan pengguna dan staf baru',
        'users.edit'        => 'Mengubah profil dan akun pengguna',
        'users.delete'      => 'Menghapus akun pengguna',
        'users.impersonate' => 'Login / menyamar sebagai pengguna lain',
    ],

    'Role Management' => [
        'roles.view'   => 'Melihat daftar peran (roles)',
        'roles.create' => 'Menambahkan peran baru',
        'roles.edit'   => 'Mengubah nama peran',
        'roles.delete' => 'Menghapus peran',
    ],

    'Permission Matrix' => [
        'permissions.view'   => 'Melihat matriks perizinan',
        'permissions.assign' => 'Mengatur penetapan izin pada peran',
    ],

    'App Settings' => [
        'settings.view' => 'Melihat konfigurasi dan pengaturan aplikasi',
        'settings.edit' => 'Mengubah profil toko, logo, dan sistem',
    ],

    'Activity Logs' => [
        'activity_logs.view'   => 'Melihat catatan audit log aktivitas pengguna',
        'activity_logs.export' => 'Mengekspor riwayat log aktivitas',
    ],
];
