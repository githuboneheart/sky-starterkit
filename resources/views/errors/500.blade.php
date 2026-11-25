@extends('errors.layout')

@section('title', 'Kendala Server Internal')
@section('code', '500')

@section('badge-bg', 'bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 border border-rose-200/60 dark:border-rose-800/60')

@section('icon')
    <!-- Server Alert SVG -->
    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
    </svg>
@endsection

@section('description')
    Terjadi kendala tak terduga pada server aplikasi. Sistem telah mencatat insiden ini ke dalam berkas log keamanan untuk segera ditindaklanjuti oleh tim teknis.
@endsection
