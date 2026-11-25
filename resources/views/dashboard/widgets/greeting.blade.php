@props(['user'])

@php
    $roles = $user->roles->pluck('name')->toArray();
    $primaryRole = $roles[0] ?? 'Pengguna';
@endphp

<div class="flex items-center justify-between w-full gap-4">
    <div class="flex items-center gap-3.5 min-w-0">
        <!-- User Avatar / Photo with Active Indicator -->
        <div class="relative shrink-0">
            <img
                src="{{ $user->avatar_url }}"
                alt="{{ $user->name }}"
                class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl object-cover border border-slate-200/80 dark:border-slate-700/80 shadow-xs"
            />
            <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-slate-900" title="Akun Aktif"></span>
        </div>

        <!-- Greeting Text (Single-line, crisp, zero awkward wrap) -->
        <div class="min-w-0">
            <div class="flex items-center gap-2">
                <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-primary-50 dark:bg-primary-950/60 text-primary-600 dark:text-primary-400 border border-primary-200/60 dark:border-primary-800/60">
                    {{ $primaryRole }}
                </span>
                <span class="text-xs text-slate-400 dark:text-slate-600">&bull;</span>
                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                    PT Maju Bersama Medika
                </span>
            </div>
            <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight truncate mt-0.5">
                Selamat Datang Kembali, {{ $user->name }} 👋
            </h1>
        </div>
    </div>

    <!-- Right Side: Date & Status -->
    <div class="hidden sm:flex items-center gap-2.5 shrink-0">
        <span class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-800 text-xs font-bold text-slate-700 dark:text-slate-300 shadow-2xs">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>{{ now()->isoFormat('dddd, D MMMM Y') }}</span>
        </span>
    </div>
</div>
