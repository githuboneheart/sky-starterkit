<x-layouts.app>
    <x-slot:header>
        <x-page-header
            title="Audit Log Aktivitas"
            subtitle="Pencatatan riwayat audit keamanan, login, dan perubahan konfigurasi data sistem."
            class="!mb-0"
        />
    </x-slot:header>

    <livewire:activity-log-viewer />
</x-layouts.app>
