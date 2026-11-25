@props([
    'icon' => null,
    'active' => false,
    'size' => 'md',
])

@php
    $sizeClasses = [
        'sm' => 'h-9 py-1.5 pl-3 pr-8 text-xs',
        'md' => 'h-10 py-2 pl-3.5 pr-9 text-sm',
    ][$size] ?? 'h-10 py-2 pl-3.5 pr-9 text-sm';

    if ($icon) {
        $sizeClasses = [
            'sm' => 'h-9 py-1.5 pl-8 pr-8 text-xs',
            'md' => 'h-10 py-2 pl-9 pr-9 text-sm',
        ][$size] ?? 'h-10 py-2 pl-9 pr-9 text-sm';
    }
@endphp

<div class="relative inline-block w-full sm:w-auto">
    @if ($icon)
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
            {{ $icon }}
        </div>
    @endif

    <select
        {{ $attributes->merge([
            'class' => 'w-full sm:w-auto appearance-none rounded-xl border font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 cursor-pointer ' .
            $sizeClasses . ' ' .
            ($active
                ? 'border-primary-400 dark:border-primary-600 bg-primary-50/50 dark:bg-primary-950/30 text-primary-700 dark:text-primary-300 font-semibold shadow-2xs'
                : 'border-slate-200 dark:border-slate-800 hover:border-slate-300 dark:hover:border-slate-700 bg-slate-50/70 dark:bg-slate-950/40 text-slate-700 dark:text-slate-200 shadow-2xs')
        ]) }}
    >
        {{ $slot }}
    </select>

    <!-- Custom Modern SVG Chevron Down (No Ugly OS Default Arrow!) -->
    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 dark:text-slate-500">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>
</div>
