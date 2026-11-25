@props([
    'title',
    'value',
    'description' => null,
    'trend' => null,
    'trendValue' => null,
    'variant' => 'primary',
])

@php
    $variantConfigs = [
        'primary' => [
            'iconBg' => 'bg-primary-50 dark:bg-primary-950/60 text-primary-600 dark:text-primary-400 border-primary-200/60 dark:border-primary-800/60',
        ],
        'success' => [
            'iconBg' => 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 border-emerald-200/60 dark:border-emerald-800/60',
        ],
        'warning' => [
            'iconBg' => 'bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 border-amber-200/60 dark:border-amber-800/60',
        ],
        'danger' => [
            'iconBg' => 'bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 border-rose-200/60 dark:border-rose-800/60',
        ],
        'slate' => [
            'iconBg' => 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-700',
        ],
    ][$variant] ?? [
        'iconBg' => 'bg-primary-50 dark:bg-primary-950/60 text-primary-600 dark:text-primary-400 border-primary-200/60 dark:border-primary-800/60',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-5 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:border-slate-300 dark:hover:border-slate-700']) }}>
    <div class="flex items-center justify-between gap-3">
        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
            {{ $title }}
        </span>

        @isset($icon)
            <div class="w-10 h-10 rounded-xl border flex items-center justify-center shrink-0 {{ $variantConfigs['iconBg'] }}">
                {{ $icon }}
            </div>
        @endisset
    </div>

    <div class="mt-2 flex items-baseline gap-2">
        <span class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
            {{ $value }}
        </span>

        @if ($trendValue)
            <span class="inline-flex items-center text-xs font-semibold {{ $trend === 'up' ? 'text-emerald-600 dark:text-emerald-400' : ($trend === 'down' ? 'text-rose-600 dark:text-rose-400' : 'text-slate-500') }}">
                @if ($trend === 'up')
                    <svg class="w-3.5 h-3.5 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                @elseif ($trend === 'down')
                    <svg class="w-3.5 h-3.5 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                @endif
                {{ $trendValue }}
            </span>
        @endif
    </div>

    @if ($description)
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
            {{ $description }}
        </p>
    @endif
</div>
