---
name: sky-starterkit
description: >-
  Master technical guide and development runbook for SKY Starterkit (Enterprise Laravel 13, Livewire 3, Tailwind 4).
  Use whenever building or modifying modules, creating database migrations, registering permissions,
  implementing row-level data authorization, using UI components, or configuring gateways.
---

# ⚡ SKY Starterkit — Developer & AI Agent Runbook

This skill guides you through the architecture, conventions, and implementation patterns of the **SKY Starterkit** (Laravel 13, Livewire 3, Tailwind 4, Alpine.js, Spatie Permission v8, Intervention Image v4).

---

## 📋 The "New Module" Checklist (STRICT PROCEDURE)

Whenever you are asked to build a new feature or module (e.g. from a `PRD.md`), follow this exact 7-step checklist:

### Step 1: Migration & Model with Data Ownership
1. Generate migration and model:
   ```bash
   php artisan make:model Order -m
   ```
2. If data belongs to a specific owner (e.g., student, doctor, client, user), add the `HasDataOwnership` trait:
   ```php
   namespace App\Models;

   use App\Traits\HasDataOwnership;
   use Illuminate\Database\Eloquent\Model;

   class Order extends Model
   {
       use HasDataOwnership;

       protected $fillable = ['user_id', 'order_number', 'amount', 'status'];
   }
   ```

### Step 2: Register Permissions & Dynamic Navigation (NEVER SKIP)
1. **Daftarkan Permission di `config/permission_list.php`:**
   Setiap kali membuat model atau modul baru, AI Agent **WAJIB** menambahkan izinnya ke dalam `config/permission_list.php`:
   ```php
   'Order Management' => [
       'orders.view_all' => 'Lihat seluruh pesanan pengguna',
       'orders.view_own' => 'Hanya lihat pesanan miliknya sendiri',
       'orders.create'   => 'Buat pesanan baru',
       'orders.edit'     => 'Ubah pesanan',
       'orders.delete'   => 'Hapus pesanan',
       'orders.export'   => 'Ekspor rekap pesanan',
   ],
   ```
2. **Auto-Sync Tanpa Perlu Seeder Terminal:**
   * Halaman `/permissions` otomatis melakukan sinkronisasi saat dibuka!
   * Member atau developer **TIDAK PERLU MENGETIK** `php artisan db:seed` secara manual.
   * Super Admin otomatis menerima 100% izin baru tersebut secara instan.
3. **Dynamic Sidebar Registration (`config/navigation.php`):**
   * Register the menu item in `config/navigation.php` under the appropriate group with `'permission' => 'orders.view'` and `'active' => 'orders.*'`:
   ```php
   [
       'title'      => 'Pesanan',
       'route'      => 'orders.index',
       'active'     => 'orders.*',
       'permission' => 'orders.view',
       'icon'       => 'orders', // Or available icon: home, users, shield, matrix, cog, clock
   ],
   ```
   * **Never hardcode static menus in Blade!** The sidebar automatically checks `$user->can('orders.view')` and omits the entire group if the user has no permissions.

### Step 3: Register Multi-Page Routes (`routes/web.php`)
**MANDATORY RULE:** Always register full-page Livewire components for multi-page CRUD. Group routes under `auth` middleware:
```php
use App\Livewire\Orders\OrderIndex;
use App\Livewire\Orders\OrderCreate;
use App\Livewire\Orders\OrderEdit;

// Orders Module (Multi-page CRUD with wire:navigate SPA speed)
Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', OrderIndex::class)->middleware('can:orders.view')->name('index');
    Route::get('/create', OrderCreate::class)->middleware('can:orders.create')->name('create');
    Route::get('/{order}/edit', OrderEdit::class)->middleware('can:orders.edit')->name('edit');
    // Optional Show / Detail Page:
    // Route::get('/{order}', OrderShow::class)->middleware('can:orders.view')->name('show');
});
```

### Step 4: Implement Separated Livewire Components (`app/Livewire/{Module}/`)
**STRICT RULE:** NEVER write monolithic 1-file CRUD! Always create separate dedicated classes in `app/Livewire/{Module}/`:

