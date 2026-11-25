@props(['stats', 'systemHealth', 'recentActivities'])

<div class="space-y-6">
    <!-- Header Section Indicator -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-slate-900 dark:bg-slate-100"></span>
                Pusat Kendali Sistem & Starterkit (Super Admin)
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Manajemen hak akses, arsitektur modul, konfigurasi gateway, dan audit log menyeluruh</p>
        </div>
        <x-badge variant="gray" :dot="true">Role: Super Admin</x-badge>
    </div>

    <!-- 4 High Impact Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <x-stat-card
            title="Total Pengguna"
            value="{{ $stats['total_users'] }}"
            trend="up"
            trendValue="Terdaftar aktif"
            variant="primary"
            description="Seluruh staf, siswa & pasien"
        />

        <x-stat-card
            title="Pengguna Aktif"
            value="{{ $stats['active_users'] }}"
            trend="up"
            trendValue="Dapat login"
            variant="success"
            description="Akun berstatus is_active = true"
        />

        <x-stat-card
            title="Role & Peran"
            value="{{ $stats['total_roles'] }}"
            trend="up"
            trendValue="Hak akses bertingkat"
            variant="primary"
            description="Role spatie/laravel-permission"
        />

        <x-stat-card
            title="Aktivitas Hari Ini"
            value="{{ $stats['recent_logs_count'] }}"
            trend="up"
            trendValue="Log audit tercatat"
            variant="warning"
            description="Aksi pengguna tercatat hari ini"
        />
    </div>

    <!-- Main Grid: Starterkit Modules (2 Cols) & Server Health (1 Col) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quick Actions Grid -->
        <div class="lg:col-span-2">
            <x-card title="Modul Inti Starterkit" subtitle="Pusat navigasi dan manajemen akses sistem">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- User Management -->
                    @can('users.view')
                        <a href="{{ route('users.index') }}" wire:navigate class="p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 hover:bg-primary-50/50 dark:hover:bg-primary-950/30 hover:border-primary-400/60 dark:hover:border-primary-700/60 transition-all duration-200 flex items-start gap-4 group">
                            <div class="w-12 h-12 rounded-2xl bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-primary-600 group-hover:text-white transition-all duration-200 shadow-xs">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 truncate">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition">Manajemen Pengguna</h4>
                                    <span class="text-slate-300 dark:text-slate-600 group-hover:translate-x-1 transition-transform">→</span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 whitespace-normal">Kelola akun staf, ganti peran, status aktif, dan fitur impersonasi.</p>
                            </div>
                        </a>
                    @endcan

                    <!-- Permission Matrix -->
                    @can('permissions.view')
                        <a href="{{ route('permissions.index') }}" wire:navigate class="p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 hover:bg-emerald-50/50 dark:hover:bg-emerald-950/30 hover:border-emerald-400/60 dark:hover:border-emerald-700/60 transition-all duration-200 flex items-start gap-4 group">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-200 shadow-xs">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                            <div class="flex-1 truncate">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition">Permission Matrix</h4>
                                    <span class="text-slate-300 dark:text-slate-600 group-hover:translate-x-1 transition-transform">→</span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 whitespace-normal">Ubah hak akses role dengan sakelar switch realtime tanpa reload.</p>
                            </div>
                        </a>
                    @endcan

                    <!-- Settings -->
                    @can('settings.view')
                        <a href="{{ route('settings.index') }}" wire:navigate class="p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 hover:bg-primary-50/50 dark:hover:bg-primary-950/30 hover:border-primary-400/60 dark:hover:border-primary-700/60 transition-all duration-200 flex items-start gap-4 group">
                            <div class="w-12 h-12 rounded-2xl bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-primary-600 group-hover:text-white transition-all duration-200 shadow-xs">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 truncate">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition">Pengaturan Sistem</h4>
                                    <span class="text-slate-300 dark:text-slate-600 group-hover:translate-x-1 transition-transform">→</span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 whitespace-normal">Kelola profil PT, logo, WhatsApp gateway, dan payment gateway.</p>
                            </div>
                        </a>
                    @endcan

                    <!-- Activity Logs -->
                    @can('activity_logs.view')
                        <a href="{{ route('activity-logs.index') }}" wire:navigate class="p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 hover:bg-amber-50/50 dark:hover:bg-amber-950/30 hover:border-amber-400/60 dark:hover:border-amber-700/60 transition-all duration-200 flex items-start gap-4 group">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all duration-200 shadow-xs">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 truncate">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition">Audit Log Aktivitas</h4>
                                    <span class="text-slate-300 dark:text-slate-600 group-hover:translate-x-1 transition-transform">→</span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 whitespace-normal">Pantau riwayat audit aksi seluruh pengguna secara transparan.</p>
                            </div>
                        </a>
                    @endcan
                </div>
            </x-card>
        </div>

        <!-- Server & Framework Status Panel -->
        <div>
            <x-card title="Spesifikasi Server" subtitle="Status lingkungan & runtime aktif">
                <div class="space-y-4 text-xs">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-slate-400 font-medium">PHP Engine</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200 px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800">{{ $systemHealth['php_version'] }}</span>
                    </div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-slate-400 font-medium">Framework</span>
                        <span class="font-extrabold text-primary-600 dark:text-primary-400 px-2 py-0.5 rounded-lg bg-primary-50 dark:bg-primary-950/60 border border-primary-200/60 dark:border-primary-800/60">
                            Laravel {{ $systemHealth['laravel_version'] }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-slate-400 font-medium">Koneksi Database</span>
                        <span class="font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            {{ $systemHealth['db_status'] }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-slate-400 font-medium">Environment</span>
                        <x-badge variant="info" size="sm">{{ strtoupper($systemHealth['app_env']) }}</x-badge>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400 font-medium">Ruang Disk Tersedia</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ $systemHealth['disk_free'] }}</span>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    <!-- Recent Audit Logs Timeline -->
    <x-card title="Riwayat Audit Aktivitas Terkini" subtitle="Catatan aksi staf dan pengguna yang baru terjadi di sistem">
        <div class="divide-y divide-slate-100 dark:divide-slate-800">
            @forelse ($recentActivities as $log)
                <div class="py-3.5 flex items-center justify-between gap-4 text-xs">
                    <div class="flex items-center gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold flex items-center justify-center shrink-0 border border-slate-200/60 dark:border-slate-700/60 shadow-2xs">
                            {{ substr($log->user_name ?? 'G', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 dark:text-white leading-tight">
                                {{ $log->description }}
                            </p>
                            <p class="text-[11px] text-slate-400 mt-0.5">
                                Pelaku: <strong class="text-slate-600 dark:text-slate-300">{{ $log->user_name ?? 'Sistem' }}</strong> &bull; Modul: {{ $log->module }} &bull; {{ $log->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    <x-badge :variant="$log->action === 'LOGIN' ? 'primary' : ($log->action === 'CREATE' ? 'success' : 'gray')" size="sm">
                        {{ $log->action }}
                    </x-badge>
                </div>
            @empty
                <div class="py-12 text-center text-xs text-slate-400">
                    Belum ada riwayat aktivitas yang tercatat.
                </div>
            @endforelse
        </div>
    </x-card>
</div>
