@props([
    'boxed' => true,
    'filters' => null,
    'actions' => null,
])

<div {{ $attributes->merge([
    'class' => 'mb-6 ' . ($boxed 
        ? 'flex flex-col lg:flex-row lg:items-center justify-between gap-3.5 p-3.5 sm:p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 shadow-2xs' 
        : 'flex flex-col lg:flex-row lg:items-center justify-between gap-3.5')
]) }}>
    @if ($filters || $actions)
        <div class="flex flex-wrap items-center gap-2.5 flex-1 min-w-0">
            {{ $filters ?? $slot }}
        </div>
        @if ($actions)
            <div class="flex items-center gap-2.5 shrink-0">
                {{ $actions }}
            </div>
        @endif
    @else
        {{ $slot }}
    @endif
</div>
