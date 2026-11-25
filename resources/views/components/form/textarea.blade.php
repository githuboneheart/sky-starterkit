@props([
    'label' => null,
    'name' => null,
    'rows' => 3,
    'placeholder' => '',
    'required' => false,
    'hint' => null,
    'error' => null,
])

@php
    $fieldName = $name ?? $attributes->whereStartsWith('wire:model')->first();
    $hasError = $error || ($fieldName && $errors->has($fieldName));
    $errorMessage = $error ?? ($fieldName ? $errors->first($fieldName) : null);
@endphp

<div class="w-full">
    @if ($label)
        <label @if($fieldName) for="{{ $fieldName }}" @endif class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
            {{ $label }}
            @if ($required)
                <span class="text-rose-500 font-bold">*</span>
            @endif
        </label>
    @endif

    <textarea
        @if($fieldName) id="{{ $fieldName }}" name="{{ $fieldName }}" @endif
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' => 'w-full rounded-xl border bg-white dark:bg-slate-900 px-3.5 py-2.5 text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 transition duration-150 focus:outline-none focus:ring-2 ' .
            ($hasError
                ? 'border-rose-300 dark:border-rose-700 focus:border-rose-500 focus:ring-rose-500/20'
                : 'border-slate-300 dark:border-slate-700/80 focus:border-primary-500 dark:focus:border-primary-500 focus:ring-primary-500/20')
        ]) }}
    >{{ $slot }}</textarea>

    @if ($errorMessage)
        <p class="mt-1.5 text-xs text-rose-600 dark:text-rose-400 flex items-center gap-1">
            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            {{ $errorMessage }}
        </p>
    @elseif ($hint)
        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $hint }}</p>
    @endif
</div>
