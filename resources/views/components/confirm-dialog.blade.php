@props([
    'name',
    'title' => 'Konfirmasi Tindakan',
    'description' => 'Apakah Anda yakin ingin melanjutkan tindakan ini?',
    'confirmText' => 'Ya, Lanjutkan',
    'cancelText' => 'Batal',
    'confirmAction' => null,
    'confirmLoading' => null,
    'variant' => 'danger',
    'maxWidth' => 'md',
])

@php
    $variantIcons = [
        'danger' => [
            'iconBg' => 'bg-rose-100 dark:bg-rose-950/80 text-rose-600 dark:text-rose-400',
            'btnVariant' => 'danger',
        ],
        'warning' => [
            'iconBg' => 'bg-amber-100 dark:bg-amber-950/80 text-amber-600 dark:text-amber-400',
            'btnVariant' => 'warning',
        ],
        'primary' => [
            'iconBg' => 'bg-primary-100 dark:bg-primary-950/80 text-primary-600 dark:text-primary-400',
            'btnVariant' => 'primary',
        ],
    ][$variant] ?? [
        'iconBg' => 'bg-rose-100 dark:bg-rose-950/80 text-rose-600 dark:text-rose-400',
        'btnVariant' => 'danger',
    ];
@endphp

<x-modal :name="$name" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="p-6">
        <div class="flex items-start gap-4">
            <!-- Icon Circle -->
            <div class="w-12 h-12 rounded-2xl {{ $variantIcons['iconBg'] }} flex items-center justify-center shrink-0">
                @if ($variant === 'danger')
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                @elseif ($variant === 'warning')
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @else
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                @endif
            </div>

            <!-- Content -->
            <div class="flex-1">
                <h3 class="text-base font-semibold text-slate-900 dark:text-white">
                    {{ $title }}
                </h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">
                    {{ $description }}
                </p>

                @if ($slot->isNotEmpty())
                    <div class="mt-3">
                        {{ $slot }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
            <x-button variant="secondary" @click="show = false">
                {{ $cancelText }}
            </x-button>

            @if ($confirmAction)
                <x-button
                    :variant="$variantIcons['btnVariant']"
                    wire:click="{{ $confirmAction }}"
                    :loading="$confirmLoading ?? $confirmAction"
                >
                    {{ $confirmText }}
                </x-button>
            @endif
        </div>
    </div>
</x-modal>
