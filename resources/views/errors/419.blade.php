@extends('errors.layout')

@section('title', 'Sesi Telah Berakhir')
@section('code', '419')

@section('badge-bg', 'bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border border-amber-200/60 dark:border-amber-800/60')

@section('icon')
    <!-- Clock / Timeout SVG -->
    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
@endsection

@section('description')
    Halaman ini telah terbuka terlalu lama tanpa aktivitas sehingga sesi keamanan telah kedaluwarsa. Silakan muat ulang halaman untuk memperbarui sesi Anda.
@endsection

@section('actions')
    <button
        type="button"
        onclick="window.location.reload()"
        class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-primary-600 hover:bg-primary-700 text-white text-xs font-bold shadow-md shadow-primary-500/20 transition-all duration-150 active:scale-95"
    >
        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        Muat Ulang Halaman (Refresh)
    </button>

    <a
        href="{{ auth()->check() ? route('dashboard') : route('login') }}"
        class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700/70 text-slate-700 dark:text-slate-200 text-xs font-bold transition-all duration-150 active:scale-95 shadow-2xs"
    >
        {{ auth()->check() ? 'Ke Dashboard' : 'Masuk Kembali' }}
    </a>
@endsection
