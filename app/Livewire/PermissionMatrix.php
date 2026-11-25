<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionMatrix extends Component
{
    public int $selectedRoleId;
    public string $search = '';
    public array $rolePermissions = [];

    // Modal Create New Permission
    public bool $showCreateModal = false;
    public string $newPermissionName = '';
    public string $newPermissionGroup = 'Custom Module';

    public function mount(?int $roleId = null): void
    {
        $this->syncPermissionsFromConfig();
        $firstRole = Role::first();
        $this->selectedRoleId = $roleId ?? ($firstRole?->id ?? 1);
        $this->loadRolePermissions();
    }

    /**
     * Otomatis sinkronisasi permission dari config/permission_list.php ke database.
     * Tidak perlu lagi menjalankan 'php artisan db:seed' secara manual!
     */
    public function syncPermissionsFromConfig(): void
    {
        $configList = config('permission_list', []);
        if (empty($configList)) {
            return;
        }

        $allDbPermissions = Permission::pluck('name')->toArray();
        $newPermissions = [];

        foreach ($configList as $group => $permissions) {
            foreach ($permissions as $name => $desc) {
                if (!in_array($name, $allDbPermissions)) {
                    $newPermissions[] = $name;
                }
            }
        }

        if (!empty($newPermissions)) {
            $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);

            foreach ($newPermissions as $permName) {
                $p = Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
                $superAdmin->givePermissionTo($p);
            }

            app()[PermissionRegistrar::class]->forgetCachedPermissions();
        }
    }

    public function selectRole(int $roleId): void
    {
        $this->selectedRoleId = $roleId;
        $this->loadRolePermissions();
    }

    public function loadRolePermissions(): void
    {
        $role = Role::with('permissions')->find($this->selectedRoleId);
        if ($role) {
            $this->rolePermissions = $role->permissions->pluck('name')->toArray();
        } else {
            $this->rolePermissions = [];
        }
    }

    /**
     * Toggle individual permission for the currently selected role.
     */
    public function togglePermission(string $permissionName): void
    {
        $role = Role::findOrFail($this->selectedRoleId);

        if ($role->name === 'Super Admin') {
            $this->dispatch('toast', type: 'warning', message: 'Role Super Admin selalu memiliki semua hak akses secara otomatis.');
            return;
        }

        if (in_array($permissionName, $this->rolePermissions)) {
            $role->revokePermissionTo($permissionName);
            $this->rolePermissions = array_diff($this->rolePermissions, [$permissionName]);
            $action = 'mencabut';
        } else {
            $role->givePermissionTo($permissionName);
            $this->rolePermissions[] = $permissionName;
            $action = 'memberikan';
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        activity_log('UPDATE', 'Permission', "Super Admin {$action} izin [{$permissionName}] pada role [{$role->name}]");
        $this->dispatch('toast', type: 'success', message: "Hak akses [{$permissionName}] berhasil diperbarui!");
    }

    /**
     * Select all permissions in a specific group.
     */
    public function selectAllInGroup(array $permissionNames): void
    {
        $role = Role::findOrFail($this->selectedRoleId);

        if ($role->name === 'Super Admin') {
            return;
        }

        foreach ($permissionNames as $perm) {
            if (!in_array($perm, $this->rolePermissions)) {
                $role->givePermissionTo($perm);
                $this->rolePermissions[] = $perm;
            }
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        activity_log('UPDATE', 'Permission', "Memberikan semua izin grup pada role [{$role->name}]");
        $this->dispatch('toast', type: 'success', message: "Semua izin di grup ini berhasil diaktifkan!");
    }

    /**
     * Deselect all permissions in a specific group.
     */
    public function deselectAllInGroup(array $permissionNames): void
    {
        $role = Role::findOrFail($this->selectedRoleId);

        if ($role->name === 'Super Admin') {
            $this->dispatch('toast', type: 'warning', message: 'Hak akses Super Admin tidak dapat dicabut.');
            return;
        }

        foreach ($permissionNames as $perm) {
            if (in_array($perm, $this->rolePermissions)) {
                $role->revokePermissionTo($perm);
            }
        }

        $this->rolePermissions = array_diff($this->rolePermissions, $permissionNames);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        activity_log('UPDATE', 'Permission', "Mencabut semua izin grup pada role [{$role->name}]");
        $this->dispatch('toast', type: 'info', message: "Semua izin di grup ini berhasil dinonaktifkan!");
    }

    /**
     * Open modal to create a new permission dynamically from UI.
     */
    public function openCreatePermissionModal(): void
    {
        $this->resetValidation();
        $this->newPermissionName = '';
        $this->newPermissionGroup = 'Modul Kustom';
        $this->showCreateModal = true;
    }

    /**
     * Save newly created permission.
     */
    public function createPermission(): void
    {
        $this->validate([
            'newPermissionName' => 'required|string|max:100|regex:/^[a-zA-Z0-9_\.]+$/|unique:permissions,name',
        ], [
            'newPermissionName.required' => 'Nama permission wajib diisi.',
            'newPermissionName.regex' => 'Gunakan format dot-notation (contoh: modul.aksi atau fitur.view).',
            'newPermissionName.unique' => 'Nama permission ini sudah ada.',
        ]);

        $perm = Permission::create([
            'name' => strtolower(trim($this->newPermissionName)),
            'guard_name' => 'web',
        ]);

        // Auto assign to Super Admin
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $superAdmin?->givePermissionTo($perm);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        activity_log('CREATE', 'Permission', "Menambahkan permission baru [{$perm->name}]");
        $this->dispatch('toast', type: 'success', message: "Permission [{$perm->name}] berhasil dibuat!");

        $this->showCreateModal = false;
        $this->newPermissionName = '';
        $this->loadRolePermissions();
    }

    /**
     * Helper to group permissions logically using config/permission_list.php and dynamic prefix fallback.
     */
    private function getGroupedPermissions(): array
    {
        $allPermissions = Permission::orderBy('name')->get();
        $configList = config('permission_list', []);

        $groups = [];
        $permissionToGroup = [];

        foreach ($configList as $groupTitle => $items) {
            $groups[$groupTitle] = [];
            foreach ($items as $name => $desc) {
                $permissionToGroup[$name] = $groupTitle;
            }
        }

        foreach ($allPermissions as $perm) {
            $name = $perm->name;

            // Filter search if query exists
            if ($this->search && !str_contains(strtolower($name), strtolower($this->search))) {
                continue;
            }

            if (isset($permissionToGroup[$name])) {
                $groups[$permissionToGroup[$name]][] = $perm;
            } else {
                // Dynamic Auto-Grouping by prefix (e.g. 'inventory.view' -> 'Inventory')
                if (str_contains($name, '.')) {
                    $prefix = explode('.', $name, 2)[0];
                    $groupTitle = str($prefix)->replace(['_', '-'], ' ')->title()->toString();
                    $groups[$groupTitle][] = $perm;
                } else {
                    $groups['Modul Kustom'][] = $perm;
                }
            }
        }

        // Remove empty groups
        return array_filter($groups, fn($items) => !empty($items));
    }

    /**
     * Dapatkan deskripsi ramah untuk permission dari config/permission_list.php.
     */
    public function getPermissionDescription(string $name): string
    {
        $configList = config('permission_list', []);
        foreach ($configList as $group => $items) {
            if (isset($items[$name])) {
                return $items[$name];
            }
        }
        return 'Hak akses modul ' . $name;
    }

    public function render()
    {
        $roles = Role::withCount('permissions')->get();
        $currentRole = $roles->firstWhere('id', $this->selectedRoleId) ?? Role::find($this->selectedRoleId);
        $groupedPermissions = $this->getGroupedPermissions();

        return view('livewire.permission-matrix', [
            'roles' => $roles,
            'currentRole' => $currentRole,
            'groupedPermissions' => $groupedPermissions,
        ]);
    }
}
