@props(['academyData'])

<div class="space-y-6">
    <!-- Header Section Indicator -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-primary-600"></span>
                Akademik & Pembelajaran (Academy13)
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Pemantauan kelas bimbingan kedinasan, presensi taruna, dan bank tryout CAT</p>
        </div>
        <div class="flex items-center gap-2">
            <x-badge variant="primary" :dot="true">Persiapan Tes Kedinasan {{ date('Y') }}</x-badge>
        </div>
    </div>

    <!-- 4 High Impact Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <x-stat-card
            title="Kelas Aktif Hari Ini"
            value="{{ $academyData['metrics']['active_classes_today'] }} Sesi"
            trend="up"
            trendValue="3 Kelas berjalan"
            variant="primary"
            description="Jadwal tatap muka & samapta"
        />

        <x-stat-card
            title="Total Taruna Terbimbing"
            value="{{ $academyData['metrics']['total_taruna'] }} Siswa"
            trend="up"
            trendValue="Angkatan {{ date('Y') }}"
            variant="success"
            description="Taruna aktif bimbingan"
        />

        <x-stat-card
            title="Tingkat Presensi Taruna"
            value="{{ $academyData['metrics']['attendance_rate'] }}"
            trend="up"
            trendValue="Target 95%"
            variant="primary"
            description="Rata-rata kehadiran kelas"
        />

        <x-stat-card
            title="Tryout CAT Terdekat"
            value="{{ $academyData['metrics']['next_cat_tryout'] }}"
            trend="up"
            trendValue="Standar CAT BKN"
            variant="warning"
            description="Simulasi tes SKD nasional"
        />
    </div>

    <!-- Main Grid: Today's Classes & Quick Action -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Jadwal Kelas Hari Ini (2 Cols) -->
        <div class="lg:col-span-2">
            <x-card title="Jadwal Kelas Belajar Hari Ini" subtitle="Daftar sesi belajar teori, latihan soal TIU/TWK, dan pelatihan samapta">
                <div class="space-y-3.5">
                    @foreach ($academyData['today_classes'] as $cls)
                        <div class="p-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-primary-500/40 transition">
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-primary-500/10 text-primary-600 dark:text-primary-400 flex items-center justify-center shrink-0 font-extrabold text-sm">
                                    {{ substr($cls['name'], 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white leading-tight">
                                        {{ $cls['name'] }}
                                    </h4>
                                    <p class="text-xs font-semibold text-primary-600 dark:text-primary-400 mt-0.5">
                                        Modul: {{ $cls['subject'] }}
                                    </p>
                                    <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500 dark:text-slate-400">
                                        <span>Jam: <strong>{{ $cls['time'] }} WIB</strong></span>
                                        <span>&bull;</span>
                                        <span>Tutor: {{ $cls['tutor'] }}</span>
                                        <span>&bull;</span>
                                        <span>{{ $cls['room'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right shrink-0">
                                <x-badge variant="info" size="sm">
                                    {{ $cls['students'] }} Taruna
                                </x-badge>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>

        <!-- Action Center -->
        <div class="space-y-6">
            <x-card title="Aksi Cepat Akademik" subtitle="Jalan pintas presensi dan ujian">
                <div class="space-y-3">
                    <button
                        type="button"
                        class="w-full flex items-center justify-between p-3.5 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 hover:bg-primary-50 dark:hover:bg-primary-950/40 hover:border-primary-500/50 transition group cursor-pointer text-left"
                    >
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary-600 text-white flex items-center justify-center font-bold">
                                ✍️
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-primary-600 transition">Presensi Taruna & Kelas</h4>
                                <p class="text-[11px] text-slate-400">Verifikasi kehadiran dan topik materi</p>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:translate-x-1 transition-transform">→</span>
                    </button>

                    <button
                        type="button"
                        class="w-full flex items-center justify-between p-3.5 rounded-xl border border-slate-200/80 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 hover:bg-amber-50 dark:hover:bg-amber-950/40 hover:border-amber-500/50 transition group cursor-pointer text-left"
                    >
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center font-bold">
                                🔑
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-amber-600 transition">Rilis Token Tryout CAT</h4>
                                <p class="text-[11px] text-slate-400">Live proctoring simulasi CAT SKD</p>
                            </div>
                        </div>
                        <span class="text-slate-400 group-hover:translate-x-1 transition-transform">→</span>
                    </button>
                </div>
            </x-card>
        </div>
    </div>
</div>
