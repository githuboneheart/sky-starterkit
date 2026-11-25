@props([
    'type' => 'text',
    'lines' => 3,
    'height' => 'h-4',
    'width' => 'w-full',
])

@if ($type === 'avatar')
    <div {{ $attributes->merge(['class' => 'w-10 h-10 rounded-2xl bg-slate-200 dark:bg-slate-800 animate-shimmer shrink-0']) }}></div>

@elseif ($type === 'card')
    <div {{ $attributes->merge(['class' => 'p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm space-y-4']) }}>
        <div class="h-4 w-1/3 bg-slate-200 dark:bg-slate-800 rounded-lg animate-shimmer"></div>
        <div class="h-8 w-2/3 bg-slate-200 dark:bg-slate-800 rounded-lg animate-shimmer"></div>
        <div class="h-3 w-1/2 bg-slate-200 dark:bg-slate-800 rounded-lg animate-shimmer"></div>
    </div>

@elseif ($type === 'table')
    <div {{ $attributes->merge(['class' => 'w-full divide-y divide-slate-100 dark:divide-slate-800']) }}>
        @for ($i = 0; $i < $lines; $i++)
            <div class="py-3 flex items-center justify-between gap-4">
                <div class="h-4 w-1/4 bg-slate-200 dark:bg-slate-800 rounded-lg animate-shimmer"></div>
                <div class="h-4 w-1/3 bg-slate-200 dark:bg-slate-800 rounded-lg animate-shimmer"></div>
                <div class="h-4 w-1/6 bg-slate-200 dark:bg-slate-800 rounded-lg animate-shimmer"></div>
            </div>
        @endfor
    </div>

@else
    {{-- Type: text lines --}}
    <div {{ $attributes->merge(['class' => 'space-y-2.5']) }}>
        @for ($i = 0; $i < $lines; $i++)
            <div
                class="{{ $height }} bg-slate-200 dark:bg-slate-800 rounded-lg animate-shimmer {{ $i === $lines - 1 && $lines > 1 ? 'w-2/3' : $width }}"
            ></div>
        @endfor
    </div>
@endif
