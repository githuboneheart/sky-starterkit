<div>
    <!-- Filter bar -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-3 flex-1">
            <!-- Global Search Component -->
            <div class="w-full sm:w-72">
                <x-form.search
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari deskripsi, user, IP..."
                />
            </div>

            <!-- Module Filter -->
            <select
                wire:model.live="moduleFilter"
                class="rounded-xl border border-slate-300 dark:border-slate-700/80 bg-white dark:bg-slate-900 px-3.5 py-2 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition"
            >
                <option value="">Semua Modul</option>
                @foreach ($modules as $mod)
                    <option value="{{ $mod }}">{{ $mod }}</option>
                @endforeach
            </select>

            <!-- Action Filter -->
            <select
                wire:model.live="actionFilter"
                class="rounded-xl border border-slate-300 dark:border-slate-700/80 bg-white dark:bg-slate-900 px-3.5 py-2 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition"
            >
                <option value="">Semua Aksi</option>
                @foreach ($actions as $act)
                    <option value="{{ $act }}">{{ $act }}</option>
                @endforeach
            </select>
        </div>
    </div>

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
