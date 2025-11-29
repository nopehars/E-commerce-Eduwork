# Dependencies & Struktur Database — `eduwork-ecommerce`

Dokumen ini menjelaskan semua package/library yang digunakan di project ini beserta fungsinya, serta struktur database dan relasi antar tabel.

---

## Dependencies PHP (Composer)

### Production Dependencies

#### `laravel/framework` (^12.0)

-   **Fungsi**: Framework web utama untuk backend development.
-   **Apa yang dipakai**: Routing, ORM Eloquent, middleware, migration, validation, dll.

#### `intervention/image` (^3.11)

-   **Fungsi**: Library untuk manipulasi dan kompresi gambar.
-   **Digunakan untuk**: Kompresi otomatis gambar produk sebelum disimpan ke storage.
-   **Driver**: GD (built-in PHP, tidak perlu extension tambahan).
-   **Detail implementasi**: Di `app/Services/ImageCompressionService.php`
    -   Resize otomatis jika lebar > 2000px.
    -   Kompresi adaptif: mulai quality 85%, turun 5% setiap iterasi sampai file size <= target (default 1MB).
    -   Simpan hasil ke `storage/app/public/products/`.

#### `laravel/tinker` (^2.10.1)

-   **Fungsi**: Interactive PHP shell untuk debugging dan eksplorasi model.
-   **Perintah**: `php artisan tinker`.

### Development Dependencies

#### `laravel/breeze` (^2.3)

-   **Fungsi**: Scaffolding autentikasi minimal dan modern.
-   **Apa yang disediakan**:
    -   User registration dan login (blade views).
    -   Password reset.
    -   Email verification (opsional).
    -   Session-based authentication (bukan API token).
-   **File yang dibuat** (setelah `php artisan breeze:install`):
    -   Routes: `routes/auth.php`.
    -   Controllers: `app/Http/Controllers/Auth/`.
    -   Views: `resources/views/auth/`, `resources/views/layouts/`.

#### `fakerphp/faker` (^1.23)

-   **Fungsi**: Generate fake/dummy data untuk seeding dan testing.
-   **Dipakai di**: `database/factories/` untuk membuat factory model.

#### `pestphp/pest` (^3.8)

-   **Fungsi**: Modern testing framework (alternatif PHPUnit).
-   **Fitur**: Syntax ringan, API fluent, parallel testing.
-   **Perintah**: `./vendor/bin/pest` atau `php artisan test`.

#### `pestphp/pest-plugin-laravel` (^3.2)

-   **Fungsi**: Plugin Pest untuk integrasi Laravel (helper, assertions, dll).

#### `laravel/pint` (^1.24)

-   **Fungsi**: Code formatter & linter (PHP).
-   **Perintah**: `./vendor/bin/pint` atau `./vendor/bin/pint --test`.

#### `laravel/sail` (^1.41)

-   **Fungsi**: Docker development environment (opsional).
-   **Alternatif**: Gunakan lokal stack (PHP, MySQL, Redis) tanpa Docker.

#### `laravel/pail` (^1.2.2)

-   **Fungsi**: Real-time log viewer di CLI.
-   **Perintah**: `php artisan pail`.

#### `nunomaduro/collision` (^8.6)

-   **Fungsi**: Error/exception handler yang cantik dan informatif di CLI.

#### `mockery/mockery` (^1.6)

-   **Fungsi**: Mocking framework untuk unit testing.

---

## Dependencies Node.js (npm)

### Devevelopment Dependencies

#### `@tailwindcss/vite` (^4.1.17)

-   **Fungsi**: Plugin Tailwind untuk Vite (CSS framework utility-first).
-   **Apa yang disediakan**:
    -   Hot module reload (HMR) untuk CSS.
    -   Automatic purging unused styles.
    -   Config: `tailwind.config.js`.

#### `@tailwindcss/forms` (^0.5.2)

-   **Fungsi**: Plugin official Tailwind untuk styling form elements.
-   **Apa yang ditingkatkan**: `<input>`, `<select>`, `<checkbox>`, `<radio>`, dll.

