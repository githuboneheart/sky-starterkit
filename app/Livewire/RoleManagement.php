<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleManagement extends Component
{
    public string $search = '';
    public string $newRoleName = '';
    public bool $showCreateModal = false;

    // Delete role state
    public bool $showDeleteModal = false;
    public ?int $roleToDeleteId = null;
    public string $roleToDeleteName = '';

    public function openCreateModal(): void
    {
        $this->resetValidation();
        $this->newRoleName = '';
        $this->showCreateModal = true;
    }

    public function updated($propertyName): void
    {
        if ($propertyName === 'newRoleName' && !empty($this->newRoleName)) {
            $this->validateOnly($propertyName, [
                'newRoleName' => 'required|string|max:50|unique:roles,name',
            ], [
                'newRoleName.required' => 'Nama role wajib diisi.',
                'newRoleName.unique' => 'Nama role ini sudah digunakan.',
            ]);
        }
    }

    public function createRole(): void
    {
        $this->validate([
            'newRoleName' => 'required|string|max:50|unique:roles,name',
        ], [
            'newRoleName.required' => 'Nama role wajib diisi.',
            'newRoleName.unique' => 'Nama role ini sudah digunakan.',
        ]);

        $role = Role::create([
            'name' => trim($this->newRoleName),
            'guard_name' => 'web',
        ]);

        activity_log('CREATE', 'Role', "Menambahkan peran (role) baru [{$role->name}]");
        $this->dispatch('toast', type: 'success', message: "Role {$role->name} berhasil dibuat!");

        $this->showCreateModal = false;
        $this->newRoleName = '';
    }

    public function confirmDelete(int $roleId): void
    {
        $role = Role::findOrFail($roleId);

        if ($role->name === 'Super Admin') {
            $this->dispatch('toast', type: 'error', message: 'Role Super Admin dilindungi dan tidak dapat dihapus.');
            return;
        }

        $this->roleToDeleteId = $role->id;
        $this->roleToDeleteName = $role->name;
        $this->showDeleteModal = true;
    }

    public function deleteRole(): void
    {
        if (!$this->roleToDeleteId) {
            return;
        }

        $role = Role::findOrFail($this->roleToDeleteId);

        if ($role->name === 'Super Admin') {
            $this->dispatch('toast', type: 'error', message: 'Role Super Admin tidak dapat dihapus.');
            return;
        }

        $name = $role->name;
        $role->delete();

        activity_log('DELETE', 'Role', "Menghapus peran (role) [{$name}]");
        $this->dispatch('toast', type: 'success', message: "Role {$name} berhasil dihapus.");

        $this->showDeleteModal = false;
        $this->roleToDeleteId = null;
    }

    public function render()
    {
        $roles = Role::withCount(['users', 'permissions'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.role-management', [
            'roles' => $roles,
            'totalPermissions' => Permission::count(),
        ]);
    }
}
