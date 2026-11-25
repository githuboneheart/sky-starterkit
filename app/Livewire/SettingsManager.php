<?php

namespace App\Livewire;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingsManager extends Component
{
    use WithFileUploads;

    public string $activeTab = 'general';

    // 1. General & Company
    public string $app_name = '';
    public string $app_tagline = '';
    public string $app_description = '';
    public $new_logo_light;
    public ?string $current_logo_light = null;
    public $new_logo_dark;
    public ?string $current_logo_dark = null;
    public $new_favicon;
    public ?string $current_favicon = null;

    public string $company_name = '';
    public string $company_short_name = '';
    public string $company_phone = '';
    public string $company_email = '';
    public string $company_address = '';
    public string $company_working_hours = '';

    // 2. Social Media
    public string $social_instagram = '';
    public string $social_tiktok = '';
    public string $social_youtube = '';
    public string $social_facebook = '';

    // 3. WhatsApp Gateway
    public string $whatsapp_provider = 'fonnte';
    public string $whatsapp_server_url = '';
    public string $whatsapp_api_token = '';
    public string $whatsapp_sender_number = '';
    public string $whatsapp_welcome_message = '';
    public string $test_wa_number = '';

    // 4. Payment Gateway
    public string $payment_gateway_provider = 'midtrans';
    public string $payment_gateway_environment = 'sandbox';
    public string $payment_gateway_merchant_id = '';
    public string $payment_gateway_client_key = '';
    public string $payment_gateway_server_key = '';

    // 5. Manual Payment & QRIS
    public array $bank_accounts = [];
    public $new_qris_image;
    public ?string $current_qris_image = null;
    public string $manual_payment_instruction = '';

