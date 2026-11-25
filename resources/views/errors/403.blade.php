@extends('errors.layout')

@section('title', 'Akses Dibatasi')
@section('code', '403')

@section('badge-bg', 'bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 border border-rose-200/60 dark:border-rose-800/60')

@section('icon')
    <!-- Shield / Lock SVG -->
    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
    </svg>
@endsection

@section('description')
    {{ $exception->getMessage() ?: 'Akun Anda tidak memiliki izin hak akses (permission) untuk membuka halaman atau fitur ini. Silakan hubungi Super Administrator jika Anda memerlukan wewenang ini.' }}
@endsection
