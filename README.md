# ⚡ SKY Starterkit — Enterprise Modular Laravel & Livewire

Starterkit modular enterprise siap pakai berbasis **Laravel 13**, **Livewire 3/4**, **Tailwind CSS 4**, dan **Spatie Laravel-Permission v8**. Dirancang khusus untuk membangun aplikasi bisnis, dashboard SaaS, POS, dan sistem manajemen berskala besar dengan kecepatan Single Page Application (SPA).

---

## 🚀 Fitur Unggulan

* **Multi-Role & Dynamic Permission Matrix (`/permissions`)**:
  * Matriks perizinan visual berbasis checkbox real-time.
  * Otomatis mengelompokkan kartu modul baru tanpa koding ulang file PHP saat permission baru didaftarkan.
* **Dynamic Sidebar Navigation (`config/navigation.php`)**:
  * Menu sidebar otomatis muncul atau tersembunyi sesuai hak akses pengguna (`$user->can(...)`).
* **User Impersonation**:
  * Fitur Super Admin bisa "menyamar / login" sebagai akun staf lain untuk pengujian atau troubleshooting tanpa perlu mengetahui password mereka.
* **Activity Logs & Audit Trail (`/activity-logs`)**:
  * Mencatat setiap aksi pengguna secara otomatis lengkap dengan modul, deskripsi, IP Address, dan user-agent.
* **App Settings Manager (`/settings`)**:
  * Pengaturan profil bisnis, nama toko, logo, dan kontak dengan sistem caching performa tinggi.
* **Instant SPA Speed with `wire:navigate`**:
  * Navigasi antar halaman instan tanpa kedip/reload browser dengan tetap 100% menggunakan PHP & Blade.
* **Clean UI & Strict Vector SVG**:
  * 100% bebas dari emoji OS. Menggunakan icon SVG outline modern yang tajam dan konsisten.
* **Koleksi Komponen Blade Siap Pakai**:
  * `<x-page-header>`, `<x-button>`, `<x-table>`, `<x-card>`, `<x-form.search>`, `<x-form.input>`, `<x-confirm-dialog>`.

---

## 🛠️ Tech Stack

* **Backend**: Laravel 13 (PHP 8.3+)
* **Fullstack Logic**: Laravel Livewire v3/v4 + Alpine.js
* **Styling**: Tailwind CSS v4 (`@tailwindcss/vite`)
* **Access Control**: Spatie Laravel-Permission v8
* **Image Engine**: Intervention Image v4
* **Database**: MySQL / MariaDB (Laragon / cPanel)

---

## ⚡ Panduan Instalasi Cepat di Laragon

1. **Clone atau Letakkan Projek di Laragon**:
   ```bash
   cd c:\laragon\www\sky-starterkit
   ```

2. **Setup Konfigurasi Environment**:
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

3. **Pastikan Database MySQL Dibuat**:
   Buat database bernama `sky_starterkit` di phpMyAdmin / HeidiSQL Laragon, atau sesuaikan nama database di `.env`.

4. **Jalankan Migrasi & Data Awal**:
   ```bash
   php artisan migrate --seed
   ```

5. **Akses Aplikasi di Browser**:
   * URL: `http://localhost/sky-starterkit/public` atau `http://sky-starterkit.test`
   * **Akun Super Admin**:
     * Email: `admin@sky.test`
     * Password: `password`
   * **Akun Staf Admin**:
     * Email: `staff@sky.test`
     * Password: `password`

---

## 📖 Panduan Penambahan Modul Baru (Runbook)

Panduan teknis dan standar pembuatan modul CRUD baru tersedia lengkap pada file:
`.agents/skills/sky-starterkit/SKILL.md`
