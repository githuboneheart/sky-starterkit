@props([
    'title',
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4']) }}>
    <div>
        @isset($breadcrumbs)
            <nav class="mb-2 flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                {{ $breadcrumbs }}
            </nav>
        @endisset

        <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white leading-tight">
            {{ $title }}
        </h1>

        @if ($subtitle)
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                {{ $subtitle }}
            </p>
        @endif

        {{ $slot }}
    </div>

    @isset($action)
        <div class="flex items-center gap-3 shrink-0">
            {{ $action }}
        </div>
    @endisset
</div>