    public function mount(): void
    {
        $this->loadSettings();
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function loadSettings(): void
    {
        // 1. General & Company
        $this->app_name = setting('app_name', 'MBM Starterkit');
        $this->app_tagline = setting('app_tagline', '');
        $this->app_description = setting('app_description', '');
        $this->current_logo_light = setting('app_logo_light');
        $this->current_logo_dark = setting('app_logo_dark');
        $this->current_favicon = setting('app_favicon');

        $this->company_name = setting('company_name', 'PT Maju Bersama Medika');
        $this->company_short_name = setting('company_short_name', 'MBM');
        $this->company_phone = setting('company_phone', '');
        $this->company_email = setting('company_email', '');
        $this->company_address = setting('company_address', '');
        $this->company_working_hours = setting('company_working_hours', '');

        // 2. Social Media
        $this->social_instagram = setting('social_instagram', '');
        $this->social_tiktok = setting('social_tiktok', '');
        $this->social_youtube = setting('social_youtube', '');
        $this->social_facebook = setting('social_facebook', '');

        // 3. WhatsApp
        $this->whatsapp_provider = setting('whatsapp_provider', 'fonnte');
        $this->whatsapp_server_url = setting('whatsapp_server_url', 'https://jakarta.wablas.com');
        $this->whatsapp_api_token = setting('whatsapp_api_token', '');
        $this->whatsapp_sender_number = setting('whatsapp_sender_number', '');
        $this->whatsapp_welcome_message = setting('whatsapp_welcome_message', '');

        // 4. Payment Gateway
        $this->payment_gateway_provider = setting('payment_gateway_provider', 'midtrans');
        $this->payment_gateway_environment = setting('payment_gateway_environment', 'sandbox');
        $this->payment_gateway_merchant_id = setting('payment_gateway_merchant_id', '');
        $this->payment_gateway_client_key = setting('payment_gateway_client_key', '');
        $this->payment_gateway_server_key = setting('payment_gateway_server_key', '');

        // 5. Manual Payment
        $bankJson = setting('manual_bank_accounts');
        if ($bankJson && is_string($bankJson)) {
            $this->bank_accounts = json_decode($bankJson, true) ?? [];
        } elseif (is_array($bankJson)) {
            $this->bank_accounts = $bankJson;
        } else {
            $this->bank_accounts = [
                ['bank' => 'BCA', 'account_number' => '1234567890', 'account_name' => 'PT MAJU BERSAMA MEDIKA'],
            ];
        }

        $this->current_qris_image = setting('manual_qris_image');
        $this->manual_payment_instruction = setting('manual_payment_instruction', '');
    }

    // Dynamic bank accounts management
    public function addBankAccount(): void
    {
        $this->bank_accounts[] = [
            'bank' => '',
            'account_number' => '',
            'account_name' => $this->company_name ?: 'PT MAJU BERSAMA MEDIKA',
        ];
    }

    public function removeBankAccount(int $index): void
    {
        unset($this->bank_accounts[$index]);
        $this->bank_accounts = array_values($this->bank_accounts);
    }

    public function saveGeneral(): void
    {
        $this->validate([
            'app_name' => 'required|string|max:100',
            'company_name' => 'required|string|max:150',
            'company_phone' => 'nullable|string|max:30',
            'company_email' => 'nullable|email|max:100',
            'new_logo_light' => 'nullable|image|max:2048',
            'new_logo_dark' => 'nullable|image|max:2048',
            'new_favicon' => 'nullable|file|extensions:ico,png,svg|max:1024',
        ]);

        if ($this->new_logo_light) {
            if ($this->current_logo_light) {
                \App\Services\ImageService::delete($this->current_logo_light);
            }
            $path = compress_and_store_image(
                file: $this->new_logo_light,
                directory: 'settings',
                disk: 'public',
                maxWidth: 800,
                quality: 90,
                format: 'webp'
            );
            AppSetting::set('app_logo_light', $path, 'general', 'image');
            $this->current_logo_light = $path;
            $this->new_logo_light = null;
        }

        if ($this->new_logo_dark) {
            if ($this->current_logo_dark) {
                \App\Services\ImageService::delete($this->current_logo_dark);
            }
            $path = compress_and_store_image(
                file: $this->new_logo_dark,
                directory: 'settings',
                disk: 'public',
                maxWidth: 800,
                quality: 90,
                format: 'webp'
            );
            AppSetting::set('app_logo_dark', $path, 'general', 'image');
            $this->current_logo_dark = $path;
            $this->new_logo_dark = null;
        }

        if ($this->new_favicon) {
            if ($this->current_favicon) {
                \App\Services\ImageService::delete($this->current_favicon);
            }
            $path = compress_and_store_image(
                file: $this->new_favicon,
                directory: 'settings',
                disk: 'public',
                maxWidth: 256,
                quality: 90
            );
            AppSetting::set('app_favicon', $path, 'general', 'image');
            $this->current_favicon = $path;
            $this->new_favicon = null;
        }

        AppSetting::set('app_name', $this->app_name, 'general');
        AppSetting::set('app_tagline', $this->app_tagline, 'general');
        AppSetting::set('app_description', $this->app_description, 'general');

        AppSetting::set('company_name', $this->company_name, 'company');
        AppSetting::set('company_short_name', $this->company_short_name, 'company');
        AppSetting::set('company_phone', $this->company_phone, 'company');
        AppSetting::set('company_email', $this->company_email, 'company');
        AppSetting::set('company_address', $this->company_address, 'company');
        AppSetting::set('company_working_hours', $this->company_working_hours, 'company');

        activity_log('UPDATE', 'Setting', 'Memperbarui identitas aplikasi dan profil legal perusahaan');
        $this->dispatch('toast', type: 'success', message: 'Pengaturan Identitas & Profil PT berhasil disimpan!');

        $this->dispatch('app-settings-updated',
            app_name: $this->app_name,
            company_name: $this->company_name,
            company_short_name: $this->company_short_name,
            logo_light: $this->current_logo_light ? Storage::url($this->current_logo_light) : null,
            logo_dark: $this->current_logo_dark ? Storage::url($this->current_logo_dark) : null,
            favicon: $this->current_favicon ? Storage::url($this->current_favicon) : null,
        );
    }

    public function saveSocial(): void
    {
        AppSetting::set('social_instagram', $this->social_instagram, 'social');
        AppSetting::set('social_tiktok', $this->social_tiktok, 'social');
        AppSetting::set('social_youtube', $this->social_youtube, 'social');
        AppSetting::set('social_facebook', $this->social_facebook, 'social');

        activity_log('UPDATE', 'Setting', 'Memperbarui tautan media sosial resmi');
        $this->dispatch('toast', type: 'success', message: 'Tautan Media Sosial berhasil disimpan!');
    }

    public function saveWhatsApp(): void
    {
        $this->validate([
            'whatsapp_provider' => 'required|string',
            'whatsapp_sender_number' => 'nullable|string|max:20',
        ]);

        AppSetting::set('whatsapp_provider', $this->whatsapp_provider, 'whatsapp');
        AppSetting::set('whatsapp_server_url', $this->whatsapp_server_url, 'whatsapp');
        AppSetting::set('whatsapp_api_token', $this->whatsapp_api_token, 'whatsapp');
        AppSetting::set('whatsapp_sender_number', $this->whatsapp_sender_number, 'whatsapp');
        AppSetting::set('whatsapp_welcome_message', $this->whatsapp_welcome_message, 'whatsapp');

        activity_log('UPDATE', 'Setting', 'Memperbarui konfigurasi WhatsApp Gateway');
        $this->dispatch('toast', type: 'success', message: 'Konfigurasi WhatsApp Gateway berhasil disimpan!');
    }

    public function testWhatsApp(): void
    {
        $this->validate([
            'test_wa_number' => 'required|string|min:9',
        ], [
            'test_wa_number.required' => 'Masukkan nomor WhatsApp tujuan uji coba.',
        ]);

        // Simulated test dispatch
        activity_log('SYSTEM', 'WhatsApp', "Mengirim pesan WhatsApp uji coba ke {$this->test_wa_number}");
        $this->dispatch('toast', type: 'info', message: "Simulasi pesan WhatsApp uji coba terkirim ke {$this->test_wa_number}!");
    }

    public function savePaymentGateway(): void
    {
        AppSetting::set('payment_gateway_provider', $this->payment_gateway_provider, 'payment_gateway');
        AppSetting::set('payment_gateway_environment', $this->payment_gateway_environment, 'payment_gateway');
        AppSetting::set('payment_gateway_merchant_id', $this->payment_gateway_merchant_id, 'payment_gateway');
        AppSetting::set('payment_gateway_client_key', $this->payment_gateway_client_key, 'payment_gateway');
        AppSetting::set('payment_gateway_server_key', $this->payment_gateway_server_key, 'payment_gateway');

        activity_log('UPDATE', 'Setting', "Memperbarui konfigurasi Payment Gateway ({$this->payment_gateway_provider} - {$this->payment_gateway_environment})");
        $this->dispatch('toast', type: 'success', message: 'Pengaturan Payment Gateway berhasil disimpan!');
    }

    public function saveManualPayment(): void
    {
        $this->validate([
            'bank_accounts.*.bank' => 'required|string',
            'bank_accounts.*.account_number' => 'required|string',
            'bank_accounts.*.account_name' => 'required|string',
            'new_qris_image' => 'nullable|image|max:2048',
        ]);

        if ($this->new_qris_image) {
            if ($this->current_qris_image) {
                \App\Services\ImageService::delete($this->current_qris_image);
            }
            $path = compress_and_store_image(
                file: $this->new_qris_image,
                directory: 'settings',
                disk: 'public',
                maxWidth: 1000,
                quality: 85,
                format: 'webp'
            );
            AppSetting::set('manual_qris_image', $path, 'manual_payment', 'image');
            $this->current_qris_image = $path;
            $this->new_qris_image = null;
        }

        AppSetting::set('manual_bank_accounts', json_encode(array_values($this->bank_accounts)), 'manual_payment', 'json');
        AppSetting::set('manual_payment_instruction', $this->manual_payment_instruction, 'manual_payment');

        activity_log('UPDATE', 'Setting', 'Memperbarui daftar rekening transfer bank dan gambar QRIS');
        $this->dispatch('toast', type: 'success', message: 'Pengaturan Pembayaran Manual & QRIS berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.settings-manager');
    }
}
