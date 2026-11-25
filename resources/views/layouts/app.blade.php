<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full {{ request()->cookie('theme') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? setting('app_name', 'SKY Starterkit') }} - {{ setting('company_short_name', 'SKY Studio') }}</title>

    <!-- Dynamic Favicon Component -->
    <x-favicon />

    <!-- Anti-flicker Dark Mode Script & Livewire wire:navigate Persistence Hook -->
    <script>
        function applyTheme() {
            const isDark = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (isDark) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        applyTheme();

        // Preserve dark mode across Livewire wire:navigate transitions
        document.addEventListener('livewire:navigating', applyTheme);
        document.addEventListener('livewire:navigated', applyTheme);

        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.theme = isDark ? 'dark' : 'light';
            document.cookie = 'theme=' + (isDark ? 'dark' : 'light') + ';path=/;max-age=31536000;SameSite=Lax';
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { dark: isDark } }));
        }

        window.addEventListener('app-settings-updated', (e) => {
            if (e.detail && e.detail.app_name) {
                const shortName = e.detail.company_short_name || '';
                document.title = e.detail.app_name + (shortName ? ' - ' + shortName : '');
            }
            if (e.detail && e.detail.favicon) {
                let icon = document.querySelector('link[rel="icon"]');
                if (icon) icon.href = e.detail.favicon;
            }
        });
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Vite Assets & Livewire -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body
    x-data="{
        darkMode: document.documentElement.classList.contains('dark'),
        init() {
            window.addEventListener('theme-changed', (e) => {
                this.darkMode = e.detail.dark;
            });
            document.addEventListener('livewire:navigated', () => {
                this.darkMode = document.documentElement.classList.contains('dark');
            });
        },
        toggleDarkMode() {
            toggleTheme();
        },
        sidebarOpen: false,
        sidebarCollapsed: localStorage.getItem('sidebar_collapsed') === 'true',
        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            localStorage.setItem('sidebar_collapsed', this.sidebarCollapsed);
        }
    }"
    class="h-full font-sans antialiased bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-200"
>
    <div class="min-h-full flex">
        <!-- Sidebar Backdrop (Mobile) -->
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"
            @click="sidebarOpen = false"
            style="display: none;"
        ></div>

        <!-- Sidebar Component -->
        @include('layouts.partials.sidebar')

        <!-- Main Content Area -->
        <div
            class="flex-1 flex flex-col min-w-0 transition-all duration-300"
            :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-64'"
        >
            <!-- Impersonation Alert Banner (Properly offset from fixed sidebar) -->
            @if (is_impersonating())
                <div class="sticky top-0 z-40 bg-gradient-to-r from-amber-500 via-orange-500 to-rose-600 text-white px-4 sm:px-6 lg:px-8 py-2.5 shadow-md border-b border-white/10">
                    <div class="flex flex-wrap items-center justify-between gap-3 text-xs sm:text-sm font-medium">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="inline-block animate-pulse text-base shrink-0">⚠️</span>
                            <span class="break-words sm:truncate">
                                Mode Impersonasi: Anda sedang masuk sebagai <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->roles->pluck('name')->implode(', ') }}).
                            </span>
                        </div>
                        <form action="{{ route('impersonate.leave') }}" method="POST" class="inline shrink-0">
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white text-slate-900 rounded-xl font-bold text-xs hover:bg-slate-100 shadow-sm transition active:scale-95 cursor-pointer"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Kembali ke Super Admin
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Top Navbar -->
            @include('layouts.partials.navbar')

            <!-- Page Header / Breadcrumbs -->
            @if (isset($header))
                <header class="bg-white dark:bg-slate-900 border-b border-slate-200/80 dark:border-slate-800/80 px-6 py-4.5 transition-colors">
                    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Main Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>

            <!-- Global Footer -->
            <footer class="bg-white dark:bg-slate-900 border-t border-slate-200/80 dark:border-slate-800/80 px-6 py-4 transition-colors">
                <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-500 dark:text-slate-400">
                    <p>&copy; {{ date('Y') }} {{ setting('company_name', 'SKY Technology') }}. All rights reserved.</p>
                    <p class="flex items-center gap-2">
                        <span>Powered by <strong>Laravel 13</strong></span>
                        <span>&bull;</span>
                        <span class="inline-flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Livewire 4 & Alpine.js
                        </span>
                    </p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Floating Global Toast Notifications -->
    <x-toast />

    @livewireScripts

    <!-- Flash Session Message to Toast Trigger -->
    @php
        $flashType = session('success') ? 'success' : (session('error') ? 'error' : (session('info') ? 'info' : (session('warning') ? 'warning' : null)));
        $flashMsg = session('success') ?? session('error') ?? session('info') ?? session('warning');
    @endphp
    @if ($flashType && $flashMsg)
        <script>
            (function() {
                const notify = () => {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: { type: @json($flashType), message: @json($flashMsg) }
                    }));
                };
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', notify, { once: true });
                } else {
                    notify();
                }
            })();
        </script>
    @endif
</body>
</html>