1. **`app/Livewire/Orders/OrderIndex.php`** (Tabel, Search, Pagination & Delete Confirmation):
```php
namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrderIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $orderToDeleteId = null;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $this->orderToDeleteId = $id;
        $this->dispatch('open-modal', 'confirm-delete');
    }

    public function delete(): void
    {
        $order = Order::findOrFail($this->orderToDeleteId);
        $orderNumber = $order->order_number;
        $order->delete();

        activity_log('DELETE', 'Order', "Pesanan #{$orderNumber} dihapus");
        $this->dispatch('close-modal', 'confirm-delete');
        $this->dispatch('toast', type: 'success', message: 'Pesanan berhasil dihapus.');
    }

    public function render()
    {
        $orders = Order::forCurrentUser(
            viewAllPermission: 'orders.view_all',
            viewOwnPermission: 'orders.view_own',
            ownerColumn: 'user_id'
        )
        ->when($this->search, fn($q) => $q->where('order_number', 'like', "%{$this->search}%"))
        ->latest()
        ->paginate(10);

        return view('livewire.orders.index', compact('orders'))
            ->layout('components.layouts.app', ['title' => 'Daftar Pesanan']);
    }
}
```

2. **`app/Livewire/Orders/OrderCreate.php`** (Form Tambah Baru & Simpan):
```php
namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;

class OrderCreate extends Component
{
    public string $order_number = '';
    public float $amount = 0;

    protected function rules(): array
    {
        return [
            'order_number' => ['required', 'string', 'max:50', 'unique:orders,order_number'],
            'amount'       => ['required', 'numeric', 'min:0'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();
        $validated['user_id'] = auth()->id();

        $order = Order::create($validated);
        activity_log('CREATE', 'Order', "Membuat pesanan baru #{$order->order_number}");

        session()->flash('success', 'Pesanan baru berhasil ditambahkan!');
        $this->redirect(route('orders.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.orders.create')
            ->layout('components.layouts.app', ['title' => 'Tambah Pesanan Baru']);
    }
}
```

3. **`app/Livewire/Orders/OrderEdit.php`** (Form Edit & Update):
```php
namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;

class OrderEdit extends Component
{
    public Order $order;
    public string $order_number = '';
    public float $amount = 0;

    public function mount(Order $order): void
    {
        $this->order = $order;
        $this->order_number = $order->order_number;
        $this->amount = (float) $order->amount;
    }

    protected function rules(): array
    {
        return [
            'order_number' => ['required', 'string', 'max:50', 'unique:orders,order_number,' . $this->order->id],
            'amount'       => ['required', 'numeric', 'min:0'],
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();
        $this->order->update($validated);
        activity_log('UPDATE', 'Order', "Mengubah data pesanan #{$this->order->order_number}");

        session()->flash('success', 'Perubahan pesanan berhasil disimpan!');
        $this->redirect(route('orders.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.orders.edit')
            ->layout('components.layouts.app', ['title' => 'Edit Pesanan']);
    }
}
```

### Step 5: Build Separated Blade Views (`resources/views/livewire/{module}/`)
**STRICT RULE:** NEVER put table and create/edit forms in a single Blade file. Always separate them into individual view files and use `wire:navigate` for instant SPA navigation:

