<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full {{ request()->cookie('theme') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') &bull; {{ setting('app_name', 'SKY Starterkit') }}</title>

    <!-- Dynamic Favicon Component -->
    <x-favicon />

    <!-- Anti-flicker Dark Mode Script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            localStorage.theme = isDark ? 'dark' : 'light';
            document.cookie = 'theme=' + (isDark ? 'dark' : 'light') + ';path=/;max-age=31536000;SameSite=Lax';
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
    </style>
</head>
<body class="min-h-full bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 flex flex-col justify-between transition-colors duration-200 relative overflow-x-hidden selection:bg-primary-500 selection:text-white">
    <!-- Background Glow Blobs -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-primary-500/10 dark:bg-primary-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-primary-600/10 dark:bg-primary-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Header Navigation -->
    <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between relative z-10">
        <!-- Logo & Brand (Global Dynamic Component) -->
        <a href="{{ auth()->check() ? route('dashboard') : url('/') }}">
            <x-brand-logo size="md" />
        </a>

        <!-- Dark Mode Toggle Button -->
        <button
            type="button"
            onclick="toggleTheme()"
            class="p-2 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white shadow-2xs backdrop-blur-md transition-all active:scale-95"
            title="Ganti Mode Tampilan"
            aria-label="Ganti Mode Tampilan"
        >
            <!-- Sun Icon (shown in dark mode) -->
            <svg class="w-4 h-4 hidden dark:block text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <!-- Moon Icon (shown in light mode) -->
            <svg class="w-4 h-4 block dark:hidden text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-8 relative z-10">
        <div class="w-full max-w-lg text-center">
            <!-- Glassmorphic Card Panel -->
            <div class="bg-white/85 dark:bg-slate-900/85 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-8 sm:p-12 shadow-xl shadow-slate-200/50 dark:shadow-none backdrop-blur-xl transition-all">
                <!-- Icon & Status Code Badge -->
                <div class="mb-6 flex flex-col items-center">
                    <div class="w-20 h-20 rounded-3xl @yield('badge-bg', 'bg-primary-50 dark:bg-primary-950/60 text-primary-600 dark:text-primary-400 border border-primary-200/60 dark:border-primary-800/60') flex items-center justify-center shadow-inner mb-4 transition-transform hover:scale-105 duration-200">
                        @yield('icon')
                    </div>

                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full @yield('badge-bg', 'bg-primary-50 dark:bg-primary-950/60 text-primary-600 dark:text-primary-400 border border-primary-200/60 dark:border-primary-800/60') text-xs font-extrabold tracking-wider">
                        <span>ERROR @yield('code')</span>
                    </div>
                </div>

                <!-- Title & Message -->
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                    @yield('title')
                </h1>

                <p class="text-sm text-slate-500 dark:text-slate-400 mt-3 leading-relaxed">
                    @yield('description')
                </p>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                    @section('actions')
                        <button
                            type="button"
                            onclick="if (window.history.length > 1) { window.history.back(); } else { window.location.href = '{{ auth()->check() ? route('dashboard') : url('/') }}'; }"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700/70 text-slate-700 dark:text-slate-200 text-xs font-bold transition-all duration-150 active:scale-95 shadow-2xs"
                        >
                            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Sebelumnya
                        </button>

                        @if (auth()->check())
                            <a
                                href="{{ route('dashboard') }}"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-xs font-bold shadow-md shadow-primary-500/20 transition-all duration-150 active:scale-95"
                            >
                                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Ke Dashboard Utama
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-xs font-bold shadow-md shadow-primary-500/20 transition-all duration-150 active:scale-95"
                            >
                                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Masuk ke Akun
                            </a>
                        @endif
                    @show
                </div>
            </div>

            <!-- Hint text under card -->
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-4">
                Butuh bantuan teknis? Hubungi tim IT Support di
                <a href="mailto:{{ setting('company_email', 'it@starterkit.test') }}" class="underline hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
                    {{ setting('company_email', 'it@starterkit.test') }}
                </a>
            </p>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-6 text-center text-xs text-slate-400 dark:text-slate-500 relative z-10">
        &copy; {{ date('Y') }} {{ setting('company_name', 'SKY Technology Indonesia') }} &bull; Seluruh Hak Cipta Dilindungi
    </footer>
</body>
</html>
