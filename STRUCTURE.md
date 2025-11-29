# Struktur Proyek — `eduwork-ecommerce`

Dokumen ini menjelaskan struktur folder dan file utama pada proyek `eduwork-ecommerce` agar anggota tim cepat paham letak kode dan tugas tiap bagian.

## Ringkasan singkat

-   `artisan` : CLI entry point Laravel.
-   `composer.json` : dependensi PHP + script composer.
-   `package.json` : dependensi Node + script (Vite, Tailwind).
-   `SETUP.md`, `README.md` : panduan setup dan dokumentasi singkat.

## Diagram — Struktur file (tree) & relasi komponen

Berikut diagram pohon sederhana (ASCII) menunjukkan struktur direktori utama:

```
eduwork-ecommerce/
├─ artisan
├─ composer.json
├─ package.json
├─ SETUP.md
├─ README.md
├─ STRUCTURE.md
├─ app/
│  ├─ Http/
│  │  ├─ Controllers/
│  │  ├─ Middleware/
│  │  └─ Requests/
│  ├─ Models/
│  ├─ Policies/
│  ├─ Services/
│  └─ View/Components/
├─ bootstrap/
├─ config/
├─ database/
│  ├─ migrations/
│  ├─ factories/
│  └─ seeders/
├─ public/
│  ├─ index.php
│  └─ build/
├─ resources/
│  ├─ views/
│  ├─ css/
│  └─ js/
├─ routes/
├─ storage/
└─ tests/
```

Diagram relasi komponen (sederhana):

```
Browser --> public/index.php --> Laravel Router (routes/web.php)
	--> Controller (app/Http/Controllers)
	--> Model (app/Models) <--> Database (migrations)
	--> View (resources/views) + Assets (resources/js, css)

Services eksternal (app/Services) --> dipanggil oleh Controller / Job
Policies (app/Policies) --> digunakan oleh Controller / Gates untuk otorisasi
```

Keterangan:

-   Arrow (`-->`) menunjukkan alur permintaan/ketergantungan utama.
-   Gunakan tree di atas sebagai referensi saat menavigasi proyek.

---

## Folder & file penting

### `app/`

-   Lokasi kode aplikasi utama.
-   `Http/Controllers/` : controller yang menangani request HTTP.
-   `Http/Middleware/` : middleware (autentikasi, filter, dll.).
-   `Http/Requests/` : form request classes (validasi request secara terpusat).
-   `Models/` : model Eloquent (contoh: `User.php`, `Product.php`, `Transaction.php`, `Address.php`).
-   `Policies/` : kebijakan otorisasi untuk model/resource.
-   `Services/` : layanan reusable / integrasi eksternal (mis. `MidtransService.php`).
-   `View/Components/` : Blade components (komponen tampilan yang bisa dipakai ulang).

### `bootstrap/`

-   File bootstrap Laravel (`app.php`, `providers.php`) dan cache bootstrap.

### `config/`

-   Konfigurasi aplikasi (database, session, mail, queue, services, dll.).

### `database/`

-   `migrations/` : skrip migrasi database (schema versioning).
-   `factories/` : model factories untuk testing dan seeding.
-   `seeders/` : seeder untuk mengisi data awal (contoh: `DatabaseSeeder.php`).

### `public/`

-   `index.php` : entry point public web server.
-   `storage/` : link ke `storage/app/public` (hasil `php artisan storage:link`).
-   `build/` : bundle/assets hasil build Vite (manifest, js/css hasil build).

### `resources/`

-   `views/` : Blade templates (layout dan view aplikasi).
-   `css/`, `js/` : source assets untuk Vite/Tailwind.

### `routes/`

-   `web.php`, `auth.php`, `console.php` : definisi route aplikasi (web, auth, console commands).

### `storage/`

-   Tempat penyimpanan runtime: logs, cache, sessions, compiled views.

### `tests/`

-   `Feature/` dan `Unit/` : test-suite (Pest / PHPUnit).

### `vendor/`

-   Dependensi Composer (otomatis di-generate; jangan diedit manual).

---

## File konfigurasi frontend & tools

-   `vite.config.js` : konfigurasi Vite (build dev/production).
-   `tailwind.config.js` : konfigurasi TailwindCSS.
-   `postcss.config.js` : konfigurasi PostCSS.
-   `phpunit.xml` atau `Pest.php` : konfigurasi testing.

---

## Alur kerja ringkas (where to change what)

-   Tambah/ubah logic backend → `app/Http/Controllers/`, `app/Models/`, `routes/`.
-   Ubah schema DB → buat file baru di `database/migrations/`.
-   Siapkan data testing → `database/factories/` dan `database/seeders/`.
-   Ubah tampilan → `resources/views/` dan `resources/js` / `resources/css`.
-   Build frontend (lokal/dev) → `npm install` lalu `npm run dev`.
-   Jalankan server Laravel → `php artisan serve`.

---

## Catatan & best practices

-   Jangan commit `vendor/` atau `node_modules/` jika tidak diperlukan.
-   Simpan rahasia di `.env` (tidak di-commit).
-   Setiap perubahan schema tanggapi dengan migrasi baru.
-   Sync branch `main` dari upstream sebelum kerja fitur (lihat `SETUP.md`).
