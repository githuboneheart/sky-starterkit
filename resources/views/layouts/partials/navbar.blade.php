<header class="sticky top-0 z-30 flex h-16 shrink-0 items-center gap-x-4 border-b border-slate-200/80 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md px-4 sm:px-6 lg:px-8 transition-colors">
    <!-- Sidebar Toggle (Mobile) -->
    <button
        type="button"
        class="lg:hidden -m-2.5 p-2.5 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition"
        @click="sidebarOpen = true"
    >
        <span class="sr-only">Buka Sidebar</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Sidebar Collapse Toggle (Desktop) -->
    <button
        type="button"
        class="hidden lg:flex p-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition border border-transparent hover:border-slate-200 dark:hover:border-slate-700"
        @click="toggleSidebar()"
        :title="sidebarCollapsed ? 'Perluas Sidebar' : 'Ciutkan Sidebar'"
    >
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h7" />
        </svg>
    </button>

    <!-- App / Company Status Tag -->
    <div
        class="hidden sm:flex items-center gap-2.5 px-3 py-1.5 rounded-full bg-slate-100/80 dark:bg-slate-800/60 border border-slate-200/60 dark:border-slate-700/60 text-xs"
        x-data="{
            companyName: @js(setting('company_name', 'SKY Technology Indonesia')),
            companyShortName: @js(setting('company_short_name', 'SKY Studio'))
        }"
        @app-settings-updated.window="
            if ($event.detail.company_name) companyName = $event.detail.company_name;
            if ($event.detail.company_short_name) companyShortName = $event.detail.company_short_name;
        "
    >
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        <span class="font-bold text-slate-800 dark:text-slate-200" x-text="companyName">{{ setting('company_name', 'SKY Technology Indonesia') }}</span>
        <span class="text-slate-300 dark:text-slate-600">&bull;</span>
        <span class="text-slate-500 dark:text-slate-400 text-[11px] font-medium" x-text="companyShortName">{{ setting('company_short_name', 'SKY Studio') }}</span>
    </div>

    <!-- Right Side Actions -->
    <div class="flex flex-1 items-center justify-end gap-x-3 sm:gap-x-4">
        <!-- Dark / Light Mode Switcher Button -->
        <button
            type="button"
            onclick="toggleTheme()"
            class="relative p-2.5 rounded-xl text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200/70 dark:border-slate-800 transition duration-150 active:scale-95 shadow-2xs cursor-pointer"
            title="Beralih Tema (Dark / Light Mode)"
        >
            <span class="sr-only">Toggle Theme</span>
            <!-- Sun Icon (shown in dark mode) -->
            <svg class="w-4 h-4 text-amber-400 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <!-- Moon Icon (shown in light mode) -->
            <svg class="w-4 h-4 text-slate-600 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>

        <!-- User Dropdown Menu -->
        <div class="relative" x-data="{ open: false }">
            <button
                type="button"
                @click="open = !open"
                @click.outside="open = false"
                class="flex items-center gap-2.5 p-1.5 rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-800 border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition"
            >
                <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-xl object-cover border border-slate-200 dark:border-slate-700 shadow-2xs" />
                <div class="hidden md:block text-left text-xs">
                    <span class="block font-bold text-slate-800 dark:text-slate-200 leading-tight">
                        {{ Auth::user()->name }}
                    </span>
                    <span class="block text-[10px] text-slate-400 dark:text-slate-500 font-medium">
                        {{ Auth::user()->roles->first()?->name ?? 'User' }}
                    </span>
                </div>
                <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown Panel -->
            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 z-50 mt-2 w-60 origin-top-right rounded-2xl bg-white dark:bg-slate-900 py-2 shadow-2xl border border-slate-200/80 dark:border-slate-800 focus:outline-none"
                style="display: none;"
            >
                <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800/80">
                    <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate">{{ Auth::user()->email }}</p>
                    <div class="mt-2 flex items-center gap-1.5">
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-md bg-primary-50 text-primary-700 dark:bg-primary-950/60 dark:text-primary-300 border border-primary-200/60 dark:border-primary-800/60">
                            👑 {{ Auth::user()->roles->first()?->name ?? 'Staff' }}
                        </span>
                    </div>
                </div>

                <div class="py-1.5">
                    <a
                        href="{{ route('profile.edit') }}"
                        wire:navigate
                        class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/60 transition"
                    >
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profil & Kata Sandi
                    </a>

                    @can('settings.view')
                        <a
                            href="{{ route('settings.index') }}"
                            wire:navigate
                            class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/60 transition"
                        >
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Pengaturan Sistem
                        </a>
                    @endcan
                </div>

                <div class="border-t border-slate-100 dark:border-slate-800/80 pt-1.5">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="flex w-full items-center gap-2.5 px-4 py-2 text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar dari Sistem
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
