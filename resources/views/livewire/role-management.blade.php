<div>
    <!-- Top Action Bar -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <!-- Search (Global Component) -->
        <div class="w-full sm:w-72">
            <x-form.search
                wire:model.live.debounce.300ms="search"
                placeholder="Cari nama role..."
            />
        </div>

        @can('roles.create')
            <x-button type="button" @click="$wire.showCreateModal = true; $wire.openCreateModal()" variant="primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Role Baru
            </x-button>
        @endcan
    </div>

    <!-- Role Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($roles as $role)
            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-5 shadow-xs flex flex-col justify-between transition hover:shadow-md">
                <div>
                    <!-- Header -->
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl {{ $role->name === 'Super Admin' ? 'bg-primary-50 dark:bg-primary-950/60 text-primary-600 dark:text-primary-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }} flex items-center justify-center font-bold text-sm">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-base font-semibold text-slate-900 dark:text-white leading-tight">
                                    {{ $role->name }}
                                </h4>
                                <span class="text-xs text-slate-400 dark:text-slate-500">
                                    Guard: {{ $role->guard_name }}
                                </span>
                            </div>
                        </div>

                        @if ($role->name === 'Super Admin')
                            <x-badge variant="primary" size="sm">Dilindungi</x-badge>
                        @elseif (auth()->user()->can('roles.delete'))
                            <button
                                type="button"
                                @click="
                                    $wire.roleToDeleteId = {{ $role->id }};
                                    $wire.roleToDeleteName = '{{ addslashes($role->name) }}';
                                    $wire.showDeleteModal = true;
                                "
                                class="p-1 text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                                title="Hapus Role"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        @endif
                    </div>

                    <!-- Meta stats -->
                    <div class="grid grid-cols-2 gap-2 my-4 p-3 bg-slate-50/70 dark:bg-slate-950/40 rounded-xl border border-slate-100 dark:border-slate-800/60 text-xs">
                        <div>
                            <span class="block text-slate-400">Total Pengguna</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200 text-sm">{{ $role->users_count }} Orang</span>
                        </div>
                        <div>
                            <span class="block text-slate-400">Hak Akses Aktif</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200 text-sm">
                                {{ $role->name === 'Super Admin' ? 'Semua (' . $totalPermissions . ')' : $role->permissions_count . ' Izin' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800/80">
                    <a
                        href="{{ route('permissions.index', ['roleId' => $role->id]) }}"
                        wire:navigate
                        class="w-full flex items-center justify-center gap-1.5 py-2 px-3 text-xs font-semibold rounded-xl bg-slate-100 hover:bg-blue-50 dark:bg-slate-800 dark:hover:bg-blue-950/40 text-slate-700 hover:text-blue-600 dark:text-slate-300 dark:hover:text-blue-400 transition"
                    >
                        <span>Kelola Permission Matrix</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-400">
                Tidak ada peran yang cocok dengan filter pencarian.
            </div>
        @endforelse
    </div>

    <!-- Create Role Modal -->
    <x-modal wire:model="showCreateModal" title="Tambah Role Baru">
        <form wire:submit="createRole" class="space-y-4">
            <x-form.input
                label="Nama Role"
                wire:model.live.debounce.300ms="newRoleName"
                placeholder="Contoh: Manager Operasional"
                hint="Gunakan nama yang jelas mendeskripsikan peran staf"
                required
            />

            <x-slot:footer>
                <x-button type="button" variant="outline" @click="show = false">
                    Batal
                </x-button>
                <x-button type="button" wire:click="createRole" variant="primary" loading="createRole">
                    Buat Role
                </x-button>
            </x-slot:footer>
        </form>
    </x-modal>

    <!-- Delete Role Confirmation Modal -->
    <x-modal wire:model="showDeleteModal" title="Konfirmasi Hapus Role" maxWidth="sm">
        <div class="text-center sm:text-left">
            <p class="text-sm text-slate-600 dark:text-slate-300">
                Apakah Anda yakin ingin menghapus role <strong>{{ $roleToDeleteName }}</strong>?
            </p>
            <p class="text-xs text-rose-600 dark:text-rose-400 mt-2 font-medium">
                ⚠️ Pastikan tidak ada pengguna yang sedang menggunakan role ini.
            </p>
        </div>

        <x-slot:footer>
            <x-button type="button" variant="outline" @click="show = false">
                Batal
            </x-button>
            <x-button type="button" variant="danger" wire:click="deleteRole" loading="deleteRole">
                Hapus Role
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
