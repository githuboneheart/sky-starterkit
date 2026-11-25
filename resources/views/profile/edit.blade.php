<x-layouts.app>
    <x-slot:header>
        <div>
            <h1 class="text-xl font-bold text-slate-900 dark:text-white leading-tight">
                Profil Pengguna & Keamanan
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                Kelola informasi akun pribadi dan perbarui kata sandi Anda.
            </p>
        </div>
    </x-slot:header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: User Identity Card -->
        <div class="space-y-6">
            <x-card>
                <div class="text-center">
                    <img
                        src="{{ $user->avatar_url }}"
                        alt="{{ $user->name }}"
                        class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-blue-100 dark:border-blue-950 shadow-md mb-4"
                    />
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">{{ $user->name }}</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</p>

                    <div class="mt-4 flex flex-wrap justify-center gap-1.5">
                        @foreach ($user->roles as $role)
                            <x-badge variant="primary" size="sm">{{ $role->name }}</x-badge>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-800 text-xs space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Nomor Telepon</span>
                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $user->phone ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Terdaftar Sejak</span>
                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Login Terakhir</span>
                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $user->last_login_at?->diffForHumans() ?? 'Sesi Pertama' }}</span>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Right: Forms (Edit Profile & Update Password) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Edit Profile Information -->
            <x-card title="Informasi Profil" subtitle="Perbarui nama, kontak, dan foto profil Anda">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <x-form.input label="Nama Lengkap" name="name" value="{{ old('name', $user->name) }}" required />
                    <x-form.input label="Alamat Email" type="email" name="email" value="{{ old('email', $user->email) }}" required />
                    <x-form.input label="Nomor WhatsApp / HP" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="081234567890" />

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Ganti Foto Profil / Avatar
                        </label>
                        <input
                            type="file"
                            name="avatar"
                            accept="image/*"
                            class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-950 dark:file:text-blue-300 cursor-pointer"
                        />
                        <p class="text-[11px] text-slate-400 mt-1">Format gambar: JPG, PNG, WEBP (Maksimal 2MB).</p>
                    </div>

                    <div class="flex justify-end pt-3">
                        <x-button type="submit" variant="primary">
                            Simpan Perubahan Profil
                        </x-button>
                    </div>
                </form>
            </x-card>

            <!-- Update Password -->
            <x-card title="Ganti Kata Sandi" subtitle="Pastikan akun Anda menggunakan kata sandi yang kuat dan aman">
                <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <x-form.input label="Kata Sandi Saat Ini" type="password" name="current_password" required />
                    <x-form.input label="Kata Sandi Baru" type="password" name="password" placeholder="Minimal 8 karakter" required />
                    <x-form.input label="Konfirmasi Kata Sandi Baru" type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" required />

                    <div class="flex justify-end pt-3">
                        <x-button type="submit" variant="secondary">
                            Perbarui Kata Sandi
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-layouts.app>
