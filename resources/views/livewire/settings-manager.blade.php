<div class="flex flex-col lg:flex-row items-start gap-8" x-data="{ currentTab: @entangle('activeTab') }">
    <!-- Left Navigation Tabs (Desktop) / Horizontal Tabs (Mobile) -->
    <div class="w-full lg:w-64 shrink-0 bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-2.5 shadow-xs">
        <nav class="flex lg:flex-col gap-1.5 overflow-x-auto pb-2 lg:pb-0 scrollbar-none">
            <!-- Tab 1: General & PT -->
            <button
                type="button"
                @click="currentTab = 'general'"
                :class="currentTab === 'general' ? 'bg-primary-600 text-white shadow-sm shadow-primary-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-150 text-left cursor-pointer"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span>Identitas & PT</span>
            </button>

            <!-- Tab 2: Social Media -->
            <button
                type="button"
                @click="currentTab = 'social'"
                :class="currentTab === 'social' ? 'bg-primary-600 text-white shadow-sm shadow-primary-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-150 text-left cursor-pointer"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                </svg>
                <span>Media Sosial</span>
            </button>

            <!-- Tab 3: WhatsApp Gateway -->
            <button
                type="button"
                @click="currentTab = 'whatsapp'"
                :class="currentTab === 'whatsapp' ? 'bg-primary-600 text-white shadow-sm shadow-primary-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-150 text-left cursor-pointer"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <span>WhatsApp Gateway</span>
            </button>

            <!-- Tab 4: Metode Pembayaran (Unified) -->
            <button
                type="button"
                @click="currentTab = 'payment'"
                :class="currentTab === 'payment' ? 'bg-primary-600 text-white shadow-sm shadow-primary-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800'"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all duration-150 text-left cursor-pointer"
            >
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                <span>Metode Pembayaran</span>
            </button>
        </nav>
    </div>

    <!-- Right Settings Panel Content -->
    <div class="flex-1 w-full bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-xs">
        <!-- ================= TAB 1: IDENTITAS & PT ================= -->
        <div x-show="currentTab === 'general'" x-cloak>
            <div class="border-b border-slate-100 dark:border-slate-800/80 pb-4 mb-6">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Identitas Aplikasi & Profil Perusahaan</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Informasi ini ditampilkan pada header sistem, footer, nota struk kasir, dan kartu riwayat pasien.
                </p>
            </div>

                <form wire:submit="saveGeneral" class="space-y-6">
                    <!-- Brand Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input label="Nama Aplikasi" wire:model="app_name" placeholder="SKY Starterkit" required />
                        <x-form.input label="Tagline / Slogan" wire:model="app_tagline" placeholder="Modern Enterprise Starterkit" />
                    </div>

                    <x-form.textarea label="Deskripsi Singkat" wire:model="app_description" rows="2" />

                    <!-- Logo Uploaders Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-2">
                        <!-- Light Logo -->
                        <div class="p-4 border border-slate-200 dark:border-slate-800 rounded-xl bg-slate-50/50 dark:bg-slate-950/30">
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2">Logo Light Mode</label>
                            @php
                                $lightUrl = null;
                                if ($new_logo_light) {
                                    try { $lightUrl = $new_logo_light->temporaryUrl(); } catch (\Throwable $e) {}
                                }
                            @endphp
                            @if ($lightUrl)
                                <img src="{{ $lightUrl }}" class="h-12 w-auto mb-3 object-contain rounded" />
                            @elseif ($current_logo_light)
                                <img src="{{ Storage::url($current_logo_light) }}" class="h-12 w-auto mb-3 object-contain rounded" />
                            @else
                                <div class="h-12 w-full border border-dashed border-slate-300 dark:border-slate-700 rounded-lg flex items-center justify-center text-xs text-slate-400 mb-3">Belum ada logo</div>
                            @endif
                            <input type="file" wire:model="new_logo_light" accept="image/*" class="text-xs text-slate-500" />
                        </div>

                        <!-- Dark Logo -->
                        <div class="p-4 border border-slate-200 dark:border-slate-800 rounded-xl bg-slate-50/50 dark:bg-slate-950/30">
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2">Logo Dark Mode</label>
                            @php
                                $darkUrl = null;
                                if ($new_logo_dark) {
                                    try { $darkUrl = $new_logo_dark->temporaryUrl(); } catch (\Throwable $e) {}
                                }
                            @endphp
                            @if ($darkUrl)
                                <img src="{{ $darkUrl }}" class="h-12 w-auto mb-3 object-contain rounded bg-slate-900 p-1" />
                            @elseif ($current_logo_dark)
                                <img src="{{ Storage::url($current_logo_dark) }}" class="h-12 w-auto mb-3 object-contain rounded bg-slate-900 p-1" />
                            @else
                                <div class="h-12 w-full border border-dashed border-slate-300 dark:border-slate-700 rounded-lg flex items-center justify-center text-xs text-slate-400 mb-3">Belum ada logo</div>
                            @endif
                            <input type="file" wire:model="new_logo_dark" accept="image/*" class="text-xs text-slate-500" />
                        </div>

                        <!-- Favicon -->
                        <div class="p-4 border border-slate-200 dark:border-slate-800 rounded-xl bg-slate-50/50 dark:bg-slate-950/30">
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2">Favicon Browser</label>
                            @php
                                $favUrl = null;
                                if ($new_favicon) {
                                    try { $favUrl = $new_favicon->temporaryUrl(); } catch (\Throwable $e) {}
                                }
                            @endphp
                            @if ($favUrl)
                                <img src="{{ $favUrl }}" class="h-8 w-8 mb-3 object-contain rounded" />
                            @elseif ($new_favicon)
                                <div class="h-8 w-8 bg-primary-50 dark:bg-primary-950/60 text-primary-600 dark:text-primary-400 rounded flex items-center justify-center text-[10px] font-bold mb-3 border border-primary-200 dark:border-primary-800">
                                    ICO
                                </div>
                            @elseif ($current_favicon)
                                <img src="{{ Storage::url($current_favicon) }}" class="h-8 w-8 mb-3 object-contain rounded" />
                            @else
                                <div class="h-8 w-8 border border-dashed border-slate-300 dark:border-slate-700 rounded flex items-center justify-center text-[10px] text-slate-400 mb-3">ICO</div>
                            @endif
                            <input type="file" wire:model="new_favicon" accept=".ico,.png,.svg" class="text-xs text-slate-500" />
                        </div>
                    </div>

                    <!-- Company Legal Profile -->
                    <div class="border-t border-slate-100 dark:border-slate-800/80 pt-6">
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Profil Legal Perusahaan</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-form.input label="Nama Resmi Perusahaan (PT/CV)" wire:model="company_name" placeholder="PT SKY Teknologi Indonesia" required />
                            <x-form.input label="Nama Singkat / Brand Umbrella" wire:model="company_short_name" placeholder="SKY Studio" />
                            <x-form.input label="No. Telepon / WhatsApp Resmi" wire:model="company_phone" placeholder="+62 812-3456-7890" />
                            <x-form.input label="Email Korespondensi Resmi" wire:model="company_email" type="email" placeholder="admin@starterkit.test" />
                            <x-form.input label="Jam Operasional Ruko" wire:model="company_working_hours" placeholder="Senin - Jumat: 09:00 - 18:00 WIB" />
                        </div>
                        <div class="mt-4">
                            <x-form.textarea label="Alamat Kantor / Ruko Fisik" wire:model="company_address" rows="2" placeholder="Gedung Cyber 2 Lantai 15, Jl. HR Rasuna Said..." />
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <x-button type="submit" variant="primary" loading="saveGeneral">
                            Simpan Perubahan
                        </x-button>
                    </div>
                </form>
        </div>

        <!-- ================= TAB 2: MEDIA SOSIAL ================= -->
        <div x-show="currentTab === 'social'" x-cloak>
            <div class="border-b border-slate-100 dark:border-slate-800/80 pb-4 mb-6">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Tautan Media Sosial Resmi</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Tautan akun sosial media untuk landing page, portal siswa, dan footer aplikasi.
                </p>
            </div>

            <form wire:submit="saveSocial" class="space-y-4">
                <x-form.input label="Instagram URL" wire:model="social_instagram" placeholder="https://instagram.com/majubersamamedika" />
                <x-form.input label="TikTok URL" wire:model="social_tiktok" placeholder="https://tiktok.com/@majubersamamedika" />
                <x-form.input label="YouTube Channel URL" wire:model="social_youtube" placeholder="https://youtube.com/@majubersamamedika" />
                <x-form.input label="Facebook Page URL" wire:model="social_facebook" placeholder="https://facebook.com/majubersamamedika" />

                <div class="flex justify-end pt-4">
                    <x-button type="submit" variant="primary" loading="saveSocial">
                        Simpan Media Sosial
                    </x-button>
                </div>
            </form>
        </div>

        <!-- ================= TAB 3: WHATSAPP GATEWAY ================= -->
        <div x-show="currentTab === 'whatsapp'" x-cloak x-data="{ waProvider: @entangle('whatsapp_provider') }">
            <div class="border-b border-slate-100 dark:border-slate-800/80 pb-4 mb-6">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Konfigurasi WhatsApp Gateway</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Digunakan untuk mengirim notifikasi jadwal bimbel, appointment fisioterapi, dan bukti struk pembayaran kasir.
                </p>
            </div>

            <form wire:submit="saveWhatsApp" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-form.select label="Provider Gateway" x-model="waProvider" wire:model.live="whatsapp_provider">
                        <option value="fonnte">Fonnte (Rekomendasi)</option>
                        <option value="wablas">Wablas</option>
                        <option value="starsender">Starsender</option>
                        <option value="custom">Custom Webhook</option>
                    </x-form.select>

                    <div x-show="waProvider !== 'custom'">
                        <x-form.input
                            label="Nomor Pengirim (Device Number)"
                            wire:model="whatsapp_sender_number"
                            placeholder="6281234567890"
                            hint="Gunakan kode negara tanpa spasi (contoh: 62812...)"
                        />
                    </div>
                </div>

                <!-- DYNAMIC FIELDS: FONNTE -->
                <div x-show="waProvider === 'fonnte'" class="space-y-4">
                    <x-form.input
                        label="Fonnte API Token"
                        type="password"
                        wire:model="whatsapp_api_token"
                        placeholder="Masukkan token device dari fonnte.com..."
                        hint="Ditemukan di Dashboard Fonnte > Device Settings (Nomor HP pengirim otomatis terhubung dari scan QR)"
                    />
                </div>

                <!-- DYNAMIC FIELDS: WABLAS -->
                <div x-show="waProvider === 'wablas'" x-cloak class="space-y-4">
                    <x-form.input
                        label="Domain Server Wablas"
                        wire:model="whatsapp_server_url"
                        placeholder="Contoh: https://jakarta.wablas.com atau https://solo.wablas.com"
                        hint="Akun Wablas memiliki domain server khusus sesuai penempatan klaster server Anda"
                    />
                    <x-form.input
                        label="Wablas API Token / Secret"
                        type="password"
                        wire:model="whatsapp_api_token"
                        placeholder="Masukkan API token dari wablas.com..."
                        hint="Ditemukan di Dashboard Wablas > Device Management"
                    />
                </div>

                <!-- DYNAMIC FIELDS: STARSENDER -->
                <div x-show="waProvider === 'starsender'" x-cloak class="space-y-4">
                    <x-form.input
                        label="Starsender API Key"
                        type="password"
                        wire:model="whatsapp_api_token"
                        placeholder="Masukkan API Key dari starsender.online..."
                        hint="Ditemukan di Dashboard Starsender > API Keys"
                    />
                </div>

                <!-- DYNAMIC FIELDS: CUSTOM WEBHOOK -->
                <div x-show="waProvider === 'custom'" x-cloak class="space-y-4">
                    <x-form.input
                        label="Custom Webhook Endpoint URL"
                        wire:model="whatsapp_server_url"
                        placeholder="https://api.domain-anda.com/v1/send-message"
                        hint="URL endpoint target HTTP POST yang menerima payload pengiriman notifikasi"
                    />
                    <x-form.input
                        label="Authorization Bearer Token / Secret Header"
                        type="password"
                        wire:model="whatsapp_api_token"
                        placeholder="Bearer eyJhbGciOi..."
                        hint="Header Authorization yang disertakan pada request HTTP"
                    />
                </div>

                <x-form.textarea
                    label="Template Pesan Sambutan Akun Baru"
                    wire:model="whatsapp_welcome_message"
                    rows="3"
                    hint="Gunakan variabel {nama} dan {app_name} untuk mengganti nilai dinamis"
                />

                <div class="flex justify-end pt-4">
                    <x-button type="submit" variant="primary" loading="saveWhatsApp">
                        Simpan Konfigurasi WA
                    </x-button>
                </div>
            </form>

            <!-- Test Send Simulation -->
            <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800/80">
                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-2">Uji Coba Pengiriman Pesan</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
                    Kirim pesan WhatsApp percobaan untuk memverifikasi koneksi gateway aktif.
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <x-form.input wire:model="test_wa_number" placeholder="Contoh: 081234567890" />
                    </div>
                    <x-button type="button" wire:click="testWhatsApp" variant="secondary" loading="testWhatsApp">
                        Kirim Pesan Tes
                    </x-button>
                </div>
            </div>
        </div>

        <!-- ================= TAB 4: METODE PEMBAYARAN (UNIFIED 3 CARDS) ================= -->
        <div x-show="currentTab === 'payment'" x-cloak class="space-y-6">
            <div class="border-b border-slate-100 dark:border-slate-800/80 pb-4">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Pengaturan Metode Pembayaran</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Kelola seluruh saluran penerimaan transaksi: Gateway online otomatis, transfer rekening bank manual, dan QRIS statis kasir.
                </p>
            </div>

            <!-- CARD 1: PAYMENT GATEWAY OTOMATIS -->
            <div class="rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-2xs overflow-hidden transition-all duration-200">
                <!-- Card Header with Toggle -->
                <div class="p-4 sm:p-5 bg-slate-50/70 dark:bg-slate-950/40 border-b border-slate-100 dark:border-slate-800/80 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl {{ $payment_gateway_enabled ? 'bg-primary-50 dark:bg-primary-950/60 text-primary-600 dark:text-primary-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }} flex items-center justify-center shrink-0 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Payment Gateway Otomatis</h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold {{ $payment_gateway_enabled ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-800/60' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 border border-slate-200 dark:border-slate-700' }}">
                                    {{ $payment_gateway_enabled ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Virtual Account (VA), QRIS Dinamis, E-Wallet, dan Kartu Kredit instan via Midtrans/Xendit/Tripay/Duitku.
                            </p>
                        </div>
                    </div>

                    <x-form.toggle wire:model.live="payment_gateway_enabled" size="md" />
                </div>

                <!-- Card Body (Collapsed when OFF) -->
                @if ($payment_gateway_enabled)
                    <div class="p-5 sm:p-6" x-data="{ pgProvider: @entangle('payment_gateway_provider'), pgEnv: @entangle('payment_gateway_environment') }">
                        <form wire:submit="savePaymentGateway" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-form.select label="Provider Gateway" x-model="pgProvider" wire:model.live="payment_gateway_provider">
                                    <option value="midtrans">Midtrans Snap</option>
                                    <option value="xendit">Xendit Invoice</option>
                                    <option value="tripay">Tripay Closed Payment</option>
                                    <option value="duitku">Duitku</option>
                                </x-form.select>

                                <x-form.select label="Lingkungan Transaksi (Environment)" x-model="pgEnv" wire:model.live="payment_gateway_environment">
                                    <option value="sandbox">Sandbox (Uji Coba / Testing)</option>
                                    <option value="production">Production (Live / Transaksi Nyata)</option>
                                </x-form.select>
                            </div>

                            <!-- DYNAMIC FIELDS: MIDTRANS -->
                            <div x-show="pgProvider === 'midtrans'" class="space-y-4">
                                <x-form.input
                                    label="Midtrans Merchant ID"
                                    wire:model="payment_gateway_merchant_id"
                                    placeholder="Contoh: G123456789"
                                    hint="Ditemukan di Dashboard Midtrans > Settings > Access Keys"
                                />
                                <x-form.input
                                    label="Client Key (Public Key)"
                                    wire:model="payment_gateway_client_key"
                                    placeholder="Contoh: SB-Mid-client-XXXXXXXX atau Mid-client-XXXXXXXX"
                                    hint="Digunakan oleh Snap.js di halaman checkout kasir / invoice"
                                />
                                <x-form.input
                                    label="Server Key (Secret Key)"
                                    type="password"
                                    wire:model="payment_gateway_server_key"
                                    placeholder="Contoh: SB-Mid-server-YYYYYYYY atau Mid-server-YYYYYYYY"
                                    hint="Kunci rahasia backend untuk membuat transaksi Snap Token"
                                />
                            </div>

                            <!-- DYNAMIC FIELDS: XENDIT -->
                            <div x-show="pgProvider === 'xendit'" class="space-y-4" x-cloak>
                                <x-form.input
                                    label="Secret API Key"
                                    type="password"
                                    wire:model="payment_gateway_server_key"
                                    placeholder="Contoh: xnd_development_... atau xnd_production_..."
                                    hint="Dibuat melalui Dashboard Xendit > Settings > API Keys"
                                />
                                <x-form.input
                                    label="Webhook Verification Token (Callback Token)"
                                    wire:model="payment_gateway_client_key"
                                    placeholder="Contoh: xnd_callback_token_..."
                                    hint="Ditemukan di Dashboard Xendit > Settings > Callbacks > Webhook Verification Token"
                                />
                                <x-form.input
                                    label="Xendit User ID / Public ID (Opsional)"
                                    wire:model="payment_gateway_merchant_id"
                                    placeholder="Contoh: 60b9... (Opsional)"
                                    hint="ID akun bisnis Xendit Anda (opsional jika menggunakan API Key utama)"
                                />
                            </div>

                            <!-- DYNAMIC FIELDS: TRIPAY -->
                            <div x-show="pgProvider === 'tripay'" class="space-y-4" x-cloak>
                                <x-form.input
                                    label="Kode Merchant (Merchant Code)"
                                    wire:model="payment_gateway_merchant_id"
                                    placeholder="Contoh: T12345"
                                    hint="Ditemukan di Dashboard Tripay > Profil Merchant"
                                />
                                <x-form.input
                                    label="API Key"
                                    wire:model="payment_gateway_client_key"
                                    placeholder="Contoh: DEV-xxxxxx atau prod-xxxxxx"
                                    hint="Kunci akses API Tripay"
                                />
                                <x-form.input
                                    label="Private Key (Secret Key)"
                                    type="password"
                                    wire:model="payment_gateway_server_key"
                                    placeholder="Contoh: xxxx-xxxx-xxxx-xxxx"
                                    hint="Kunci rahasia untuk membuat tanda tangan digital (Signature HMAC)"
                                />
                            </div>

                            <!-- DYNAMIC FIELDS: DUITKU -->
                            <div x-show="pgProvider === 'duitku'" class="space-y-4" x-cloak>
                                <x-form.input
                                    label="Merchant Code Duitku"
                                    wire:model="payment_gateway_merchant_id"
                                    placeholder="Contoh: D12345"
                                    hint="Kode merchant resmi yang diberikan tim Duitku"
                                />
                                <x-form.input
                                    label="Merchant Key / Project API Key"
                                    type="password"
                                    wire:model="payment_gateway_server_key"
                                    placeholder="Contoh: xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                                    hint="Ditemukan di Dashboard Duitku > My Project > Project Details"
                                />
                            </div>

                            <!-- Dynamic Webhook Guide Box -->
                            <div class="p-4 bg-slate-50 dark:bg-slate-950/40 rounded-xl border border-slate-200 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-400 space-y-1.5">
                                <p class="font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                    <span>Webhook & Notification URL:</span>
                                    <span class="px-2 py-0.5 rounded bg-primary-100 dark:bg-primary-950 text-primary-700 dark:text-primary-300 font-mono text-[11px]" x-text="pgProvider.toUpperCase()"></span>
                                </p>
                                <code class="text-primary-600 dark:text-primary-400 font-mono select-all block bg-white dark:bg-slate-900 p-2 rounded-lg border border-slate-200 dark:border-slate-800">{{ url('/api/payment/notification') }}</code>
                                <p class="text-[11px] text-slate-400" x-show="pgProvider === 'midtrans'">
                                    Salin URL di atas ke menu <strong>Settings > Configuration > Payment Notification URL</strong> di Portal Midtrans MAP Anda.
                                </p>
                                <p class="text-[11px] text-slate-400" x-show="pgProvider === 'xendit'" x-cloak>
                                    Salin URL di atas ke menu <strong>Settings > Callbacks > Invoices (paid & expired)</strong> di Dashboard Xendit.
                                </p>
                                <p class="text-[11px] text-slate-400" x-show="pgProvider === 'tripay'" x-cloak>
                                    Salin URL di atas ke menu <strong>Merchant > Edit > Callback URL</strong> di Dashboard Tripay.
                                </p>
                                <p class="text-[11px] text-slate-400" x-show="pgProvider === 'duitku'" x-cloak>
                                    Salin URL di atas ke kolom <strong>Callback URL & Return URL</strong> di pengaturan project Duitku.
                                </p>
                            </div>

                            <div class="flex justify-end pt-2">
                                <x-button type="submit" variant="primary" loading="savePaymentGateway">
                                    Simpan Gateway
                                </x-button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="p-5 text-center bg-slate-50/30 dark:bg-slate-950/20">
                        <p class="text-xs text-slate-400 dark:text-slate-500">
                            Pembayaran otomatis via Gateway sedang dinonaktifkan. Aktifkan toggle di atas untuk menerima transaksi online otomatis.
                        </p>
                    </div>
                @endif
            </div>

            <!-- CARD 2: REKENING TRANSFER BANK MANUAL -->
            <div class="rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-2xs overflow-hidden transition-all duration-200">
                <!-- Card Header with Toggle -->
                <div class="p-4 sm:p-5 bg-slate-50/70 dark:bg-slate-950/40 border-b border-slate-100 dark:border-slate-800/80 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl {{ $manual_bank_enabled ? 'bg-primary-50 dark:bg-primary-950/60 text-primary-600 dark:text-primary-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }} flex items-center justify-center shrink-0 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Transfer Rekening Bank Manual</h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold {{ $manual_bank_enabled ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-800/60' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 border border-slate-200 dark:border-slate-700' }}">
                                    {{ $manual_bank_enabled ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Daftar nomor rekening bank tujuan transfer langsung yang ditampilkan pada invoice kasir atau konfirmasi manual.
                            </p>
                        </div>
                    </div>

                    <x-form.toggle wire:model.live="manual_bank_enabled" size="md" />
                </div>

                <!-- Card Body -->
                @if ($manual_bank_enabled)
                    <div class="p-5 sm:p-6">
                        <form wire:submit="saveManualBank" class="space-y-5">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">Daftar Rekening Bank Aktif</label>
                                <x-button type="button" wire:click="addBankAccount" variant="outline" size="sm">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Rekening
                                </x-button>
                            </div>

                            <!-- Bank Accounts Repeater -->
                            <div class="space-y-3">
                                @forelse ($bank_accounts as $index => $acc)
                                    <div class="flex flex-col sm:flex-row items-center gap-3 p-3.5 bg-slate-50/70 dark:bg-slate-950/40 rounded-xl border border-slate-200 dark:border-slate-800">
                                        <div class="w-full sm:w-1/4">
                                            <input
                                                type="text"
                                                wire:model="bank_accounts.{{ $index }}.bank"
                                                placeholder="Nama Bank (misal BCA)"
                                                class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-3 py-2 text-xs text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition duration-150"
                                                required
                                            />
                                        </div>
                                        <div class="w-full sm:w-1/3">
                                            <input
                                                type="text"
                                                wire:model="bank_accounts.{{ $index }}.account_number"
                                                placeholder="Nomor Rekening"
                                                class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-3 py-2 text-xs text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition duration-150"
                                                required
                                            />
                                        </div>
                                        <div class="w-full sm:w-1/3">
                                            <input
                                                type="text"
                                                wire:model="bank_accounts.{{ $index }}.account_name"
                                                placeholder="Atas Nama (A/N)"
                                                class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-3 py-2 text-xs text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition duration-150"
                                                required
                                            />
                                        </div>
                                        <button
                                            type="button"
                                            wire:click="removeBankAccount({{ $index }})"
                                            class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg transition shrink-0 cursor-pointer"
                                            title="Hapus Rekening"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                @empty
                                    <div class="p-4 text-center border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-400">
                                        Belum ada rekening bank yang ditambahkan. Klik "Tambah Rekening" di atas.
                                    </div>
                                @endforelse
                            </div>

                            <!-- Instructions -->
                            <x-form.textarea
                                label="Petunjuk Pembayaran Transfer"
                                wire:model="manual_payment_instruction"
                                rows="3"
                                placeholder="Contoh: Harap sertakan nomor nota/invoice pada berita transfer dan simpan bukti transfer untuk verifikasi kasir."
                            />

                            <div class="flex justify-end pt-2">
                                <x-button type="submit" variant="primary" loading="saveManualBank">
                                    Simpan Rekening Bank
                                </x-button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="p-5 text-center bg-slate-50/30 dark:bg-slate-950/20">
                        <p class="text-xs text-slate-400 dark:text-slate-500">
                            Metode transfer bank manual sedang dinonaktifkan.
                        </p>
                    </div>
                @endif
            </div>

            <!-- CARD 3: QRIS STATIS KASIR / TOKO -->
            <div class="rounded-2xl border border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-2xs overflow-hidden transition-all duration-200">
                <!-- Card Header with Toggle -->
                <div class="p-4 sm:p-5 bg-slate-50/70 dark:bg-slate-950/40 border-b border-slate-100 dark:border-slate-800/80 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-10 h-10 rounded-xl {{ $manual_qris_enabled ? 'bg-primary-50 dark:bg-primary-950/60 text-primary-600 dark:text-primary-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }} flex items-center justify-center shrink-0 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white">QRIS Statis Kasir / Toko</h4>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold {{ $manual_qris_enabled ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 border border-emerald-200/60 dark:border-emerald-800/60' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 border border-slate-200 dark:border-slate-700' }}">
                                    {{ $manual_qris_enabled ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Gambar barcode QRIS toko yang dapat di-scan langsung oleh pelanggan via mobile banking atau e-wallet di meja kasir.
                            </p>
                        </div>
                    </div>

                    <x-form.toggle wire:model.live="manual_qris_enabled" size="md" />
                </div>

                <!-- Card Body -->
                @if ($manual_qris_enabled)
                    <div class="p-5 sm:p-6">
                        <form wire:submit="saveManualQris" class="space-y-5">
                            <div class="flex flex-col sm:flex-row items-center gap-6 p-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/30">
                                @php
                                    $qrisUrl = null;
                                    if ($new_qris_image) {
                                        try { $qrisUrl = $new_qris_image->temporaryUrl(); } catch (\Throwable $e) {}
                                    }
                                @endphp
                                @if ($qrisUrl)
                                    <img src="{{ $qrisUrl }}" class="w-36 h-36 object-contain bg-white p-2 rounded-xl border border-slate-200 dark:border-slate-800 shadow-xs shrink-0" />
                                @elseif ($current_qris_image)
                                    <img src="{{ Storage::url($current_qris_image) }}" class="w-36 h-36 object-contain bg-white p-2 rounded-xl border border-slate-200 dark:border-slate-800 shadow-xs shrink-0" />
                                @else
                                    <div class="w-36 h-36 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl flex flex-col items-center justify-center text-xs text-slate-400 shrink-0">
                                        <svg class="w-8 h-8 text-slate-300 dark:text-slate-600 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                        </svg>
                                        <span>Belum ada QRIS</span>
                                    </div>
                                @endif

                                <div class="space-y-2 flex-1">
                                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300">File Gambar Barcode QRIS</label>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">
                                        Unggah gambar barcode QRIS resmi toko (format PNG, JPG, maks 2MB). Gambar ini akan otomatis ditampilkan di struk kasir atau faktur tagihan pelanggan.
                                    </p>
                                    <input type="file" wire:model="new_qris_image" accept="image/*" class="text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 cursor-pointer" />
                                </div>
                            </div>

                            <div class="flex justify-end pt-2">
                                <x-button type="submit" variant="primary" loading="saveManualQris">
                                    Simpan QRIS Kasir
                                </x-button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="p-5 text-center bg-slate-50/30 dark:bg-slate-950/20">
                        <p class="text-xs text-slate-400 dark:text-slate-500">
                            QRIS statis kasir sedang dinonaktifkan.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
