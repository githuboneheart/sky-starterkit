@extends('errors.layout')

@section('title', 'Halaman Tidak Ditemukan')
@section('code', '404')

@section('icon')
    <!-- Modern Compass / Map Search SVG -->
    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
@endsection

@section('description')
    Halaman atau tautan yang Anda tuju (<strong>{{ request()->getPathInfo() }}</strong>) tidak ditemukan. Alamat tautan mungkin salah ketik, telah dipindahkan, atau tidak lagi tersedia.
@endsection
