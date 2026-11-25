<div>
    <!-- Top Bar: Role Selector Tabs & Quick Search -->
    <div class="mb-6 space-y-4">
        <!-- Role Pills / Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none max-w-full"
            x-data="{ activeRoleId: {{ $selectedRoleId }} }"
            x-effect="activeRoleId = {{ $selectedRoleId }}"
        >
            @foreach ($roles as $role)
                <button
                    type="button"
                    wire:key="role-tab-{{ $role->id }}"
                    @click="activeRoleId = {{ $role->id }}; $wire.selectRole({{ $role->id }})"
                    :class="activeRoleId === {{ $role->id }}
                        ? 'bg-primary-600 text-white shadow-sm shadow-primary-500/25 ring-2 ring-primary-600/30 ring-offset-2 dark:ring-offset-slate-900'
                        : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200/80 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800'"
                    class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-150 flex items-center gap-2 select-none cursor-pointer"
                >
                    <span>{{ $role->name }}</span>
                    @if ($role->name === 'Super Admin')
                        <span class="text-[10px] px-1.5 py-0.2 bg-white/20 text-white rounded font-bold">Semua Izin</span>
                    @else
                        <span
                            :class="activeRoleId === {{ $role->id }} ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400'"
                            class="text-[10px] px-1.5 py-0.2 rounded font-bold transition-colors"
                        >
                            {{ $role->permissions_count }}
                        </span>
                    @endif
                </button>
            @endforeach
        </div>

        <!-- Role Overview Banner & Search & Primary Action -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-4 sm:p-5 flex flex-col lg:flex-row lg:items-center justify-between gap-4 shadow-xs">
            <div>
                <div class="flex items-center gap-2.5">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">
                        Matriks Izin: <span class="text-primary-600 dark:text-primary-400">{{ $currentRole?->name }}</span>
                    </h3>
                    @if ($currentRole?->name === 'Super Admin')
                        <x-badge variant="primary" size="sm">Seluruh Izin Aktif</x-badge>
                    @endif
                    <div wire:loading wire:target="selectRole" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-primary-50 dark:bg-primary-950/60 text-primary-600 dark:text-primary-400 text-[11px] font-medium animate-pulse">
                        <svg class="animate-spin h-3 w-3 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memuat data...
                    </div>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Aktifkan atau nonaktifkan hak akses untuk role ini. Perubahan langsung tersimpan otomatis ke database.
                </p>
            </div>

            <!-- Controls: Search & Primary Action Button (Global Component Driven) -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <!-- Search Permissions (Global Search Component) -->
                <div class="w-full sm:w-64">
                    <x-form.search
                        wire:model.live.debounce.250ms="search"
                        placeholder="Filter nama permission..."
                    />
                </div>

                <!-- Primary Action Button (Global Template Standard) -->
                @can('permissions.manage')
                    <x-button
                        type="button"
                        @click="$dispatch('open-modal', 'create-permission-modal'); $wire.openCreatePermissionModal()"
                        variant="primary"
                        class="shrink-0"
                    >
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Permission Baru
                    </x-button>
                @endcan
            </div>
        </div>
    </div>

    <!-- Super Admin Notice -->
    @if ($currentRole?->name === 'Super Admin')
        <div class="mb-6 p-4 rounded-2xl bg-primary-50/80 dark:bg-primary-950/50 border border-primary-200/80 dark:border-primary-800/80 text-xs text-primary-900 dark:text-primary-200 flex items-center gap-3.5 shadow-2xs">
            <div class="w-8 h-8 rounded-xl bg-primary-600/10 dark:bg-primary-400/10 text-primary-600 dark:text-primary-400 flex items-center justify-center shrink-0 border border-primary-200 dark:border-primary-800">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <div class="leading-relaxed">
                <strong class="font-bold text-slate-900 dark:text-white">Informasi Super Administrator:</strong> Role Super Admin memiliki wewenang penuh tanpa batas <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold tracking-wide uppercase bg-primary-100 dark:bg-primary-900/60 text-primary-700 dark:text-primary-300 border border-primary-200 dark:border-primary-700/60">Full Authority</span>. Seluruh hak akses di bawah otomatis berlaku dan diproteksi dari pencabutan.
            </div>
        </div>
    @endif

    <!-- Grouped Permissions List Cards -->
    <div class="space-y-6 transition-opacity duration-150" wire:loading.class="opacity-60 pointer-events-none" wire:target="selectRole">
        @forelse ($groupedPermissions as $groupName => $permissions)
            @php
                $groupPermNames = array_map(fn($p) => $p->name, $permissions);
                $activeCountInGroup = count(array_intersect($groupPermNames, $rolePermissions));
                $totalInGroup = count($permissions);
                $isAllSelected = $activeCountInGroup === $totalInGroup;
            @endphp

            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl overflow-hidden shadow-xs">
                <!-- Group Header -->
                <div class="px-6 py-4 bg-slate-50/70 dark:bg-slate-950/50 border-b border-slate-100 dark:border-slate-800/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-2.5 h-2.5 rounded-full {{ $activeCountInGroup > 0 ? 'bg-primary-600' : 'bg-slate-300 dark:bg-slate-700' }}"></div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">
                                {{ $groupName }}
                            </h4>
                            <p class="text-[11px] text-slate-400 dark:text-slate-500">
                                {{ $activeCountInGroup }} dari {{ $totalInGroup }} izin aktif
                            </p>
                        </div>
                    </div>

                    @if ($currentRole?->name !== 'Super Admin')
                        <!-- Bulk Select / Deselect in Group -->
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                wire:click="selectAllInGroup(@js($groupPermNames))"
                                class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-100 dark:bg-primary-950/60 dark:text-primary-300 dark:hover:bg-primary-900 transition"
                            >
                                Pilih Semua
                            </button>
                            <button
                                type="button"
                                wire:click="deselectAllInGroup(@js($groupPermNames))"
                                class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 transition"
                            >
                                Batal Semua
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Group Items Grid -->
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
                    @foreach ($permissions as $perm)
                        @php
                            $isChecked = $currentRole?->name === 'Super Admin' || in_array($perm->name, $rolePermissions);
                        @endphp

                        <div
                            wire:key="perm-{{ $perm->id }}"
                            wire:click="{{ $currentRole?->name !== 'Super Admin' ? "togglePermission('{$perm->name}')" : '' }}"
                            class="flex items-center justify-between p-3 rounded-xl border transition-all duration-150 {{ $isChecked ? 'bg-primary-50/40 dark:bg-primary-950/20 border-primary-200 dark:border-primary-800/80 shadow-xs' : 'bg-slate-50/50 dark:bg-slate-900 border-slate-200/70 dark:border-slate-800/60 hover:border-slate-300 dark:hover:border-slate-700' }} {{ $currentRole?->name !== 'Super Admin' ? 'cursor-pointer active:scale-[0.99]' : 'cursor-default' }}"
                        >
                            <div class="truncate pr-3">
                                <span class="block text-xs font-semibold text-slate-800 dark:text-slate-200 truncate">
                                    {{ $perm->name }}
                                </span>
                                <span class="block text-[11px] text-slate-400 dark:text-slate-500 truncate">
                                    Guard: {{ $perm->guard_name }}
                                </span>
                            </div>

                            <!-- Modern Switch Indicator -->
                            <div class="relative shrink-0 pointer-events-none">
                                <div class="w-9 h-5 rounded-full transition-colors duration-200 {{ $isChecked ? 'bg-primary-600' : 'bg-slate-200 dark:bg-slate-700' }}"></div>
                                <div class="absolute left-0.5 top-0.5 w-4 h-4 rounded-full bg-white shadow-xs transform transition-transform duration-200 {{ $isChecked ? 'translate-x-4' : 'translate-x-0' }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-12 text-center text-slate-400">
                Tidak ada permission yang sesuai dengan kata kunci pencarian "{{ $search }}".
            </div>
        @endforelse
    </div>

    <!-- Create Permission Modal -->
    <x-modal name="create-permission-modal" wire:model="showCreateModal" title="Tambah Permission Baru">
        <form wire:submit="createPermission" class="space-y-4">
            <x-form.input
                label="Nama Permission (Dot-Notation)"
                wire:model.live.debounce.300ms="newPermissionName"
                placeholder="Contoh: medical.prescribe atau invoice.refund"
                hint="Gunakan huruf kecil dengan titik pemisah: modul.aksi"
                required
            />

            <div class="p-3 bg-amber-50 dark:bg-amber-950/40 rounded-xl border border-amber-200 dark:border-amber-800 text-xs text-amber-800 dark:text-amber-200">
                💡 Permission baru yang Anda buat otomatis langsung ditambahkan ke Super Admin dan dikelompokkan ke grup terkait.
            </div>

            <x-slot:footer>
                <x-button type="button" variant="outline" @click="show = false">
                    Batal
                </x-button>
                <x-button type="button" wire:click="createPermission" variant="primary" loading="createPermission">
                    Simpan Permission
                </x-button>
            </x-slot:footer>
        </form>
    </x-modal>
</div>
