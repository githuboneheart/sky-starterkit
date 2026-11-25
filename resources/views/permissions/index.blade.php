<x-layouts.app>
    <x-slot:header>
        <x-page-header
            title="Permission Matrix & Hak Akses"
            subtitle="Kelola daftar hak akses per role secara interaktif dengan switch toggle realtime."
            class="!mb-0"
        />
    </x-slot:header>

    <livewire:permission-matrix :roleId="request('roleId')" />
</x-layouts.app>