#### `tailwindcss` (^3.4.18)

-   **Fungsi**: CSS framework utility-first (class-based styling).
-   **Entry**: `resources/css/app.css` — `@tailwind` directives.

#### `vite` (^7.0.7)

-   **Fungsi**: Modern frontend build tool & dev server.
-   **Fungsi**:
    -   Dev server dengan HMR (live reload).
    -   Build production assets (minified, optimized).
    -   Config: `vite.config.js`.
-   **Perintah**: `npm run dev` (dev) / `npm run build` (production).

#### `laravel-vite-plugin` (^2.0.0)

-   **Fungsi**: Plugin Vite untuk integrasi Laravel.
-   **Apa yang disediakan**:
    -   Blade macro `@vite(['resources/js/app.js', 'resources/css/app.css'])`.
    -   Manifest file untuk production assets.

#### `postcss` (^8.4.31)

-   **Fungsi**: CSS transpiler & transformer.
-   **Plugin**: `autoprefixer` (auto-prefix vendor CSS properties).
-   **Config**: `postcss.config.js`.

#### `autoprefixer` (^10.4.2)

-   **Fungsi**: Plugin PostCSS untuk auto-prefix CSS (contoh: `-webkit-`, `-moz-`).

#### `alpinejs` (^3.4.2)

-   **Fungsi**: Minimal JavaScript framework (direktif DOM).
-   **Digunakan**: Interactive UI elements tanpa harus nulis vanilla JS banyak.
-   **Contoh**: `x-show`, `x-if`, `x-on:click`, `x-model`, dll.

#### `axios` (^1.11.0)

-   **Fungsi**: HTTP client untuk AJAX requests.
-   **Digunakan**: Communicate dengan API backend tanpa reload page.

#### `concurrently` (^9.0.1)

-   **Fungsi**: Run multiple CLI commands in parallel.
-   **Dipakai di**: Script `composer dev` untuk run server + queue + vite bersamaan.

---

## Struktur Database

Database terdiri dari 10 tabel utama (sesuai migrations). Berikut relasi dan deskripsi tiap tabel:

### Tabel Utama

#### `users`

-   **Fungsi**: Menyimpan data pengguna (customer & admin).
-   **Kolom penting**:
    -   `id` (Primary Key)
    -   `name`, `email`, `password`, `phone`
    -   `is_admin` (boolean, default false) — untuk membedakan admin vs customer.
    -   `email_verified_at`, `remember_token`
    -   `created_at`, `updated_at` (timestamps)
-   **Relasi**:
    -   1 user `hasMany` addresses
    -   1 user `hasMany` cart items
    -   1 user `hasMany` transactions

#### `addresses`

-   **Fungsi**: Menyimpan alamat pengiriman pengguna (multiple per user).
-   **Kolom**: `id`, `user_id` (FK), `full_name`, `phone`, `street`, `city`, `province`, `postal_code`, `is_default`
-   **Relasi**:
    -   Many addresses `belongsTo` user
    -   1 address `hasMany` transactions

#### `categories`

-   **Fungsi**: Kategori produk (contoh: Electronics, Fashion, Food).
-   **Kolom**: `id`, `name`, `slug`, `description`, `active`
-   **Relasi**:
    -   1 category `hasMany` products

#### `products`

-   **Fungsi**: Katalog produk yang dijual.
-   **Kolom penting**:
    -   `id`, `category_id` (FK), `sku`, `name`, `slug`
    -   `short_description`, `description` (text)
    -   `price` (integer, dalam rupiah)
    -   `stock` (integer)
    -   `active` (boolean)
    -   `created_at`, `updated_at`
-   **Relasi**:
    -   Many products `belongsTo` category
    -   1 product `hasMany` product_images
    -   1 product `hasMany` cart_items
    -   1 product `hasMany` transaction_items

#### `product_images`

