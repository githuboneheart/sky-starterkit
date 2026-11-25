@props(['fisioData'])

<div class="space-y-6">
    <!-- Header Section Indicator -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                Operasional Klinik Fisioterapi (Fisio13)
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Pemantauan antrean terapi, reservasi pasien ruko, dan rekam medis postur</p>
        </div>
        <div class="flex items-center gap-2">
            <x-badge variant="success" :dot="true">Klinik Buka: 08:00 - 20:00 WIB</x-badge>
        </div>
    </div>

    <!-- 4 High Impact Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <x-stat-card
            title="Antrean Pasien Hari Ini"
            value="{{ $fisioData['metrics']['today_queue'] }} Pasien"
            trend="up"
            trendValue="8 Terjadwal"
            variant="primary"
            description="Reservasi sesi terapi"
        />

        <x-stat-card
            title="Pasien Ditangani (Bulan Ini)"
            value="{{ $fisioData['metrics']['treated_this_month'] }} Pasien"
            trend="up"
            trendValue="+14% vs lalu"
            variant="success"
            description="Akumulasi tindakan terapi"
        />

        <x-stat-card
            title="SOAP Menunggu Verifikasi"
            value="{{ $fisioData['metrics']['pending_soap'] }} Berkas"
            trend="down"
            trendValue="Perlu review"
            variant="warning"
            description="Dokumen rekam medis terapis"
        />

        <x-stat-card
            title="Tingkat Kepuasan Pasien"
            value="{{ $fisioData['metrics']['patient_satisfaction'] }}"
            trend="up"
            trendValue="Sangat Baik"
            variant="primary"
            description="Rating umpan balik pasien"
        />
    </div>

    <!-- Main Grid: Today's Queue & Action Center -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Antrean Hari Ini (2 Cols) -->
        <div class="lg:col-span-2">
            <x-card title="Daftar Antrean & Tindakan Hari Ini" subtitle="Pasien yang terjadwal menjalani terapi postur dan pemulihan">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 uppercase tracking-wider text-[10px]">
                                <th class="pb-3 font-semibold">Nama Pasien</th>
                                <th class="pb-3 font-semibold">Keluhan / Diagnosa</th>
                                <th class="pb-3 font-semibold">Jam Sesi</th>
                                <th class="pb-3 font-semibold">Terapis</th>
                                <th class="pb-3 font-semibold text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($fisioData['today_patients'] as $patient)
                                <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition">
                                    <td class="py-3 font-bold text-slate-900 dark:text-white">
                                        {{ $patient['name'] }}
                                    </td>
                                    <td class="py-3 text-slate-600 dark:text-slate-300">
                                        {{ $patient['complaint'] }}
                                    </td>
                                    <td class="py-3 font-medium text-slate-500">
                                        {{ $patient['time'] }}
                                    </td>
                                    <td class="py-3 font-medium text-slate-700 dark:text-slate-300">
                                        {{ $patient['therapist'] }}
                                    </td>
                                    <td class="py-3 text-right">
                                        <x-badge :variant="$patient['status'] === 'Selesai' ? 'success' : ($patient['status'] === 'Menunggu' ? 'warning' : 'primary')" size="sm">
                                            {{ $patient['status'] }}
                                        </x-badge>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        <!-- Quick Actions & SOP Ringkas -->
        <div class="space-y-6">
            <x-card title="Aksi Cepat Fisioterapi" subtitle="Jalan pintas operasional klinik">
                <div class="space-y-3">
                    <button
                        type="button"
                        class="w-full flex items-center justify-between p-3.5 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 hover:bg-primary-50 dark:hover:bg-primary-950/40 hover:border-primary-500/50 transition group cursor-pointer text-left"
                    >
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary-600 text-white flex items-center justify-center font-bold">
                                +
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-primary-600 transition">Booking Pasien Baru</h4>
                                <p class="text-[11px] text-slate-400">Jadwalkan kedatangan pasien ruko</p>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:translate-x-1 transition-transform">→</span>
                    </button>

                    <button
                        type="button"
                        class="w-full flex items-center justify-between p-3.5 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:border-emerald-500/50 transition group cursor-pointer text-left"
                    >
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center font-bold">
                                📋
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 transition">Input Rekam Medis SOAP</h4>
                                <p class="text-[11px] text-slate-400">Pencatatan antropometri & terapi</p>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:translate-x-1 transition-transform">→</span>
                    </button>
                </div>
            </x-card>
        </div>
    </div>
</div>
