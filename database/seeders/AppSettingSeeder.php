<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'group'       => 'general',
                'key'         => 'app_name',
                'value'       => 'SKY Starterkit',
                'type'        => 'string',
                'label'       => 'Nama Aplikasi',
                'description' => 'Nama brand sistem yang tampil di judul dan navigasi.',
            ],
            [
                'group'       => 'general',
                'key'         => 'app_tagline',
                'value'       => 'Enterprise Modular Laravel Starterkit',
                'type'        => 'string',
                'label'       => 'Slogan Aplikasi',
                'description' => 'Slogan singkat aplikasi.',
            ],
            [
                'group'       => 'general',
                'key'         => 'app_description',
                'value'       => 'Starterkit enterprise modular berbasis Laravel 13, Livewire 3/4, dan Tailwind CSS 4.',
                'type'        => 'string',
                'label'       => 'Deskripsi Aplikasi',
                'description' => 'Deskripsi profil sistem.',
            ],
            [
                'group'       => 'company',
                'key'         => 'company_name',
                'value'       => 'Sky Media Studio',
                'type'        => 'string',
                'label'       => 'Nama Perusahaan / Bisnis',
                'description' => 'Nama institusi atau entitas bisnis pemilik sistem.',
            ],
            [
                'group'       => 'company',
                'key'         => 'company_email',
                'value'       => 'admin@sky.test',
                'type'        => 'string',
                'label'       => 'Email Resmi',
                'description' => 'Alamat email operasional dan layanan bantuan.',
            ],
            [
                'group'       => 'company',
                'key'         => 'company_phone',
                'value'       => '0812-3456-7890',
                'type'        => 'string',
                'label'       => 'No. WhatsApp / Telepon',
                'description' => 'Kontak customer care atau kasir toko.',
            ],
        ];

        foreach ($settings as $setting) {
            AppSetting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