-   **Fungsi**: Gambar produk (multiple per product).
-   **Kolom**: `id`, `product_id` (FK), `image_path`, `position`, `alt_text`
-   **Proses**: Gambar di-compress menggunakan `ImageCompressionService` sebelum disimpan.
-   **Relasi**:
    -   Many images `belongsTo` product

#### `cart_items`

-   **Fungsi**: Item keranjang belanja user (temporary).
-   **Kolom**: `id`, `user_id` (FK), `product_id` (FK), `quantity`, `created_at`, `updated_at`
-   **Relasi**:
    -   Many cart items `belongsTo` user
    -   Many cart items `belongsTo` product

#### `transactions`

-   **Fungsi**: Pesanan/transaksi pembelian dari user.
-   **Kolom penting**:
    -   `id`, `user_id` (FK), `address_id` (FK, nullable)
    -   `status` (pending, paid, shipped, delivered, cancelled)
    -   `total_amount` (integer, rupiah)
    -   `shipping_fee` (integer)
    -   `payment_method` (card, bank_transfer, e_wallet, dll)
    -   `payment_gateway_id` (untuk integrasi payment gateway, mis. Midtrans)
    -   `paid_at` (timestamp, null jika belum dibayar)
    -   `created_at`, `updated_at`
-   **Relasi**:
    -   Many transactions `belongsTo` user
    -   Many transactions `belongsTo` address
    -   1 transaction `hasMany` transaction_items

#### `transaction_items`

-   **Fungsi**: Detail item dalam satu transaksi (itemized).
-   **Kolom**: `id`, `transaction_id` (FK), `product_id` (FK), `quantity`, `price_at_time` (harga saat beli)
-   **Catatan**: Simpan `price_at_time` agar history transaksi tetap akurat meski harga produk berubah.
-   **Relasi**:
    -   Many items `belongsTo` transaction
    -   Many items `belongsTo` product

#### `password_reset_tokens`

-   **Fungsi**: Token untuk reset password.
-   **Kolom**: `email` (primary key), `token`, `created_at`

#### `sessions`

-   **Fungsi**: Session data (session-based auth Breeze).
-   **Kolom**: `id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`

#### `cache` & `jobs` (Laravel defaults)

-   **Fungsi**: Cache dan job queue storage (opsional, sesuai config).

---

## Diagram ER (Entity Relationship) Singkat

```
┌─────────────┐
│   users     │
├─────────────┤
│ id (PK)     │
│ name        │
│ email       │ ◄────┐
│ is_admin    │      │
│ phone       │      │
└─────────────┘      │
       │ (1)         │
       │             │
       ├─ hasMany ──────► addresses (FK: user_id)
       │             │
       ├─ hasMany ──────► cart_items (FK: user_id)
       │             │
       └─ hasMany ──────► transactions (FK: user_id)
                     │
                     │
                     │
  ┌──────────────┐  │
  │ categories   │  │
  ├──────────────┤  │
  │ id (PK)      │  │
  │ name         │  │
  │ slug         │  │
  └──────────────┘  │
       │            │
       │ (1)        │
       │            │
       └─ hasMany ──────► products (FK: category_id)
                    │
                    │
  ┌──────────────────┐
  │   products       │
  ├──────────────────┤
  │ id (PK)          │
  │ category_id (FK) │
  │ sku              │
  │ name, slug       │
  │ price, stock     │
  └──────────────────┘
       │ (1)
       ├─ hasMany ──────► product_images
       │
       └─ hasMany ──────► transaction_items

  ┌──────────────────────┐
  │   transactions       │
  ├──────────────────────┤
  │ id (PK)              │
  │ user_id (FK)         │
  │ address_id (FK)      │
  │ status               │
  │ total_amount         │
  │ payment_gateway_id   │ ◄── Midtrans integration
  │ paid_at              │
  └──────────────────────┘
       │ (1)
       └─ hasMany ──────► transaction_items
```

---

## Fitur Khusus & Integrasi

### 1. Image Compression (`ImageCompressionService`)

