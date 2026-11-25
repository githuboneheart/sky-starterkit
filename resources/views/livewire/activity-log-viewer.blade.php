<div>
    <!-- Modern Unified Toolbar (Search & Filters) -->
    <x-toolbar>
        <x-slot:filters>
            <!-- Global Search Component -->
            <div class="w-full sm:w-72">
                <x-form.search
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari deskripsi, user, IP..."
                />
            </div>

            <!-- Module Filter -->
            <x-form.select-filter
                wire:model.live="moduleFilter"
                :active="!empty($moduleFilter)"
            >
                <option value="">Semua Modul</option>
                @foreach ($modules as $mod)
                    <option value="{{ $mod }}">{{ $mod }}</option>
                @endforeach
            </x-form.select-filter>

            <!-- Action Filter -->
            <x-form.select-filter
                wire:model.live="actionFilter"
                :active="!empty($actionFilter)"
            >
                <option value="">Semua Aksi</option>
                @foreach ($actions as $act)
                    <option value="{{ $act }}">{{ $act }}</option>
                @endforeach
            </x-form.select-filter>

            <!-- Reset Filter Button -->
            @if ($this->hasActiveFilters)
                <button
                    type="button"
                    wire:click="resetFilters"
                    class="h-10 inline-flex items-center gap-1.5 px-3 rounded-xl text-xs font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/40 dark:hover:bg-rose-900/50 border border-rose-200/60 dark:border-rose-900/40 transition duration-150 cursor-pointer"
                    title="Reset semua filter"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Reset</span>
                </button>
            @endif
        </x-slot:filters>
    </x-toolbar>

    <!-- Activity Log Table -->
    <x-table>
        <x-slot:head>
            <th class="px-6 py-3.5">Waktu</th>
            <th class="px-6 py-3.5">Pengguna</th>
            <th class="px-6 py-3.5">Aksi & Modul</th>
            <th class="px-6 py-3.5">Deskripsi Aktivitas</th>
            <th class="px-6 py-3.5 text-right">IP & User Agent</th>
        </x-slot:head>

        @forelse ($logs as $log)
            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors text-xs">
                <!-- Time -->
                <td class="px-6 py-3.5 whitespace-nowrap text-slate-500 dark:text-slate-400">
                    <p class="font-medium text-slate-700 dark:text-slate-300">{{ $log->created_at->format('d M Y') }}</p>
                    <p class="text-[11px] text-slate-400">{{ $log->created_at->format('H:i:s') }} ({{ $log->created_at->diffForHumans() }})</p>
                </td>

                <!-- User -->
                <td class="px-6 py-3.5 whitespace-nowrap">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-[10px]">
                            {{ substr($log->user_name ?? 'G', 0, 1) }}
                        </div>
                        <span class="font-semibold text-slate-900 dark:text-white">{{ $log->user_name ?? 'Guest / System' }}</span>
                    </div>
                </td>

                <!-- Action & Module -->
                <td class="px-6 py-3.5 whitespace-nowrap">
                    @php
                        $actionVariant = match($log->action) {
                            'CREATE' => 'success',
                            'UPDATE' => 'info',
                            'DELETE' => 'danger',
                            'LOGIN' => 'primary',
                            'LOGOUT' => 'gray',
                            'IMPERSONATE', 'LEAVE_IMPERSONATE' => 'warning',
                            default => 'gray',
                        };
                    @endphp
                    <div class="flex items-center gap-1.5">
                        <x-badge :variant="$actionVariant" size="sm">{{ $log->action }}</x-badge>
                        <span class="text-slate-400">/</span>
                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ $log->module }}</span>
                    </div>
                </td>

                <!-- Description -->
                <td class="px-6 py-3.5 text-slate-700 dark:text-slate-300 font-medium">
                    {{ $log->description }}
                </td>

                <!-- IP & User Agent -->
                <td class="px-6 py-3.5 text-right whitespace-nowrap text-slate-400">
                    <p class="font-mono text-[11px]">{{ $log->ip_address ?? '-' }}</p>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                    Tidak ada catatan aktivitas yang cocok.
                </td>
            </tr>
        @endforelse

        <x-slot:pagination>
            {{ $logs->links() }}
        </x-slot:pagination>
    </x-table>
</div>
