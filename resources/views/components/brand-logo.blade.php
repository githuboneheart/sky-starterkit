@props([
    'size' => 'md',
    'showText' => true,
    'textClass' => null,
    'subtextClass' => null,
])

@php
    $logoLight = setting('app_logo_light') ? Storage::url(setting('app_logo_light')) : null;
    $logoDark = (setting('app_logo_dark') ?? setting('app_logo_light')) ? Storage::url(setting('app_logo_dark') ?? setting('app_logo_light')) : null;
    $appName = setting('app_name', 'SKY Starterkit');
    $companyShortName = setting('company_short_name', 'SKY Studio');
    $initial = strtoupper(substr($appName, 0, 1) ?: 'S');

    $imgHeights = [
        'sm' => 'h-7 max-h-7',
        'md' => 'h-9 max-h-9',
        'lg' => 'h-11 max-h-11',
    ][$size] ?? 'h-9 max-h-9';

    $monogramSizes = [
        'sm' => 'w-7 h-7 text-xs rounded-xl',
        'md' => 'w-10 h-10 text-lg rounded-2xl',
        'lg' => 'w-12 h-12 text-xl rounded-2xl',
    ][$size] ?? 'w-10 h-10 text-lg rounded-2xl';
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-3 group']) }}>
    <!-- Logo Image or Fallback Monogram -->
    @if ($logoLight)
        <div class="shrink-0 flex items-center">
            <img src="{{ $logoLight }}" alt="{{ $appName }}" class="{{ $imgHeights }} w-auto object-contain dark:hidden" />
            <img src="{{ $logoDark }}" alt="{{ $appName }}" class="{{ $imgHeights }} w-auto object-contain hidden dark:block" />
        </div>
    @else
        <div class="{{ $monogramSizes }} bg-primary-600 text-white flex items-center justify-center font-extrabold shadow-md shadow-primary-500/25 ring-1 ring-white/20 shrink-0 group-hover:scale-105 transition-transform duration-200">
            <span>{{ $initial }}</span>
        </div>
    @endif

    <!-- Brand Text -->
    @if ($showText)
        <div class="truncate">
            <span class="block font-extrabold text-slate-900 dark:text-white text-sm leading-tight tracking-tight truncate {{ $textClass }}">
                {{ $appName }}
            </span>
            <span class="block text-[11px] font-semibold text-primary-600 dark:text-primary-400 truncate tracking-wide {{ $subtextClass }}">
                {{ $companyShortName }}
            </span>
        </div>
    @endif
</div>
