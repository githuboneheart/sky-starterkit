<aside
    class="fixed inset-y-0 left-0 z-50 flex flex-col bg-white dark:bg-slate-900/95 backdrop-blur-xl border-r border-slate-200/80 dark:border-slate-800/80 transition-all duration-300 shadow-xl shadow-slate-900/5"
    :class="{
        'w-64 translate-x-0': !sidebarCollapsed && sidebarOpen,
        '-translate-x-full lg:translate-x-0': !sidebarOpen,
        'lg:w-20': sidebarCollapsed,
        'lg:w-64': !sidebarCollapsed
    }"
>
    <!-- Brand / Logo Header Area -->
    <div class="h-16 flex items-center px-5 border-b border-slate-100 dark:border-slate-800/80 justify-between">
        <a
            href="{{ route('dashboard') }}"
            wire:navigate
            class="flex items-center gap-3 overflow-hidden group"
            x-data="{
                appName: @js(setting('app_name', 'SKY Starterkit')),
                companyShortName: @js(setting('company_short_name', 'Laravel 13 Starterkit')),
                logoLight: @js(setting('app_logo_light') ? Storage::url(setting('app_logo_light')) : null),
                logoDark: @js((setting('app_logo_dark') ?? setting('app_logo_light')) ? Storage::url(setting('app_logo_dark') ?? setting('app_logo_light')) : null)
            }"
            @app-settings-updated.window="
                if ($event.detail.app_name) appName = $event.detail.app_name;
                if ($event.detail.company_short_name) companyShortName = $event.detail.company_short_name;
                if ($event.detail.logo_light !== undefined) logoLight = $event.detail.logo_light;
                if ($event.detail.logo_dark !== undefined) logoDark = $event.detail.logo_dark;
            "
        >
            <template x-if="logoLight">
                <div class="shrink-0 flex items-center">
                    <img :src="logoLight" alt="Logo" class="h-9 w-auto dark:hidden" />
                    <img :src="logoDark || logoLight" alt="Logo" class="h-9 w-auto hidden dark:block" />
                </div>
            </template>
            <template x-if="!logoLight">
                <div class="w-10 h-10 rounded-2xl bg-primary-600 text-white flex items-center justify-center font-extrabold text-lg shadow-md shadow-primary-500/25 shrink-0 group-hover:scale-105 transition-transform duration-200 ring-1 ring-white/20">
                    <span x-text="(appName || 'S').charAt(0)">{{ substr(setting('app_name', 'S'), 0, 1) }}</span>
                </div>
            </template>

            <div class="truncate transition-opacity duration-200" x-show="!sidebarCollapsed" x-transition>
                <span class="block font-extrabold text-slate-900 dark:text-white text-sm leading-tight tracking-tight truncate" x-text="appName">
                    {{ setting('app_name', 'SKY Starterkit') }}
                </span>
                <span class="block text-[11px] font-semibold text-primary-600 dark:text-primary-400 truncate tracking-wide" x-text="companyShortName">
                    {{ setting('company_short_name', 'Laravel 13 Starterkit') }}
                </span>
            </div>
        </a>

        <!-- Mobile Drawer Close Button -->
        <button
            @click="sidebarOpen = false"
            class="lg:hidden p-1.5 rounded-xl text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
        >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation Scrollable Area -->
    <div class="flex-1 overflow-y-auto px-3.5 py-4 space-y-6 scrollbar-thin">
        @php
            $navigation = config('navigation', []);
            $user = Auth::user();
        @endphp

        @foreach ($navigation as $groupName => $items)
            @php
                // Filter items by permission (strictly follows permission list)
                $visibleItems = array_filter($items, function ($item) use ($user) {
                    if (empty($item['permission'])) {
                        return true;
                    }
                    return $user && $user->can($item['permission']);
                });
            @endphp

            @if (count($visibleItems) > 0)
                <div>
                    <p
                        class="px-3 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 transition-opacity flex items-center gap-2"
                        x-show="!sidebarCollapsed"
                    >
                        <span>{{ $groupName }}</span>
                        <span class="flex-1 h-px bg-slate-100 dark:bg-slate-800"></span>
                    </p>
                    <nav class="space-y-1">
                        @foreach ($visibleItems as $item)
                            @php
                                $isActive = request()->routeIs($item['active'] ?? $item['route']);
                            @endphp
                            <a
                                href="{{ route($item['route']) }}"
                                wire:navigate
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-semibold transition-all duration-150 active:scale-[0.98] group {{ $isActive ? 'bg-primary-600 text-white shadow-md shadow-primary-500/25 ring-1 ring-primary-500/50' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-slate-200' }}"
                                :title="sidebarCollapsed ? '{{ addslashes($item['title']) }}' : ''"
                            >
                                <div class="w-5 h-5 shrink-0 flex items-center justify-center {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors' }}">
                                    @switch($item['icon'] ?? '')
                                        @case('home')
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            @break
                                        @case('users')
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            @break
                                        @case('shield')
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            @break
                                        @case('matrix')
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                            </svg>
                                            @break
                                        @case('cog')
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            @break
                                        @case('clock')
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            @break
                                        @default
                                            @if (!empty($item['svg']))
                                                {!! $item['svg'] !!}
                                            @else
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h7" />
                                                </svg>
                                            @endif
                                    @endswitch
                                </div>
                                <span class="truncate" x-show="!sidebarCollapsed">{{ $item['title'] }}</span>
                                @if (!empty($item['badge']))
                                    <span x-show="!sidebarCollapsed" class="ml-auto text-[9px] font-extrabold uppercase px-1.5 py-0.5 rounded-md bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                                        {{ $item['badge']['text'] }}
                                    </span>
                                @endif
                            </a>
                        @endforeach
                    </nav>
                </div>
            @endif
        @endforeach
    </div>

    <!-- User Account Mini Bottom Box -->
    <div class="p-3 border-t border-slate-100 dark:border-slate-800/80 bg-slate-50/70 dark:bg-slate-950/60">
        <a href="{{ route('profile.edit') }}" wire:navigate class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-white dark:hover:bg-slate-900 transition-colors group">
            <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-9 h-9 rounded-xl object-cover shrink-0 border border-slate-200 dark:border-slate-700 shadow-xs" />
            <div class="truncate" x-show="!sidebarCollapsed">
                <p class="text-xs font-bold text-slate-800 dark:text-slate-200 truncate group-hover:text-primary-600 dark:group-hover:text-primary-400 transition">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-[10px] text-slate-400 dark:text-slate-500 truncate flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    {{ Auth::user()->roles->first()?->name ?? 'User' }}
                </p>
            </div>
        </a>
    </div>
</aside>
