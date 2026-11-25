<div>
    <!-- Top Action Bar & Filters -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Search & Filter Controls -->
        <div class="flex flex-wrap items-center gap-3 flex-1">
            <!-- Global Search Component -->
            <div class="w-full sm:w-72">
                <x-form.search
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama, email, telepon..."
                />
            </div>

            <!-- Role Filter -->
            <select
                wire:model.live="selectedRole"
                class="rounded-xl border border-slate-300 dark:border-slate-700/80 bg-white dark:bg-slate-900 px-3.5 py-2 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition"
            >
                <option value="">Semua Role</option>
                @foreach ($roles as $r)
                    @php $rName = is_array($r) ? ($r['name'] ?? reset($r)) : (is_object($r) ? ($r->name ?? (string)$r) : (string)$r); @endphp
                    <option value="{{ $rName }}">{{ $rName }}</option>
                @endforeach
            </select>

            <!-- Status Filter -->
            <select
                wire:model.live="statusFilter"
                class="rounded-xl border border-slate-300 dark:border-slate-700/80 bg-white dark:bg-slate-900 px-3.5 py-2 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition"
            >
                <option value="">Semua Status</option>
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
        </div>

        <!-- Add User Button -->
        @can('users.create')
            <x-button
                type="button"
                @click="$dispatch('open-modal', 'user-form'); $wire.openCreateModal()"
                variant="primary"
            >
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengguna
            </x-button>
        @endcan
    </div>

    <!-- Users Table -->
    <x-table>
        <x-slot:head>
            <x-table.th sortable field="name" :currentSort="$sortField" :direction="$sortDirection">Pengguna</x-table.th>
            <x-table.th>Peran (Role)</x-table.th>
            <x-table.th>Status</x-table.th>
            <x-table.th>Login Terakhir</x-table.th>
            <x-table.th align="right">Aksi</x-table.th>
        </x-slot:head>

        @forelse ($users as $user)
            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors">
                <!-- User Info -->
                <x-table.td>
                    <div class="flex items-center gap-3">
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 dark:border-slate-700 shrink-0" />
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $user->name }}</span>
                                @if ($user->id === Auth::id())
                                    <x-badge variant="primary" size="sm">Anda</x-badge>
                                @endif
                            </div>
                            <span class="text-xs text-slate-500 dark:text-slate-400 block">{{ $user->email }}</span>
                            @if ($user->phone)
                                <span class="text-[11px] text-slate-400 block">{{ $user->phone }}</span>
                            @endif
                        </div>
                    </div>
                </x-table.td>

                <!-- Role Badge -->
                <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1.5 max-w-xs">
                        @forelse ($user->roles as $role)
                            <x-badge :variant="$role->name === 'Super Admin' ? 'primary' : 'gray'" size="md">
                                {{ $role->name }}
                            </x-badge>
                        @empty
                            <span class="text-xs text-slate-400 italic">Tanpa Role</span>
                        @endforelse
                    </div>
                </td>

                <!-- Status Switch -->
                <td class="px-6 py-4">
                    <button
                        type="button"
                        wire:click="toggleUserStatus({{ $user->id }})"
                        @if ($user->id === Auth::id()) disabled @endif
                        class="focus:outline-none"
                    >
                        <x-badge :variant="$user->is_active ? 'success' : 'danger'" :dot="true">
                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </x-badge>
                    </button>
                </td>

                <!-- Last Login -->
                <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-400">
                    @if ($user->last_login_at)
                        <p class="font-medium text-slate-700 dark:text-slate-300">{{ $user->last_login_at->diffForHumans() }}</p>
                        <p class="text-[11px] text-slate-400">IP: {{ $user->last_login_ip ?? '-' }}</p>
                    @else
                        <span class="text-slate-400 italic">Belum pernah</span>
                    @endif
                </td>

                <!-- Action Buttons (Global Action Component) -->
                <x-table.td align="right">
                    <x-table.actions>
                        <!-- Impersonate Button (Strictly Super Admin only, not self, not other super admins) -->
                        @if (Auth::user()->isSuperAdmin() && Auth::id() !== $user->id && !$user->isSuperAdmin())
                            <x-action-button
                                type="impersonate"
                                @click="
                                    $wire.impersonateUserId = {{ $user->id }};
                                    $wire.impersonateUserName = '{{ addslashes($user->name) }}';
                                    $wire.impersonateUserRole = '{{ addslashes($user->roles->pluck('name')->implode(', ')) }}';
                                    $dispatch('open-modal', 'confirm-impersonate');
                                "
                            />
                        @endif

                        @can('users.edit')
                            <x-action-button
                                type="edit"
                                wire:click="openEditModal({{ $user->id }})"
                            />
                        @endcan

                        @can('users.delete')
                            @if ($user->id !== Auth::id())
                                <x-action-button
                                    type="delete"
                                    @click="
                                        $wire.userToDeleteId = {{ $user->id }};
                                        $wire.userToDeleteName = '{{ addslashes($user->name) }}';
                                        $dispatch('open-modal', 'confirm-delete');
                                    "
                                />
                            @endif
                        @endcan
                    </x-table.actions>
                </x-table.td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                    Tidak ada pengguna yang sesuai dengan pencarian Anda.
                </td>
            </tr>
        @endforelse

        <x-slot:pagination>
            {{ $users->links() }}
        </x-slot:pagination>
    </x-table>

    <!-- Create / Edit User Modal -->
    <x-modal name="user-form" wire:model="showModal" :title="$isEditMode ? 'Edit Pengguna' : 'Tambah Pengguna Baru'" maxWidth="2xl">
        <form wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Name -->
                <x-form.input
                    label="Nama Lengkap"
                    wire:model.live.debounce.300ms="name"
                    placeholder="Contoh: Budi Santoso"
                    required
                />

                <!-- Email -->
                <x-form.input
                    label="Alamat Email"
                    type="email"
                    wire:model.live.debounce.300ms="email"
                    placeholder="nama@email.com"
                    required
                />

                <!-- Phone -->
                <x-form.input
                    label="Nomor WhatsApp / HP"
                    wire:model.live.debounce.300ms="phone"
                    placeholder="081234567890"
                    hint="Format: 08xxxxxxxxxx"
                />

                <!-- Multi-Role Selection (Compact Pill Tags) -->
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Peran (Role) Pengguna <span class="text-rose-500 font-bold">*</span>
                        <span class="text-[11px] font-normal text-slate-400 lowercase">(Bisa pilih lebih dari satu peran)</span>
                    </label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($roles as $r)
                            @php $rName = is_array($r) ? ($r['name'] ?? reset($r)) : (is_object($r) ? ($r->name ?? (string)$r) : (string)$r); @endphp
                            <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold transition-all duration-150 cursor-pointer select-none bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700/80 has-[:checked]:bg-primary-600 has-[:checked]:hover:bg-primary-700 has-[:checked]:text-white has-[:checked]:border-primary-600 has-[:checked]:shadow-xs has-[:checked]:ring-2 has-[:checked]:ring-primary-500/20">
                                <input
                                    type="checkbox"
                                    value="{{ $rName }}"
                                    wire:model="selectedRoles"
                                    @checked(in_array($rName, $selectedRoles))
                                    class="peer sr-only"
                                />
                                <svg class="hidden peer-checked:block w-3.5 h-3.5 text-white shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="block peer-checked:hidden w-1.5 h-1.5 rounded-full bg-slate-400 dark:bg-slate-500 shrink-0"></span>
                                <span>{{ $rName }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('selectedRoles')
                        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <x-form.input
                    label="Kata Sandi"
                    type="password"
                    wire:model.live.debounce.300ms="password"
                    :placeholder="$isEditMode ? 'Kosongkan jika tidak ingin mengubah' : 'Minimal 6 karakter'"
                    :required="!$isEditMode"
                />

                <!-- Password Confirmation -->
                <x-form.input
                    label="Konfirmasi Kata Sandi"
                    type="password"
                    wire:model.live.debounce.300ms="password_confirmation"
                    placeholder="Ulangi kata sandi"
                    :required="!$isEditMode"
                />

                <!-- Active Toggle -->
                <div class="sm:col-span-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <x-form.toggle
                        wire:model="is_active"
                        label="Status Akun Aktif"
                        description="Pengguna aktif dapat masuk dan menggunakan sistem"
                    />
                </div>
            </div>

            <x-slot:footer>
                <x-button type="button" variant="outline" @click="show = false">
                    Batal
                </x-button>
                <x-button type="button" wire:click="save" variant="primary" loading="save">
                    {{ $isEditMode ? 'Simpan Perubahan' : 'Buat Pengguna' }}
                </x-button>
            </x-slot:footer>
        </form>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirm-delete" wire:model="showDeleteModal" title="Konfirmasi Hapus Pengguna" maxWidth="sm">
        <div class="text-center sm:text-left">
            <p class="text-sm text-slate-600 dark:text-slate-300">
                Apakah Anda yakin ingin menghapus akun pengguna <strong>{{ $userToDeleteName }}</strong>?
            </p>
            <p class="text-xs text-rose-600 dark:text-rose-400 mt-2 font-medium">
                ⚠️ Tindakan ini permanen dan tidak dapat dibatalkan.
            </p>
        </div>

        <x-slot:footer>
            <x-button type="button" variant="outline" @click="show = false">
                Batal
            </x-button>
            <x-button type="button" variant="danger" wire:click="deleteUser" loading="deleteUser">
                Ya, Hapus
            </x-button>
        </x-slot:footer>
    </x-modal>

    <!-- Impersonate Confirmation Modal -->
    <x-modal name="confirm-impersonate" wire:model="showImpersonateModal" title="Konfirmasi Login Pengguna (Impersonasi)" maxWidth="md">
        <div class="space-y-4">
            <div class="flex items-start gap-3 p-3.5 bg-amber-50/80 dark:bg-amber-950/30 border border-amber-200/80 dark:border-amber-800/60 rounded-xl">
                <div class="w-9 h-9 rounded-lg bg-amber-500/10 flex items-center justify-center shrink-0 text-amber-600 dark:text-amber-400 mt-0.5">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-amber-800 dark:text-amber-300">Akses Masuk Sementara</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5 leading-relaxed">
                        Anda akan masuk ke dalam sistem sebagai akun pengguna ini tanpa memerlukan password mereka.
                    </p>
                </div>
            </div>

            <div class="text-sm text-slate-700 dark:text-slate-200">
                Apakah Anda yakin ingin login sementara sebagai:
                <div class="mt-2.5 p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <span class="font-bold text-slate-900 dark:text-white">{{ $impersonateUserName }}</span>
                    @if ($impersonateUserRole)
                        <span class="text-xs px-2.5 py-1 rounded-lg font-semibold bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400 border border-primary-200 dark:border-primary-800/60">
                            {{ $impersonateUserRole }}
                        </span>
                    @endif
                </div>
            </div>

            <p class="text-xs text-slate-400 dark:text-slate-500 leading-relaxed">
                💡 Anda dapat kembali ke akun Super Administrator kapan saja dengan menekan tombol <strong>"Kembali ke Super Admin"</strong> pada banner atas layar.
            </p>
        </div>

        <x-slot:footer>
            <x-button type="button" variant="outline" @click="show = false">
                Batal
            </x-button>
            <x-button type="button" variant="primary" wire:click="impersonateUser" loading="impersonateUser">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Ya, Login Sekarang
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
