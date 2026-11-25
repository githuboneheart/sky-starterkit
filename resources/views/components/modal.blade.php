@props([
    'name' => null,
    'show' => false,
    'maxWidth' => 'lg',
    'title' => null,
])

@php
    $maxWidthClass = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        '5xl' => 'sm:max-w-5xl',
    ][$maxWidth] ?? 'sm:max-w-lg';
@endphp

<div
    x-data="{
        show: @if($attributes->wire('model')->value()) @entangle($attributes->wire('model')).live @else false @endif
    }"
    x-show="show"
    @if($name)
        x-on:open-modal.window="if ($event.detail === '{{ $name }}') show = true"
        x-on:close-modal.window="if ($event.detail === '{{ $name }}') show = false"
    @endif
    x-on:keydown.escape.window="show = false"
    class="relative z-50 overflow-y-auto"
    style="display: none;"
>
    <!-- Backdrop -->
    <div
        x-show="show"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/60 dark:bg-black/75 backdrop-blur-sm transition-opacity"
        @click="show = false"
    ></div>

    <!-- Dialog Panel Container -->
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto p-3 sm:p-6 md:p-8 flex min-h-full items-center justify-center">
        <div
            x-show="show"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-3 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-3 sm:translate-y-0 sm:scale-95"
            class="relative w-full {{ $maxWidthClass }} my-auto max-h-[calc(100vh-2rem)] sm:max-h-[calc(100vh-3.5rem)] flex flex-col transform rounded-2xl bg-white dark:bg-slate-900 text-left shadow-2xl border border-slate-200/80 dark:border-slate-800 transition-all overflow-hidden"
            @click.stop
        >
            @if ($title)
                <div class="shrink-0 flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 z-10">
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">
                        {{ $title }}
                    </h3>
                    <button
                        type="button"
                        @click="show = false"
                        class="rounded-lg p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif

            <div class="p-6 overflow-y-auto flex-1 overscroll-contain">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="shrink-0 px-6 py-4 bg-slate-50/70 dark:bg-slate-950/40 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3 z-10">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
