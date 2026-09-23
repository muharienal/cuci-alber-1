# Cuci Alber

**Cuci Alber** (Cuci Alat Berat) — aplikasi web pengganti Google Form **"FORM CUCI ALAT BERAT
WILAYAH 1"** untuk pencatatan cuci alat berat (Forklift, Wheel Loader) di akhir shift, lengkap
dengan foto bukti. Dibangun dengan **Laravel 11 + Blade + MySQL**, tanpa build tool frontend
(npm/Vite/Mix) — semua CSS/JS memakai CDN (Bootstrap 5, Chart.js, Google Fonts) dan tampilan
sudah didesain modern (wizard 4 langkah dengan progress indicator, kartu, dan warna yang
konsisten).

Project ini adalah **project Laravel yang sudah lengkap** (bukan sekadar potongan file) —
tinggal `composer install`, atur `.env`, migrate, jalan. Persis seperti clone repo dari GitHub.

## Alur Form Publik (meniru & mengoptimalkan Google Form asli Anda)

1. **Lokasi** — pilih Zona Kerja (pill button) → Area Kerja (otomatis terisi via AJAX sesuai
   Zona yang dipilih — ini **peningkatan** dari form asli yang menampilkan seluruh area kerja
   dalam satu daftar panjang tercampur semua zona).
2. **Unit** — pilih jenis alat (Forklift / Wheel Loader), lalu No. Lambung unit (otomatis
   terfilter sesuai Area Kerja + jenis alat yang dipilih).
3. **Petugas** — Pengawas (dropdown), Shift (1/2/3), Operator ND, dan Operator Grup A–D.
   Begitu No. Lambung dipilih di langkah 2, sistem **otomatis menyarankan (prefill)** operator
   grup A–D sesuai roster unit tersebut — admin/operator tinggal konfirmasi atau ganti bila ada
   penggantian personel.
4. **Bukti Foto** — upload Foto Tampak Samping (wajib, dengan preview & drag-to-click area).

Field yang **tidak** perlu diinput manual: Zona → Area Kerja → Unit Kerja tidak lagi
ditanyakan terpisah (Unit Kerja otomatis terikat pada No. Lambung yang dipilih), dan
tanggal/jam pengisian otomatis dicatat sistem (`created_at`) — sesuai instruksi asli "wajib
diisi waktu akhir shift".

## Fitur

- **Form publik (tanpa login)**, wizard 4 langkah, modern & responsif, cascading dropdown
  lewat AJAX vanilla JS (tanpa npm), upload foto dengan preview.
- **Login admin** — untuk mengelola seluruh master data.
- **Dashboard admin** — ringkasan jumlah zona/area/unit/operator/pengawas, grafik cuci alat
  per zona & per shift (30 hari terakhir), serta isian terbaru lengkap dengan thumbnail foto.
- **CRUD master data**: Zona, Area Kerja, Unit Kerja, Jenis Alat, Operator, **Pengawas** (baru),
  Unit Alat (termasuk penugasan operator grup A–D per unit).
- **Data isian form** — admin bisa memfilter (zona, shift, tanggal), lihat foto, dan export ke
  CSV/Excel (termasuk link foto).
- **Data awal (seeder) sudah diisi dari file Excel yang Anda upload** — 86 unit (59 Forklift +
  27 Wheel Loader) di 6 zona lengkap operator grup A–D, plus 20 nama pengawas dari tabel
  "Daftar Pengawas" di Excel, siap langsung dipakai.

## Struktur Data (Database)

```
zonas (Zona)
  └─ area_kerjas (Area Kerja)
       └─ unit_kerjas (Unit Kerja)
            └─ unit_alats (Unit Alat / No. Lambung) ── jenis_alats (Forklift/Wheel Loader)
                 └─ unit_operators (Operator grup A/B/C/D per unit) ── operators

pengawas        → master nama pengawas (per wilayah)

submissions     → hasil isian form publik: unit_alat_id, pengawas_id, shift (1/2/3),
                   operator_nd_id, operator_grup_a_id..d_id, foto_tampak_samping (path file),
                   plus snapshot text zona/area/unit/jenis/no lambung supaya laporan lama
                   tetap valid walau master data diubah/dihapus di kemudian hari.

users (+role)   → akun admin
```

Foto disimpan di `storage/app/public/foto-cuci-alat/` dan diakses lewat symlink publik
`storage/`.

## Kebutuhan Sistem

- PHP >= 8.2 dengan ekstensi umum Laravel (`pdo_mysql`, `mbstring`, `openssl`, `tokenizer`,
  `xml`, `ctype`, `json`, `fileinfo`, `gd`/`imagick` untuk validasi upload gambar)
- Composer 2
- MySQL 5.7+/8.0 (atau MariaDB)
- **Tidak butuh Node.js/npm sama sekali** — semua CSS/JS dari CDN

## Cara Instalasi (persis seperti clone dari GitHub)

### 1. Install dependency PHP

