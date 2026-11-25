<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar Permission per Modul
        $modules = [
            'User Management' => [
                'users.view'        => 'Melihat daftar pengguna',
                'users.create'      => 'Menambahkan pengguna baru',
                'users.edit'        => 'Mengubah profil pengguna',
                'users.delete'      => 'Menghapus pengguna',
                'users.impersonate' => 'Login sebagai pengguna lain',
            ],
            'Role Management' => [
                'roles.view'   => 'Melihat daftar peran',
                'roles.create' => 'Menambahkan peran baru',
                'roles.edit'   => 'Mengubah peran',
                'roles.delete' => 'Menghapus peran',
            ],
            'Permission Matrix' => [
                'permissions.view'   => 'Melihat matriks perizinan',
                'permissions.assign' => 'Mengatur penetapan izin peran',
            ],
            'App Settings' => [
                'settings.view' => 'Melihat pengaturan aplikasi',
                'settings.edit' => 'Mengubah pengaturan aplikasi',
            ],
            'Activity Logs' => [
                'activity_logs.view'   => 'Melihat riwayat log aktivitas',
                'activity_logs.export' => 'Mengekspor log aktivitas',
            ],
        ];

        // Buat Permissions
        foreach ($modules as $group => $permissions) {
            foreach ($permissions as $name => $description) {
                Permission::firstOrCreate(
                    ['name' => $name, 'guard_name' => 'web'],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
        }

        // 1. Super Admin Role (Memiliki 100% permissions)
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // 2. Admin Role (Operasional penuh kecuali hapus user & impersonate)
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminPermissions = Permission::whereNotIn('name', [
            'users.impersonate',
            'users.delete',
            'roles.delete',
        ])->get();
        $admin->syncPermissions($adminPermissions);

        // 3. Manager Role (View & Settings)
        $manager = Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
        $manager->syncPermissions([
            'users.view',
            'roles.view',
            'permissions.view',
            'settings.view',
            'activity_logs.view',
        ]);

        // 4. Staff / Kasir Role (View dasar)
        $staff = Role::firstOrCreate(['name' => 'Staff', 'guard_name' => 'web']);
        $staff->syncPermissions([
            'users.view',
        ]);
    }
}
