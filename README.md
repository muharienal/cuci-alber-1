# Cuci Alber

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

`php artisan storage:link` **wajib** dijalankan supaya foto hasil upload dari form publik
bisa diakses/ditampilkan (membuat symlink `public/storage` → `storage/app/public`).

### 4. Jalankan server

```bash
php artisan serve
```

- Form publik: `http://localhost:8000/`
- Login admin: `http://localhost:8000/admin/login`
