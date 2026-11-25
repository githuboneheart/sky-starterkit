<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserManagement extends Component
{
    use WithPagination;

    // Search and Filters
    public string $search = '';
    public string $selectedRole = '';
    public string $statusFilter = '';
    public string $sortField = 'id';
    public string $sortDirection = 'desc';

    // Modal Form State
    public bool $showModal = false;
    public bool $isEditMode = false;
    public ?int $editingUserId = null;

    // Form fields
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = '';
    public array $selectedRoles = [];
    public bool $is_active = true;

    // Delete Modal State
    public bool $showDeleteModal = false;
    public ?int $userToDeleteId = null;
    public string $userToDeleteName = '';

    // Impersonate Modal State
    public bool $showImpersonateModal = false;
    public ?int $impersonateUserId = null;
    public string $impersonateUserName = '';
    public string $impersonateUserRole = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedRole' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedRole(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function openCreateModal(): void
    {
        $this->resetValidation();
        $this->resetForm();
        $this->selectedRoles = [];
        $this->role = '';
        $this->isEditMode = false;
        $this->showModal = true;
        $this->dispatch('open-modal', 'user-form');
    }

    public function openEditModal(int $userId): void
    {
        $this->resetValidation();
        $user = User::with('roles')->findOrFail($userId);
        
        $this->editingUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
        $this->role = $this->selectedRoles[0] ?? '';
        $this->is_active = $user->is_active;
        $this->password = '';
        $this->password_confirmation = '';
        
        $this->isEditMode = true;
        $this->showModal = true;
        $this->dispatch('open-modal', 'user-form');
    }

    public function updated($propertyName): void
    {
        if ($propertyName === 'role' && !empty($this->role)) {
            $this->selectedRoles = array_unique(array_merge($this->selectedRoles, [$this->role]));
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->editingUserId ?? 'NULL') . ',id',
            'phone' => 'nullable|string|max:30',
            'selectedRoles' => 'required|array|min:1',
            'selectedRoles.*' => 'exists:roles,name',
            'is_active' => 'boolean',
        ];

        if (!$this->isEditMode) {
            $rules['password'] = 'required|string|min:6|confirmed';
            $rules['password_confirmation'] = 'required';
        } else {
            $rules['password'] = 'nullable|string|min:6|confirmed';
            $rules['password_confirmation'] = 'nullable';
        }

        if (array_key_exists($propertyName, $rules) || str_starts_with($propertyName, 'selectedRoles')) {
            $this->validateOnly($propertyName, $rules, [
                'name.required' => 'Nama lengkap wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.unique' => 'Email ini sudah terdaftar.',
                'selectedRoles.required' => 'Pilih minimal satu peran (role) untuk pengguna.',
                'selectedRoles.min' => 'Pilih minimal satu peran (role) untuk pengguna.',
                'password.required' => 'Kata sandi wajib diisi.',
                'password.min' => 'Kata sandi minimal 6 karakter.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            ]);
        }
    }

    public function save(): void
    {
        // Fallback for single role setter (e.g. tests or legacy calls)
        if (!empty($this->role) && empty($this->selectedRoles)) {
            $this->selectedRoles = [$this->role];
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->editingUserId ?? 'NULL') . ',id',
            'phone' => 'nullable|string|max:30',
            'selectedRoles' => 'required|array|min:1',
            'selectedRoles.*' => 'exists:roles,name',
            'is_active' => 'boolean',
        ];

        if (!$this->isEditMode) {
            $rules['password'] = 'required|string|min:6|confirmed';
        } else {
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }

        $validated = $this->validate($rules, [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'selectedRoles.required' => 'Pilih minimal satu peran (role) untuk pengguna.',
            'selectedRoles.min' => 'Pilih minimal satu peran (role) untuk pengguna.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $rolesList = implode(', ', $this->selectedRoles);

        if ($this->isEditMode) {
            $user = User::findOrFail($this->editingUserId);
            $updateData = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'is_active' => $this->is_active,
            ];

            if (!empty($this->password)) {
                $updateData['password'] = Hash::make($this->password);
            }

            $user->update($updateData);
            $user->syncRoles($this->selectedRoles);

            activity_log('UPDATE', 'User', "Memperbarui data pengguna [{$user->name}] dengan role [{$rolesList}]");
            $this->dispatch('toast', type: 'success', message: 'Data pengguna berhasil diperbarui!');
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => Hash::make($this->password),
                'is_active' => $this->is_active,
                'email_verified_at' => now(),
            ]);

            $user->syncRoles($this->selectedRoles);

            activity_log('CREATE', 'User', "Menambahkan pengguna baru [{$user->name}] dengan role [{$rolesList}]");
            $this->dispatch('toast', type: 'success', message: 'Pengguna baru berhasil ditambahkan!');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function toggleUserStatus(int $userId): void
    {
        $user = User::findOrFail($userId);

        if ($user->id === Auth::id()) {
            $this->dispatch('toast', type: 'error', message: 'Anda tidak dapat menonaktifkan akun sendiri.');
            return;
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusStr = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        activity_log('UPDATE', 'User', "Status akun [{$user->name}] {$statusStr}");
        $this->dispatch('toast', type: 'info', message: "Akun {$user->name} berhasil {$statusStr}.");
    }

    public function confirmDelete(int $userId): void
    {
        $user = User::findOrFail($userId);

        if ($user->id === Auth::id()) {
            $this->dispatch('toast', type: 'error', message: 'Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }

        if ($user->isSuperAdmin() && User::role('Super Admin')->count() <= 1) {
            $this->dispatch('toast', type: 'error', message: 'Tidak dapat menghapus satu-satunya akun Super Admin.');
            return;
        }

        $this->userToDeleteId = $user->id;
        $this->userToDeleteName = $user->name;
        $this->showDeleteModal = true;
        $this->dispatch('open-modal', 'confirm-delete');
    }

    public function deleteUser(): void
    {
        if (!$this->userToDeleteId) {
            return;
        }

        $user = User::findOrFail($this->userToDeleteId);
        $name = $user->name;
        $user->delete();

        activity_log('DELETE', 'User', "Menghapus akun pengguna [{$name}]");
        $this->dispatch('toast', type: 'success', message: "Pengguna {$name} berhasil dihapus.");

        $this->showDeleteModal = false;
        $this->userToDeleteId = null;
        $this->userToDeleteName = '';
    }

    public function confirmImpersonate(int $userId): void
    {
        $current = Auth::user();
        if (!$current || !$current->isSuperAdmin()) {
            $this->dispatch('toast', type: 'error', message: 'Hanya Super Administrator yang berhak menggunakan fitur impersonasi.');
            return;
        }

        $user = User::with('roles')->findOrFail($userId);

        if ($current->id === $user->id) {
            $this->dispatch('toast', type: 'error', message: 'Anda tidak dapat login sebagai diri sendiri.');
            return;
        }

        if ($user->isSuperAdmin()) {
            $this->dispatch('toast', type: 'error', message: 'Demi keamanan, sesama Super Administrator tidak dapat diimpersonasi.');
            return;
        }

        $this->impersonateUserId = $user->id;
        $this->impersonateUserName = $user->name;
        $this->impersonateUserRole = $user->roles->pluck('name')->implode(', ');
        $this->showImpersonateModal = true;
        $this->dispatch('open-modal', 'confirm-impersonate');
    }

    public function impersonateUser(): mixed
    {
        if (!$this->impersonateUserId) {
            return null;
        }

        $user = User::with('roles')->findOrFail($this->impersonateUserId);
        $current = Auth::user();

        if (!$current || !$current->isSuperAdmin()) {
            $this->dispatch('toast', type: 'error', message: 'Hanya Super Administrator yang berhak menggunakan fitur impersonasi.');
            return null;
        }

        if ($current->id === $user->id) {
            $this->dispatch('toast', type: 'error', message: 'Anda tidak dapat login sebagai diri sendiri.');
            return null;
        }

        if ($user->isSuperAdmin()) {
            $this->dispatch('toast', type: 'error', message: 'Demi keamanan, sesama Super Administrator tidak dapat diimpersonasi.');
            return null;
        }

        session()->put('impersonated_by_id', $current->id);

        activity_log('IMPERSONATE', 'Auth', "Super Admin [{$current->name}] login sebagai [{$user->name}] ({$user->roles->pluck('name')->implode(', ')})", [
            'original_user_id' => $current->id,
            'target_user_id' => $user->id,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', "Sekarang Anda sedang melihat sistem sebagai {$user->name}.");
    }

    public function resetForm(): void
    {
        $this->editingUserId = null;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = '';
        $this->selectedRoles = [];
        $this->is_active = true;
    }

    public function render()
    {
        $roles = Role::orderBy('id')->pluck('name')->toArray();

        $users = User::with('roles')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedRole, function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', $this->selectedRole);
                });
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter === '1');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.user-management', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
