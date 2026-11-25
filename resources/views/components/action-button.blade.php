@props([
    'type' => 'edit',
    'title' => null,
    'loading' => null,
    'href' => null,
])

@php
    $wireClick = $attributes->whereStartsWith('wire:click')->first();
    $target = $loading ?? $wireClick;

    $configs = [
        'view' => [
            'defaultTitle' => 'Lihat Detail',
            'classes' => 'text-slate-500 hover:text-primary-600 dark:text-slate-400 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/40',
        ],
        'edit' => [
            'defaultTitle' => 'Edit',
            'classes' => 'text-slate-500 hover:text-primary-600 dark:text-slate-400 dark:hover:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-950/40',
        ],
        'delete' => [
            'defaultTitle' => 'Hapus',
            'classes' => 'text-slate-500 hover:text-rose-600 dark:text-slate-400 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40',
        ],
        'impersonate' => [
            'defaultTitle' => 'Login Sebagai',
            'classes' => 'text-slate-500 hover:text-amber-600 dark:text-slate-400 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-950/40',
        ],
        'custom' => [
            'defaultTitle' => 'Aksi',
            'classes' => 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800',
        ],
    ];

    $current = $configs[$type] ?? $configs['custom'];
    $buttonTitle = $title ?? $current['defaultTitle'];
@endphp

@if ($href)
    <a
        href="{{ $href }}"
        title="{{ $buttonTitle }}"
        aria-label="{{ $buttonTitle }}"
        {{ $attributes->merge([
            'class' => 'relative inline-flex items-center justify-center p-1.5 rounded-lg transition-all duration-150 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed ' . $current['classes']
        ]) }}
    >
        <span class="inline-flex">
            @if ($type === 'view')
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            @elseif ($type === 'edit')
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            @elseif ($type === 'delete')
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            @elseif ($type === 'impersonate')
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            @else
                {{ $slot }}
            @endif
        </span>
    </a>
@else
    <button
        type="button"
        title="{{ $buttonTitle }}"
        aria-label="{{ $buttonTitle }}"
        @if ($target) wire:loading.attr="disabled" wire:target="{{ $target }}" @endif
        {{ $attributes->merge([
            'class' => 'relative inline-flex items-center justify-center p-1.5 rounded-lg transition-all duration-150 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed ' . $current['classes']
        ]) }}
    >
        <!-- Normal Icon (Hidden when loading) -->
        <span @if ($target) wire:loading.remove wire:target="{{ $target }}" @endif class="inline-flex">
            @if ($type === 'view')
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            @elseif ($type === 'edit')
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            @elseif ($type === 'delete')
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            @elseif ($type === 'impersonate')
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            @else
                {{ $slot }}
            @endif
        </span>

        <!-- Loading Spinner (Shown during action) -->
        @if ($target)
            <span wire:loading wire:target="{{ $target }}" class="inline-flex">
                <svg class="w-4 h-4 animate-spin text-current" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        @endif
    </button>
@endif
