@props([
    'sortable' => false,
    'field' => null,
    'currentSort' => null,
    'direction' => 'asc',
    'align' => 'left',
])

@php
    $alignClasses = [
        'left' => 'text-left justify-start',
        'center' => 'text-center justify-center',
        'right' => 'text-right justify-end',
    ][$align] ?? 'text-left justify-start';

    $isSorted = $sortable && $field && $currentSort === $field;
@endphp

<th
    {{ $attributes->merge([
        'class' => 'px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 select-none ' .
            ($sortable ? 'cursor-pointer hover:bg-slate-100/75 dark:hover:bg-slate-800/50 transition-colors' : '')
    ]) }}
    @if ($sortable && $field) wire:click="sortBy('{{ $field }}')" @endif
>
    <div class="inline-flex items-center gap-1.5 {{ $alignClasses }}">
        <span>{{ $slot }}</span>

        @if ($sortable && $field)
            <span class="inline-flex flex-col text-[10px] leading-none {{ $isSorted ? 'text-primary-600 dark:text-primary-400 font-bold' : 'text-slate-300 dark:text-slate-600 group-hover:text-slate-400' }}">
                @if ($isSorted)
                    @if ($direction === 'asc')
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7" />
                        </svg>
                    @else
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    @endif
                @else
                    <svg class="w-3 h-3 opacity-40 hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                @endif
            </span>
        @endif
    </div>
</th>
