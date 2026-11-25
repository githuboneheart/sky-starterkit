@props([
    'head' => null,
    'empty' => 'Tidak ada data yang ditemukan.',
    'emptyIcon' => true,
    'pagination' => null,
])

<div class="w-full overflow-hidden rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-sm transition-colors">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300 divide-y divide-slate-200/70 dark:divide-slate-800">
            @if ($head)
                <thead class="bg-slate-50/80 dark:bg-slate-950/50 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                    <tr>
                        {{ $head }}
                    </tr>
                </thead>
            @endif

            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 bg-white dark:bg-slate-900">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if ($slot->isEmpty())
        <div class="flex flex-col items-center justify-center p-12 text-center">
            @if ($emptyIcon)
                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
            @endif
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                {{ $empty }}
            </p>
        </div>
    @endif

    @if ($pagination)
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800/80 bg-slate-50/50 dark:bg-slate-950/30">
            {{ $pagination }}
        </div>
    @endif
</div>
