<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full {{ request()->cookie('theme') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <title>Masuk Portal - {{ setting('app_name', 'SKY Starterkit') }}</title>

    <!-- Dynamic Favicon Component -->
    <x-favicon />

    <!-- Anti-flicker Dark Mode Script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Global native theme toggle function (no external dependencies needed)
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

        /* Prevent Chrome & Edge autofill from forcing white background in dark mode */
        .dark input:-webkit-autofill,
        .dark input:-webkit-autofill:hover,
        .dark input:-webkit-autofill:focus,
        .dark input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #0f172a inset !important;
            box-shadow: 0 0 0 1000px #0f172a inset !important;
            -webkit-text-fill-color: #f8fafc !important;
            caret-color: #f8fafc !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="h-full bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-200">
    <!-- Top Portal Transition Bar (Activates upon form submit) -->
    <div id="portal-bar" class="fixed top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-600 via-sky-400 to-primary-600 z-50 transform -translate-x-full transition-transform duration-700 ease-out pointer-events-none"></div>

    <div class="min-h-screen lg:h-screen w-full flex flex-col lg:flex-row overflow-x-hidden lg:overflow-hidden bg-slate-50 dark:bg-slate-950">
        <!-- ========================================================= -->
        <!-- LEFT COLUMN: BRAND HERO & SHOWCASE (Desktop lg & xl)      -->
        <!-- ========================================================= -->
        <div class="relative hidden lg:flex lg:w-7/12 flex-col justify-between p-8 xl:p-14 bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 text-white border-r border-slate-800/80 overflow-hidden select-none">
            <!-- Background Futuristic Grid Pattern with Radial Mask -->
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff0a_1px,transparent_1px),linear-gradient(to_bottom,#ffffff0a_1px,transparent_1px)] bg-[size:28px_28px] [mask-image:radial-gradient(ellipse_70%_60%_at_50%_50%,#000_60%,transparent_100%)] pointer-events-none"></div>

            <!-- Atmospheric Floating Glow Orbs with Smooth Animation -->
            <div class="absolute -top-28 -left-28 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl pointer-events-none animate-float-slow"></div>
            <div class="absolute top-1/3 -right-28 w-88 h-88 bg-sky-400/15 rounded-full blur-3xl pointer-events-none animate-float-reverse"></div>
            <div class="absolute -bottom-32 left-1/4 w-96 h-96 bg-primary-700/20 rounded-full blur-3xl pointer-events-none animate-pulse-subtle"></div>

            <!-- Top Header: Brand Logo & Live Status Pill -->
            <div class="relative z-10 flex items-center justify-between">
                <x-brand-logo size="md" textClass="text-white" subtextClass="text-primary-300" />

                <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-900/80 border border-slate-700/80 text-[11px] font-semibold text-primary-300 backdrop-blur-md shadow-inner">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span>Enterprise v13.0</span>
                </div>
            </div>

            <!-- Center Content: Headline & 3 Interactive Feature Cards -->
            <div class="relative z-10 my-auto py-6 max-w-lg">
                <!-- Tagline Badge with Vector Spark Icon -->
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-500/15 border border-primary-400/30 text-primary-300 text-xs font-semibold mb-4 shadow-sm backdrop-blur-sm animate-fade-in-up">
                    <svg class="w-3.5 h-3.5 text-primary-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span>{{ setting('app_tagline', 'Modern Enterprise Laravel 13 Starterkit') }}</span>
                </div>

                <!-- Main Punchline -->
                <h1 class="text-3xl xl:text-4xl font-extrabold text-white tracking-tight leading-tight mb-3 animate-fade-in-up delay-50">
                    Fondasi Aplikasi Modern <br />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 via-sky-200 to-indigo-100">
                        {{ setting('app_name', 'SKY Starterkit') }}
                    </span>
                </h1>

                <p class="text-slate-300 text-xs xl:text-sm leading-relaxed mb-6 max-w-md animate-fade-in-up delay-75">
                    {{ setting('app_description', 'Boilerplate modular, modern, dan production-ready untuk akselerasi pengembangan aplikasi web enterprise.') }}
                </p>

                <!-- 3 Feature Interactive Cards -->
                <div class="space-y-3">
                    <!-- Feature 1: Visual RBAC -->
                    <div class="group flex items-center gap-3.5 p-3.5 rounded-2xl bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 hover:border-primary-400/40 backdrop-blur-md transition-all duration-200 hover:translate-x-1 hover:shadow-lg hover:shadow-primary-950/40 animate-fade-in-up delay-100 cursor-default">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500/20 to-primary-600/10 text-primary-300 flex items-center justify-center shrink-0 border border-primary-400/25 group-hover:scale-105 group-hover:rotate-2 transition-transform duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="truncate">
                            <h4 class="text-xs font-bold text-white group-hover:text-primary-200 transition-colors">Visual RBAC & Permission Matrix</h4>
                            <p class="text-[11px] text-slate-300/90 truncate">Manajemen multi-role, matriks izin visual realtime, & impersonasi.</p>
                        </div>
                    </div>

                    <!-- Feature 2: Enterprise Design System -->
                    <div class="group flex items-center gap-3.5 p-3.5 rounded-2xl bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 hover:border-emerald-400/40 backdrop-blur-md transition-all duration-200 hover:translate-x-1 hover:shadow-lg hover:shadow-emerald-950/40 animate-fade-in-up delay-150 cursor-default">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500/20 to-teal-600/10 text-emerald-300 flex items-center justify-center shrink-0 border border-emerald-400/25 group-hover:scale-105 group-hover:rotate-2 transition-transform duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <div class="truncate">
                            <h4 class="text-xs font-bold text-white group-hover:text-emerald-200 transition-colors">Enterprise Design System & Dark Mode</h4>
                            <p class="text-[11px] text-slate-300/90 truncate">Semantic token primary-*, micro-interactions, & 0ms modal.</p>
                        </div>
                    </div>

                    <!-- Feature 3: Centralized Gateways -->
                    <div class="group flex items-center gap-3.5 p-3.5 rounded-2xl bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 hover:border-sky-400/40 backdrop-blur-md transition-all duration-200 hover:translate-x-1 hover:shadow-lg hover:shadow-sky-950/40 animate-fade-in-up delay-200 cursor-default">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-500/20 to-blue-600/10 text-sky-300 flex items-center justify-center shrink-0 border border-sky-400/25 group-hover:scale-105 group-hover:rotate-2 transition-transform duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="truncate">
                            <h4 class="text-xs font-bold text-white group-hover:text-sky-200 transition-colors">Audit Trail & Centralized Gateways</h4>
                            <p class="text-[11px] text-slate-300/90 truncate">Logging audit aksi krusial, WhatsApp gateway, & payment gateway.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer: Trust Badges -->
            <div class="relative z-10 flex items-center justify-between text-xs text-slate-400 border-t border-white/10 pt-4">
                <span>&copy; {{ date('Y') }} {{ setting('company_name', 'SKY Technology Indonesia') }}</span>
                <div class="flex items-center gap-2">
                    <span class="flex items-center gap-1.5 text-[11px] text-emerald-400 font-medium">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        SSL 256-bit Encrypted
                    </span>
                </div>
            </div>
        </div>

        <!-- ========================================================= -->
        <!-- RIGHT COLUMN: AUTHENTICATION FORM (Mobile & Desktop)     -->
        <!-- ========================================================= -->
        <div class="relative flex-1 flex flex-col justify-between p-6 sm:p-10 xl:p-14 bg-white dark:bg-slate-950 transition-colors duration-200 overflow-y-auto">
            <!-- Mobile Ambient Glows (Hidden on Desktop) -->
            <div class="lg:hidden absolute -top-24 -left-24 w-72 h-72 bg-primary-500/10 dark:bg-primary-500/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="lg:hidden absolute top-1/2 -right-24 w-72 h-72 bg-sky-500/10 dark:bg-sky-500/15 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Top Bar: Mobile Logo & Theme Toggle -->
            <div class="relative z-10 flex items-center justify-between w-full max-w-sm sm:max-w-md mx-auto">
                <!-- Mobile Logo (Global Dynamic Component) -->
                <div class="lg:hidden">
                    <x-brand-logo size="sm" />
                </div>

                <!-- Dark / Light Mode Switcher (100% Native Pure JS, Zero Lag) -->
                <div class="ml-auto">
                    <button
                        type="button"
                        onclick="toggleTheme()"
                        class="p-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-900 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200/80 dark:border-slate-800 transition duration-150 active:scale-90 hover:rotate-12 cursor-pointer shadow-2xs"
                        title="Beralih Tema (Dark / Light Mode)"
                    >
                        <!-- Sun Icon (Shown in Dark Mode) -->
                        <svg class="w-4 h-4 text-amber-400 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <!-- Moon Icon (Shown in Light Mode) -->
                        <svg class="w-4 h-4 text-slate-700 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Form Content Box (Snappy Entrance & Fast Response) -->
            <div id="login-form-box" class="relative z-10 w-full max-w-sm sm:max-w-md mx-auto my-auto py-6 sm:py-8 animate-fade-in-up">
                <!-- Mobile Feature Badges Grid (100% Fit, Zero Horizontal Scroll) -->
                <div class="lg:hidden grid grid-cols-3 gap-1.5 sm:gap-2 mb-6 select-none">
                    <!-- Pill 1: RBAC Matrix -->
                    <div class="flex items-center justify-center gap-1 sm:gap-1.5 px-2 py-1.5 rounded-xl bg-slate-100/90 dark:bg-slate-900/90 border border-slate-200/90 dark:border-slate-800 text-[11px] font-semibold text-slate-700 dark:text-slate-300 shadow-2xs backdrop-blur-md">
                        <svg class="w-3.5 h-3.5 text-primary-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="truncate">RBAC Matrix</span>
                    </div>

                    <!-- Pill 2: 0ms Modals -->
                    <div class="flex items-center justify-center gap-1 sm:gap-1.5 px-2 py-1.5 rounded-xl bg-slate-100/90 dark:bg-slate-900/90 border border-slate-200/90 dark:border-slate-800 text-[11px] font-semibold text-slate-700 dark:text-slate-300 shadow-2xs backdrop-blur-md">
                        <svg class="w-3.5 h-3.5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="truncate">0ms Modals</span>
                    </div>

                    <!-- Pill 3: 256-bit SSL -->
                    <div class="flex items-center justify-center gap-1 sm:gap-1.5 px-2 py-1.5 rounded-xl bg-slate-100/90 dark:bg-slate-900/90 border border-slate-200/90 dark:border-slate-800 text-[11px] font-semibold text-slate-700 dark:text-slate-300 shadow-2xs backdrop-blur-md">
                        <svg class="w-3.5 h-3.5 text-sky-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span class="truncate">256-bit SSL</span>
                    </div>
                </div>

                <!-- Clean Heading without Cartoon Emojis -->
                <div class="mb-6">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-primary-50 dark:bg-primary-950/60 border border-primary-200/60 dark:border-primary-800/60 text-primary-700 dark:text-primary-300 text-[11px] font-semibold mb-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary-500 animate-pulse"></span>
                        Portal Otentikasi
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Masuk ke Akun Anda
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Masukkan kredensial akun Anda untuk mengakses portal.
                    </p>
                </div>

                <!-- Flash Message -->
                @if (session('success'))
                    <div class="mb-4 p-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-xs font-semibold text-emerald-800 dark:text-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 p-3 rounded-xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-xs font-semibold text-rose-800 dark:text-rose-200">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Login Form with Smooth Portal Transition Handler -->
                <form
                    action="{{ route('login') }}"
                    method="POST"
                    class="space-y-4"
                    onsubmit="
                        const bar = document.getElementById('portal-bar');
                        const btn = document.getElementById('login-btn');
                        const spinner = document.getElementById('login-spinner');
                        const btnText = document.getElementById('login-text');
                        const btnIcon = document.getElementById('login-icon');
                        const formBox = document.getElementById('login-form-box');

                        if (bar) {
                            bar.classList.remove('-translate-x-full');
                            bar.classList.add('translate-x-0');
                        }
                        if (btn) {
                            btn.disabled = true;
                            btn.classList.add('opacity-95', 'cursor-wait');
                        }
                        if (spinner) spinner.classList.remove('hidden');
                        if (btnIcon) btnIcon.classList.add('hidden');
                        if (btnText) btnText.textContent = 'Memverifikasi akun...';
                        if (formBox) {
                            formBox.classList.add('opacity-90', 'scale-[0.995]', 'transition-all', 'duration-300');
                        }
                    "
                >
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Alamat Email <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                                </svg>
                            </div>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="admin@starterkit.test"
                                class="w-full rounded-xl border border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-900 pl-10 pr-4 py-2.5 sm:py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15 focus:border-primary-500 transition-all duration-200 shadow-2xs"
                            />
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Input with Native Toggle -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                                Kata Sandi <span class="text-rose-500">*</span>
                            </label>
                            <span class="text-xs font-medium text-primary-600 dark:text-primary-400 hover:underline cursor-pointer">
                                Lupa sandi?
                            </span>
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                placeholder="••••••••"
                                class="w-full rounded-xl border border-slate-300 dark:border-slate-800 bg-white dark:bg-slate-900 pl-10 pr-10 py-2.5 sm:py-3 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-4 focus:ring-primary-500/15 focus:border-primary-500 transition-all duration-200 shadow-2xs"
                            />
                            <button
                                type="button"
                                onclick="
                                    const p = document.getElementById('password');
                                    p.type = p.type === 'password' ? 'text' : 'password';
                                "
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 active:scale-90 transition cursor-pointer"
                                tabindex="-1"
                                title="Lihat kata sandi"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none text-xs text-slate-600 dark:text-slate-400">
                            <input
                                type="checkbox"
                                name="remember"
                                class="w-4 h-4 rounded border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-primary-600 focus:ring-primary-500/20"
                            />
                            <span>Ingat sesi masuk saya</span>
                        </label>
                    </div>

                    <!-- Submit Button with Sheen Wave & Dynamic Verifying Spinner -->
                    <div class="pt-2">
                        <button
                            id="login-btn"
                            type="submit"
                            class="group relative overflow-hidden w-full flex items-center justify-center gap-2.5 px-5 py-3 sm:py-3.5 rounded-xl bg-gradient-to-r from-primary-600 via-primary-500 to-primary-600 hover:from-primary-500 hover:to-primary-600 text-white font-bold text-sm shadow-md shadow-primary-600/25 hover:shadow-xl hover:shadow-primary-600/35 hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.98] transition-all duration-200 cursor-pointer"
                        >
                            <!-- Ambient Light Shimmer Wave on Hover -->
                            <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full transition-transform duration-700 bg-gradient-to-r from-transparent via-white/20 to-transparent pointer-events-none"></div>

                            <!-- Sleek Inline Loading Spinner (Hidden by default) -->
                            <svg id="login-spinner" class="hidden w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>

                            <span id="login-text">Masuk ke Dashboard</span>

                            <svg id="login-icon" class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer for right column -->
            <div class="relative z-10 text-center text-[11px] text-slate-400 dark:text-slate-500 pt-4">
                &copy; {{ date('Y') }} {{ setting('company_short_name', 'SKY Studio') }} &bull; Dilindungi Hak Cipta
            </div>
        </div>
    </div>
</body>
</html>