1. **`resources/views/livewire/orders/index.blade.php`** (Halaman Tabel Utama):
```blade
<div>
    <x-slot:header>
        <x-page-header title="Daftar Pesanan" subtitle="Kelola transaksi dan pesanan pelanggan.">
            <x-slot:action>
                @can('orders.create')
                    <x-button href="{{ route('orders.create') }}" wire:navigate variant="primary">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Pesanan
                    </x-button>
                @endcan
            </x-slot:action>
        </x-page-header>
    </x-slot:header>

    <!-- Modern Unified Toolbar (Search & Filter Controls) -->
    <x-toolbar>
        <x-slot:filters>
            <div class="w-full sm:w-72">
                <x-form.search
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari nomor pesanan..."
                />
            </div>

            <!-- Optional Select Filter Example -->
            {{--
            <x-form.select-filter wire:model.live="statusFilter" :active="$statusFilter !== ''">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="completed">Selesai</option>
            </x-form.select-filter>
            --}}

            @if ($search !== '')
                <button
                    type="button"
                    wire:click="$set('search', '')"
                    class="h-10 inline-flex items-center gap-1.5 px-3 rounded-xl text-xs font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/40 dark:hover:bg-rose-900/50 border border-rose-200/60 dark:border-rose-900/40 transition duration-150 cursor-pointer"
                    title="Reset pencarian"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Reset</span>
                </button>
            @endif
        </x-slot:filters>
    </x-toolbar>

    <!-- Data Table -->
    <x-table>
        <x-slot:head>
            <x-table.th>No. Pesanan</x-table.th>
            <x-table.th>Jumlah</x-table.th>
            <x-table.th align="right">Aksi</x-table.th>
        </x-slot:head>
        @forelse ($orders as $order)
            <tr>
                <x-table.td>{{ $order->order_number }}</x-table.td>
                <x-table.td>Rp {{ number_format($order->amount, 0, ',', '.') }}</x-table.td>
                <x-table.td align="right">
                    <x-table.actions>
                        @can('orders.edit')
                            <x-action-button type="edit" href="{{ route('orders.edit', $order) }}" wire:navigate />
                        @endcan
                        @can('orders.delete')
                            <x-action-button type="delete" wire:click="confirmDelete({{ $order->id }})" />
                        @endcan
                    </x-table.actions>
                </x-table.td>
            </tr>
        @empty
            <tr><td colspan="3" class="text-center py-8 text-slate-400">Belum ada data pesanan.</td></tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>

    <!-- Delete Confirmation Modal -->
    <x-confirm-dialog
        name="confirm-delete"
        title="Konfirmasi Hapus Pesanan"
        description="Apakah Anda yakin ingin menghapus pesanan ini? Tindakan ini permanen."
        confirmAction="delete"
    />
</div>
```

2. **`resources/views/livewire/orders/create.blade.php`** (Halaman Form Tambah):
```blade
<div>
    <x-slot:header>
        <x-page-header title="Tambah Pesanan Baru" subtitle="Isi formulir berikut untuk membuat pesanan baru.">
            <x-slot:action>
                <x-button href="{{ route('orders.index') }}" wire:navigate variant="outline">
                    &larr; Kembali ke Daftar
                </x-button>
            </x-slot:action>
        </x-page-header>
    </x-slot:header>

    <x-card class="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form.input label="Nomor Pesanan" wire:model="order_number" placeholder="Contoh: ORD-2026-001" required />
            <x-form.input label="Jumlah (Rp)" type="number" wire:model="amount" placeholder="0" required />

            <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-100 dark:border-slate-800">
                <x-button href="{{ route('orders.index') }}" wire:navigate variant="outline">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary" loading="save">
                    Simpan Pesanan
                </x-button>
            </div>
        </form>
    </x-card>
</div>
```

3. **`resources/views/livewire/orders/edit.blade.php`** (Halaman Form Edit):
```blade
<div>
    <x-slot:header>
        <x-page-header title="Edit Pesanan #{{ $order->order_number }}" subtitle="Perbarui rincian data pesanan.">
            <x-slot:action>
                <x-button href="{{ route('orders.index') }}" wire:navigate variant="outline">
                    &larr; Kembali ke Daftar
                </x-button>
            </x-slot:action>
        </x-page-header>
    </x-slot:header>

    <x-card class="max-w-3xl">
        <form wire:submit="save" class="space-y-5">
            <x-form.input label="Nomor Pesanan" wire:model="order_number" required />
            <x-form.input label="Jumlah (Rp)" type="number" wire:model="amount" required />

            <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-100 dark:border-slate-800">
                <x-button href="{{ route('orders.index') }}" wire:navigate variant="outline">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary" loading="save">
                    Simpan Perubahan
                </x-button>
            </div>
        </form>
    </x-card>
</div>
```

