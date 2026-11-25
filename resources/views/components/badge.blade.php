@props([
    'variant' => 'info',
    'size' => 'md',
    'dot' => false,
])

@php
    $sizes = [
        'sm' => 'text-[10px] px-2 py-0.5 font-medium gap-1',
        'md' => 'text-xs px-2.5 py-1 font-medium gap-1.5',
        'lg' => 'text-sm px-3 py-1.5 font-semibold gap-2',
    ];

    $variants = [
        'primary' => 'bg-primary-50 text-primary-700 border-primary-200/60 dark:bg-primary-950/60 dark:text-primary-300 dark:border-primary-800/80',
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800/80',
        'danger' => 'bg-rose-50 text-rose-700 border-rose-200/60 dark:bg-rose-950/60 dark:text-rose-300 dark:border-rose-800/80',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200/60 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800/80',
        'info' => 'bg-sky-50 text-sky-700 border-sky-200/60 dark:bg-sky-950/60 dark:text-sky-300 dark:border-sky-800/80',
        'gray' => 'bg-slate-100 text-slate-700 border-slate-200/60 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700',
    ];

    $dotColors = [
        'primary' => 'bg-primary-500',
        'success' => 'bg-emerald-500',
        'danger' => 'bg-rose-500',
        'warning' => 'bg-amber-500',
        'info' => 'bg-sky-500',
        'gray' => 'bg-slate-400',
    ];

    $badgeClass = 'inline-flex items-center rounded-lg border transition-colors ' . ($sizes[$size] ?? $sizes['md']) . ' ' . ($variants[$variant] ?? $variants['info']);
@endphp

<span {{ $attributes->merge(['class' => $badgeClass]) }}>
    @if ($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColors[$variant] ?? 'bg-slate-400' }}"></span>
    @endif
    {{ $slot }}
</span>
