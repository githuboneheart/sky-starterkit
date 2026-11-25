@props(['financeData'])

<div class="space-y-6">
    <!-- Header Section Indicator -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                Ringkasan Kasir & Keuangan (Finance)
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Pemantauan transaksi ruko, pembayaran tagihan bimbel & klinik, serta rekapitulasi honor</p>
        </div>
        <div class="flex items-center gap-2">
            <x-badge variant="success" :dot="true">Kasir Standby</x-badge>
        </div>
    </div>

    <!-- 4 High Impact Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <x-stat-card
            title="Omset Transaksi Hari Ini"
            value="{{ $financeData['metrics']['today_turnover'] }}"
            trend="up"
            trendValue="+8.2% vs kemarin"
            variant="success"
            description="Penerimaan kasir & transfer"
        />

        <x-stat-card
            title="Transaksi Kasir Selesai"
            value="{{ $financeData['metrics']['today_transactions'] }} Struk"
            trend="up"
            trendValue="POS Ruko"
            variant="primary"
            description="Pelunasan klinik & bimbel"
        />

        <x-stat-card
            title="Invoice Menunggu Pembayaran"
            value="{{ $financeData['metrics']['pending_invoices'] }} Tagihan"
            trend="down"
            trendValue="Perlu reminder"
            variant="warning"
            description="Menunggu konfirmasi transfer"
        />

        <x-stat-card
            title="Checkpoint Honor Siap Cair"
            value="{{ $financeData['metrics']['verified_payroll'] }}"
            trend="up"
            trendValue="Bulan ini"
            variant="primary"
            description="Honor tutor & insentif terapis"
        />
    </div>

    <!-- Action Shortcuts -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Buka Kasir POS Ruko</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Input pembayaran pasien terapi atau pendaftaran taruna</p>
                </div>
            </div>
            <x-button variant="primary" size="sm">Buka Kasir</x-button>
        </div>

        <div class="p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Laporan Mutasi Kas & Omset</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Rekapitulasi pemasukan harian dan pencairan operasional</p>
                </div>
            </div>
            <x-button variant="secondary" size="sm">Lihat Mutasi</x-button>
        </div>
    </div>
</div>
