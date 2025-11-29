## Pengingat Git — Sinkronisasi dengan upstream

Jika kamu melakukan fork repository, penting untuk tetap sinkron dengan repository asal (disebut `upstream`) agar tidak ketinggalan perubahan dari tim inti. Berikut rangkaian perintah yang umum dipakai (jalankan di terminal `cmd`):

```cmd
# (hanya perlu dilakukan sekali) tambahkan remote upstream yang menunjuk ke repository asal
git remote add upstream https://github.com/iqbaldarusallam/E-commerce-Eduwork.git

# ambil update dari upstream
git fetch upstream

# pindah ke branch main lokal lalu tarik perubahan dari upstream/main
git checkout main
git pull upstream main

# dorong pembaruan main ke fork milikmu (origin)
git push origin main

# contoh bila bekerja di feature branch:
git checkout feature/my-feature
# gabungkan perubahan main ke feature (pilih merge atau rebase sesuai kebijakan tim)
git merge main
# lalu push branch ke origin
git push origin feature/my-feature
```

Penjelasan singkat tujuan:

-   `git remote add upstream ...`: mendaftarkan repository asal (hanya perlu sekali setelah fork).
-   `git fetch upstream`: mengambil semua referensi dan commit terbaru dari upstream tanpa melakukan merge otomatis.
-   `git pull upstream main`: mengambil dan menggabungkan perubahan dari `upstream/main` ke branch lokal saat ini (umumnya `main`).
-   `git push origin <branch>`: mengirim commit dari lokal ke repository fork di GitHub (`origin`).
-   Untuk feature branch, integrasikan perubahan dari `main` (merge atau rebase) lalu push ke `origin` sebelum membuat PR.

Gunakan rangkaian di atas sebagai pengingat rutin sebelum memulai pekerjaan baru, untuk mengurangi konflik dan memastikan PR-mu up-to-date.

---

## Setup - Jalankan aplikasi setelah fork/clone

Panduan ini ditujukan agar anggota tim dapat menjalankan project ini setelah melakukan fork atau clone.

## 3. Install PHP dependencies (Composer)

```cmd
composer install
```

## 4. Copy file environment dan generate app key

```cmd
copy .env.example .env
php artisan key:generate
```

Edit `.env` sesuai lingkunganmu (DB*CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD, MAIL*\_, MIDTRANS\_\_ dll.)

Contoh minimal yang mesti disesuaikan:

-   `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
-   `APP_URL` (mis. `http://127.0.0.1:8000`)

## 5. Database: migrasi & seed (opsional)

```cmd
php artisan migrate
# jika ada seeder
php artisan db:seed
```

## 6. Storage & permissions

Untuk menyajikan file yang diupload ke `public/storage`:

```cmd
php artisan storage:link
```

## 7. Install Node dependencies dan jalankan Vite (Tailwind)

Project ini menggunakan Vite + Tailwind. Jalankan:

```cmd
npm install
npm run dev
```

Penjelasan singkat:

-   `npm install` menginstall `tailwindcss`, `vite`, `laravel-vite-plugin`, dll.
-   `npm run dev` menjalankan Vite dev server (live reload). Jika ingin build produksi gunakan `npm run build`.

Jika developer ingin memisahkan proses Laravel dan Vite, kamu bisa jalankan `php artisan serve` di terminal lain:

```cmd
php artisan serve
# lalu buka http://127.0.0.1:8000
```

Catatan: Jika Vite berjalan di port lain (mis. 5173), layout sudah menggunakan `@vite([...])`, sehingga assets akan di-load dari dev server.

## Tips

-   Selalu sync branch `main` upstream sebelum memulai fitur baru.
-   Commit message singkat dan jelas (mis. feat: add product search, fix: cart subtotal bug)
-   Jika menambahkan package Node/PHP, sertakan instruksi update di PR (mis. npm install, composer update).

---