Dari folder project ini (setelah di-extract):

```bash
composer install
```

### 2. Siapkan file environment

```bash
cp .env.example .env
```

Buat database kosong dulu, misalnya lewat phpMyAdmin/mysql CLI:

```sql
CREATE DATABASE cuci_alber;
```

Lalu sesuaikan kredensial MySQL di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cuci_alber
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Generate key, migrate, dan seed data

```bash
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

Perintah `--seed` otomatis akan:
- Membuat 1 akun admin default: **admin@cucialber.local / admin123**
- Mengisi seluruh data zona/area/unit kerja/unit alat/operator dari Excel Anda.
- Mengisi 20 nama pengawas dari tabel "Daftar Pengawas" di Excel (silakan cek & sesuaikan
  lagi di menu **Pengawas** karena penamaan wilayah "I A/I B/II A/II B/III" di tabel tersebut
  belum tentu sama persis dengan Zona 1A/1B/2A/2B/3 di form — tambahkan/edit manual jika perlu).

`php artisan storage:link` **wajib** dijalankan supaya foto hasil upload dari form publik
bisa diakses/ditampilkan (membuat symlink `public/storage` → `storage/app/public`).

**⚠️ Segera ganti password admin default setelah login pertama kali** (untuk saat ini belum
ada halaman "ubah password" — Anda bisa tambahkan nanti, atau ganti manual lewat
`php artisan tinker`:
`User::first()->update(['password' => bcrypt('password-baru-anda')]);`)

### 4. Jalankan server

```bash
php artisan serve
```

- Form publik: `http://localhost:8000/`
- Login admin: `http://localhost:8000/admin/login`

## Deploy ke Hosting/Server Sungguhan

1. Upload seluruh project (atau `git clone`) ke server.
2. `composer install --no-dev --optimize-autoloader`
3. Set document root ke folder **`public/`** (bukan root project).
4. `.env` production: `APP_ENV=production`, `APP_DEBUG=false`, isi `DB_*` sesuai server,
   `APP_URL` sesuai domain.
5. `php artisan key:generate --force`
6. `php artisan migrate --seed --force`
7. `php artisan storage:link`
8. (Opsional, untuk performa) `php artisan config:cache && php artisan route:cache && php artisan view:cache`
9. Pastikan folder `storage/` dan `bootstrap/cache/` bisa ditulis oleh web server
   (`chmod -R 775 storage bootstrap/cache` lalu set kepemilikan ke user web server, mis. `www-data`).

## Catatan & Asumsi

Form publik sekarang sudah mengikuti struktur **Google Form asli** ("FORM CUCI ALAT BERAT
WILAYAH 1") yang Anda kirimkan screenshot-nya, dengan beberapa optimasi:

- **Area Kerja otomatis terfilter sesuai Zona** — form asli menampilkan seluruh area kerja
  dari semua zona dalam satu daftar radio yang sangat panjang (30+ opsi tercampur); di app
  ini area kerja otomatis muncul sesuai zona yang dipilih.
- **No. Lambung otomatis terfilter sesuai Area Kerja + jenis alat**, bukan daftar mentah semua
  unit se-perusahaan.
- **Operator Grup A–D otomatis disarankan (prefill)** begitu No. Lambung dipilih, sesuai data
  ploting asli dari Excel — mengurangi human error salah pilih operator, namun tetap bisa
  diubah manual jika ada pergantian personel/shift.
- Field **Unit Kerja** tidak ditanyakan terpisah di form publik (mengikuti form asli), tapi
  tetap tersimpan sebagai snapshot di data isian karena otomatis terikat pada No. Lambung yang
  dipilih.
- Field **Tanggal** tidak diminta manual (form asli juga tidak ada), sistem otomatis mencatat
  waktu submit sesuai instruksi "wajib diisi waktu akhir shift".

Beberapa baris "cadangan" (unit cadangan/unit cadangan 2) di Excel **belum** ikut ter-seed
karena strukturnya beda dari data unit inti (tidak reguler per unit+operator). Kalau data itu
juga ingin dimasukkan sebagai unit alat tambahan, beri tahu saya dan saya tambahkan seeder-nya.

## Keamanan Dasar yang Sudah Diterapkan

- CSRF protection bawaan Laravel di semua form.
- Validasi input di setiap controller (`$request->validate`).
- Password admin di-hash otomatis (`Hash::make` / cast `hashed`).
- Rute `/admin/*` diproteksi middleware `auth`; halaman login diproteksi `guest`.
- Public form hanya bisa membuat data baru (create), tidak bisa mengubah/menghapus data
  master.

## Menambah Admin Baru

Untuk sementara (tanpa halaman UI khusus), tambah admin baru lewat tinker:

```bash
php artisan tinker
>>> \App\Models\User::create(['name' => 'Nama Admin', 'email' => 'admin2@contoh.com', 'password' => bcrypt('passwordkuat'), 'role' => 'admin']);
```
