@props([
    'align' => 'left',
])

@php
    $alignClasses = [
        'left' => 'text-left',
        'center' => 'text-center',
        'right' => 'text-right',
    ][$align] ?? 'text-left';
@endphp

<td {{ $attributes->merge(['class' => 'px-6 py-4 text-sm text-slate-700 dark:text-slate-300 ' . $alignClasses]) }}>
    {{ $slot }}
</td>