-   **Library**: `intervention/image` (v3 dengan GD driver).
-   **Apa yang dilakukan**:
    -   Kompresi otomatis saat upload gambar produk.
    -   Resize jika lebar > 2000px.
    -   Adaptive quality compression (mulai 85%, turun sampai file size <= 1MB).
    -   Simpan ke `storage/app/public/products/` dengan nama hash.
-   **File**: `app/Services/ImageCompressionService.php`.
-   **Dipakai di**: Controller upload product images.

### 2. Payment Gateway — Midtrans (Placeholder)

-   **File**: `app/Services/MidtransService.php` (implementation tergantung kebutuhan).
-   **Apa yang direncanakan**:
    -   Integrasi dengan Midtrans payment gateway.
    -   Snap integration (payment button).
    -   Handle webhook dari Midtrans untuk status update.
    -   Update `transactions.status` dan `paid_at` saat pembayaran sukses.
-   **DB Relation**: `transactions.payment_gateway_id` menyimpan transaction ID dari Midtrans.

### 3. Authentication (Breeze + Policies)

-   **Library**: `laravel/breeze` (session-based).
-   **Policy**: `app/Policies/AddressPolicy.php` — kontrol siapa bisa edit/delete alamat.
-   **Middleware**: Autentikasi dan otorisasi di `app/Http/Middleware/`.

### 4. Testing & Quality Assurance

-   **Test Framework**: Pest (modern, syntax lebih clean).
-   **Code Linting**: Pint (`./vendor/bin/pint`).
-   **Faker**: Generate dummy data untuk seeding/testing.

---

## Instalasi & Setup Dependencies

Saat first setup, jalankan:

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Run migrations & seeding (optional)
php artisan migrate
php artisan db:seed

# Build frontend
npm run build
```

Untuk development dengan live reload:

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Frontend Vite + Tailwind
npm run dev

# Terminal 3 (optional): Queue listener (jika ada job)
php artisan queue:listen
```

Atau gunakan script composer yang sudah disediakan:

```bash
composer dev
```

---

## Quick Reference: Mana dependency untuk apa?

| Kebutuhan         | Package                             | Lokasi                                     |
| ----------------- | ----------------------------------- | ------------------------------------------ |
| Framework web     | `laravel/framework`                 | Backend utama                              |
| Autentikasi       | `laravel/breeze`                    | Routes, views, controllers                 |
| Kompresi gambar   | `intervention/image`                | `app/Services/ImageCompressionService.php` |
| Build frontend    | `vite`, `laravel-vite-plugin`       | `vite.config.js`, `resources/`             |
| CSS framework     | `tailwindcss`, `@tailwindcss/forms` | `tailwind.config.js`, `resources/css/`     |
| Interactive UI    | `alpinejs`                          | Blade templates                            |
| AJAX requests     | `axios`                             | JavaScript files                           |
| Testing           | `pestphp/pest`                      | `tests/` folder                            |
| Code formatting   | `laravel/pint`                      | CLI command                                |
| Dummy data        | `fakerphp/faker`                    | `database/factories/`                      |
| Payment (planned) | `MidtransService.php`               | Belum fully implemented                    |

---

## Catatan Penting

1. **Midtrans Integration**: File `app/Services/MidtransService.php` sudah ada placeholder, tapi implementasi penuh (Snap, webhook) belum. Pastikan install Midtrans official SDK jika ingin production-ready: `composer require midtrans/midtrans-php`.

2. **Image Compression**: Jika server tidak ada extension PHP GD, gunakan `ImageMagick` sebagai driver. Ubah di constructor `ImageCompressionService.php`:

    ```php
    use Intervention\Image\Drivers\Imagick\Driver;
    ```

    Dan install: `composer require intervention/image-imagick`.

3. **Environment Variables**: Setup `.env` dengan:

    - Database credentials (`DB_*`)
    - Mail config (`MAIL_*`)
    - Midtrans keys (`MIDTRANS_*`) — jika dipakai.

4. **Storage Symlink**: Run `php artisan storage:link` setelah setup agar `storage/app/public/` bisa diakses via `public/storage/`.