### Step 6: Global Image Upload (If Module Involves Photos / Documents)
Use the global helper `compress_and_store_image()` for auto-WebP conversion, EXIF auto-orient, and proportional downscaling:
```php
$path = compress_and_store_image(
    file: $this->receipt_photo,
    directory: 'orders',
    disk: 'public',
    maxWidth: 1000,
    quality: 85,
    format: 'webp'
);
```

### Step 7: Verification & Tests (MANDATORY BEFORE DONE)
Always run the test command before considering the task done:
```bash
npm run build
php artisan optimize:clear
php artisan test
```

---

## 🎨 UI Guidelines & Color Palette

- **Global Design Token:** Strictly use **`primary-*`** classes (`bg-primary-600`, `text-primary-600`, `focus:ring-primary-500/20`, etc.). Defined in `resources/css/app.css` via `@theme` (Default: Royal Blue `#2563EB`).
- **FORBIDDEN:** 
  - Do **NOT** use purple, violet, fuchsia, or indigo.
  - Do **NOT** hardcode `blue-600` or raw color names in views. Always use `primary-*`.
- **Global Blade Component Catalog:**
  - `<x-page-header title="..." subtitle="...">` with optional `<x-slot:action>`
  - `<x-button variant="primary|secondary|danger|warning|success|outline|ghost">`
  - `<x-form.search wire:model.live.debounce.300ms="..." placeholder="..." />`
  - `<x-form.datepicker wire:model="..." label="..." />` (auto Indonesian locale: Senin, Selasa, etc.)
  - `<x-form.input>`, `<x-form.select>`, `<x-form.textarea>`, `<x-form.toggle>`
  - `<x-table>`, `<x-table.th>`, `<x-table.td>`, `<x-table.actions>`
  - `<x-action-button type="view|edit|delete|impersonate" wire:click="..." />`
  - `<x-confirm-dialog name="..." title="..." description="..." confirmAction="..." />`
  - `<x-stat-card title="..." value="..." trend="up|down" trendValue="..." />`
  - `<x-badge variant="primary|success|danger|warning|info|gray" :dot="true">`
  - `<x-card title="..." subtitle="...">`
  - `<x-modal name="..." title="..." maxWidth="lg">`
  - `<x-skeleton type="text|avatar|card|table" :lines="3" />` (with smooth `.animate-shimmer` wave)
- **Dark Mode:** Use Tailwind class variant `.dark`. Always pair `bg-white` with `dark:bg-slate-900`, `text-slate-800` with `dark:text-slate-100`, `border-slate-200` with `dark:border-slate-800`.
- **Micro-Interactions (100ms - 200ms):** Tactile button click feedback (`active:scale-[0.98]`), Card soft hover lift (`hover:-translate-y-0.5 hover:shadow-md`).

---

## 🔑 Helper Functions Quick Reference

```php
// 1. Fetch system setting with fallback
$appName = setting('app_name', 'SKY Starterkit');
$phone   = setting('company_phone');

// 2. Audit Trail Log
activity_log('CREATE', 'Order', "User membuat pesanan baru #{$order->order_number}");

// 3. Global Image Compression (Intervention Image v4)
$path = compress_and_store_image(
    file: $this->photo,
    directory: 'orders',
    maxWidth: 800,
    quality: 85,
    format: 'webp'
);
// Delete previous image if exists:
\App\Services\ImageService::delete($order->receipt_image);

// 4. Impersonation Check
if (is_impersonating()) {
    // Current user is being impersonated by Super Admin
}

// 5. Toast Notifications from Livewire
$this->dispatch('toast', type: 'success', message: 'Data berhasil disimpan!');
$this->dispatch('toast', type: 'error', message: 'Terjadi kesalahan sistem.');
```

---

## 📖 Related Master Documentation

* [**PROMPT.md** (Master PRD Implementation Blueprint)](../../PROMPT.md)
* [**STARTERKIT_GUIDE.md** (Comprehensive Technical Reference)](../../STARTERKIT_GUIDE.md)
