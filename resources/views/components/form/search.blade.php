@props([
    'placeholder' => 'Cari data...',
    'size' => 'md',
    'loadingTarget' => null,
])

@php
    $modelAttr = $attributes->whereStartsWith('wire:model')->first();
    $targetName = $loadingTarget ?? $modelAttr;

    $paddingClasses = [
        'sm' => 'py-1.5 pl-8 pr-8 text-xs',
        'md' => 'py-2 pl-10 pr-9 text-sm',
    ][$size] ?? 'py-2 pl-10 pr-9 text-sm';

    $iconWrapperPadding = [
        'sm' => 'pl-2.5',
        'md' => 'pl-3.5',
    ][$size] ?? 'pl-3.5';

    $iconSvgSizes = [
        'sm' => 'w-3.5 h-3.5',
        'md' => 'w-4 h-4',
    ][$size] ?? 'w-4 h-4';
@endphp

<div class="relative w-full">
    <!-- Search Icon (Perfect Vertical Center Alignment) -->
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center {{ $iconWrapperPadding }} text-slate-400">
        <svg class="{{ $iconSvgSizes }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>

    <!-- Search Input -->
    <input
        type="text"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' => 'w-full rounded-xl border border-slate-300 dark:border-slate-700/80 bg-white dark:bg-slate-900 ' . $paddingClasses . ' text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 transition duration-150 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 shadow-2xs leading-normal'
        ]) }}
    />

    <!-- Loading Spinner (Auto when Livewire debouncing) -->
    @if ($targetName)
        <div
            wire:loading
            wire:target="{{ $targetName }}"
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center {{ $size === 'sm' ? 'pr-2.5' : 'pr-3.5' }}"
        >
            <svg class="{{ $iconSvgSizes }} animate-spin text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    @endif
</div>
