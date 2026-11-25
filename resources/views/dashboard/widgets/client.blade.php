@props(['clientData', 'user'])

<div class="space-y-6">
    <!-- Header Section Indicator -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-extrabold text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-primary-600"></span>
                Portal Layanan Siswa Taruna & Pasien
            </h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Informasi keikutsertaan program bimbel Academy13 & perawatan terapi Fisio13 Anda</p>
        </div>
        <x-badge variant="primary" :dot="true">Status: Terdaftar Aktif</x-badge>
    </div>

    <!-- 1. Digital Membership Card & Quick Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Digital Card (Taruna / Pasien ID) -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-primary-950 to-slate-900 text-white p-6 shadow-xl border border-primary-500/30 flex flex-col justify-between group">
            <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-primary-500/20 rounded-full blur-2xl group-hover:scale-125 transition-transform duration-500 pointer-events-none"></div>

            <div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-primary-600 flex items-center justify-center font-extrabold text-white text-sm shadow-md">
                            M
                        </div>
                        <div>
                            <span class="text-xs font-extrabold tracking-wide block leading-none">MBM PLATFORM</span>
                            <span class="text-[10px] text-primary-300 font-semibold tracking-wider uppercase">Academy13 & Fisio13</span>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[10px] font-bold">
                        VERIFIED
                    </span>
                </div>

                <div class="mt-4">
                    <span class="text-[11px] text-slate-400 uppercase tracking-widest block font-medium">Nomor Registrasi Anggota</span>
                    <p class="text-lg font-mono font-extrabold text-white tracking-widest mt-0.5">
                        {{ $clientData['registration_number'] }}
                    </p>
                </div>

                <div class="mt-4">
                    <span class="text-[11px] text-slate-400 uppercase tracking-widest block font-medium">Nama Lengkap</span>
                    <p class="text-base font-bold text-white tracking-tight mt-0.5">
                        {{ $user->name }}
                    </p>
                </div>
            </div>

            <div class="pt-6 border-t border-white/10 mt-6 flex items-center justify-between text-xs text-slate-300">
                <div>
                    <span class="text-[10px] text-slate-400 block">WhatsApp Terdaftar</span>
                    <span class="font-semibold text-white">{{ $user->phone ?? '0812-XXXX-XXXX' }}</span>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-slate-400 block">Tahun Angkatan</span>
                    <span class="font-semibold text-white">{{ date('Y') }}</span>
                </div>
            </div>
        </div>

        <!-- 2 Metric Cards Column -->
        <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-5">
            <!-- Metric 1: Sesi Bimbel Minggu Ini -->
            <x-stat-card
                title="Sesi Belajar Minggu Ini"
                value="{{ $clientData['metrics']['study_sessions_this_week'] }} Sesi"
                trend="up"
                trendValue="Jadwal aktif"
                variant="primary"
                description="Kelas persiapan tes kedinasan"
            />

            <!-- Metric 2: Sesi Fisioterapi Tersisa -->
            <x-stat-card
                title="Sesi Terapi Tersisa"
                value="{{ $clientData['metrics']['therapy_sessions_remaining'] }} Sesi"
                trend="up"
                trendValue="Paket aktif"
                variant="success"
                description="Koreksi postur & samapta"
            />

            <!-- Metric 3: Skor Tryout Terakhir -->
            <x-stat-card
                title="Skor Tryout CAT SKD"
                value="{{ $clientData['metrics']['latest_tryout_score'] }}"
                trend="up"
                trendValue="Target 400 (Lulus)"
                variant="warning"
                description="Simulasi CAT standar BKN"
            />
        </div>
    </div>

    <!-- 2. Main Split: Upcoming Agenda (2 Cols) & Hotline/Program Info (1 Col) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Upcoming Schedules & Timeline -->
        <div class="lg:col-span-2">
            <x-card title="Jadwal & Agenda Terdekat Anda" subtitle="Rangkaian jadwal kelas bimbel dan reservasi klinik fisioterapi Anda">
                <div class="space-y-4">
                    @foreach ($clientData['upcoming_schedules'] as $schedule)
                        <div class="p-4 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-primary-500/40 transition">
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-xl {{ $schedule['type'] === 'bimbel' ? 'bg-primary-500/10 text-primary-600 dark:text-primary-400' : ($schedule['type'] === 'fisio' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-amber-500/10 text-amber-600 dark:text-amber-400') }} flex items-center justify-center shrink-0">
                                    @if ($schedule['type'] === 'bimbel')
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    @elseif ($schedule['type'] === 'fisio')
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-sm font-bold text-slate-900 dark:text-white leading-tight">
                                            {{ $schedule['title'] }}
                                        </h4>
                                    </div>
                                    <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500 dark:text-slate-400">
                                        <span class="flex items-center gap-1 font-semibold text-slate-700 dark:text-slate-300">
                                            <svg class="w-3.5 h-3.5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $schedule['time'] }}
                                        </span>
                                        <span>&bull;</span>
                                        <span>Instruktur: {{ $schedule['instructor'] }}</span>
                                        <span>&bull;</span>
                                        <span>Lokasi: {{ $schedule['location'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <x-badge :variant="$schedule['type'] === 'bimbel' ? 'primary' : ($schedule['type'] === 'fisio' ? 'success' : 'warning')" size="sm">
                                {{ $schedule['status'] }}
                            </x-badge>
                        </div>
                    @endforeach
                </div>
            </x-card>
        </div>

        <!-- Program Aktif & Bantuan Support -->
        <div class="space-y-6">
            <!-- Program Terdaftar -->
            <x-card title="Program Aktif Anda" subtitle="Layanan yang Anda ikuti saat ini">
                <div class="space-y-3">
                    @foreach ($clientData['programs'] as $prog)
                        <div class="p-3.5 rounded-xl border border-slate-200/70 dark:border-slate-800 bg-white dark:bg-slate-950 flex items-center justify-between gap-2 text-xs">
                            <span class="font-bold text-slate-800 dark:text-slate-200">{{ $prog['name'] }}</span>
                            <x-badge :variant="$prog['badge']" size="sm">{{ $prog['status'] }}</x-badge>
                        </div>
                    @endforeach
                </div>
            </x-card>

            <!-- Hotline Support -->
            <x-card title="Pusat Bantuan & Layanan" subtitle="Butuh reschedule atau informasi konsultasi?">
                <div class="text-xs text-slate-600 dark:text-slate-400 space-y-3">
                    <p>Tim admin ruko MBM siap membantu Anda untuk jadwal ulang bimbingan maupun perawatan terapi postur.</p>
                    <a
                        href="https://wa.me/{{ setting('company_phone', '6281200000000') }}"
                        target="_blank"
                        class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition active:scale-95"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.007c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.043.101-.116.433-.506.549-.68.116-.173.231-.145.39-.086s1.011.477 1.184.564.289.13.332.202c.043.073.043.419-.101.824z" />
                        </svg>
                        Hubungi Admin via WhatsApp
                    </a>
                </div>
            </x-card>
        </div>
    </div>
</div>
