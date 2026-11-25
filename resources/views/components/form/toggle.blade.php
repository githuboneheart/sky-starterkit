@props([
    'label' => null,
    'description' => null,
    'name' => null,
    'size' => 'md',
])

@php
    $switchSizes = [
        'sm' => ['track' => 'h-5 w-9', 'thumb' => 'h-4 w-4', 'translate' => 'translate-x-4'],
        'md' => ['track' => 'h-6 w-11', 'thumb' => 'h-5 w-5', 'translate' => 'translate-x-5'],
        'lg' => ['track' => 'h-7 w-14', 'thumb' => 'h-6 w-6', 'translate' => 'translate-x-7'],
    ][$size] ?? ['track' => 'h-6 w-11', 'thumb' => 'h-5 w-5', 'translate' => 'translate-x-5'];
@endphp

<label class="inline-flex items-center gap-3 cursor-pointer select-none">
    <div class="relative">
        <input
            type="checkbox"
            @if($name) id="{{ $name }}" name="{{ $name }}" @endif
            class="sr-only peer"
            {{ $attributes }}
        />
        <div class="{{ $switchSizes['track'] }} rounded-full bg-slate-200 dark:bg-slate-700 peer-focus:ring-2 peer-focus:ring-primary-500/20 peer-checked:bg-primary-600 transition-colors duration-200 ease-in-out"></div>
        <div class="absolute left-0.5 top-0.5 {{ $switchSizes['thumb'] }} rounded-full bg-white shadow-sm transform transition-transform duration-200 ease-in-out peer-checked:{{ $switchSizes['translate'] }}"></div>
    </div>

    @if ($label || $description)
        <div>
            @if ($label)
                <span class="text-sm font-medium text-slate-800 dark:text-slate-200 block">
                    {{ $label }}
                </span>
            @endif
            @if ($description)
                <span class="text-xs text-slate-500 dark:text-slate-400 block mt-0.5">
                    {{ $description }}
                </span>
            @endif
        </div>
    @endif
</label>
