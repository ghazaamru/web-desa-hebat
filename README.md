# Website Desa Dalangan

Website portal resmi Pemerintah Desa Dalangan (Kec. Tawangsari, Kab. Sukoharjo) yang menyediakan profil desa, layanan publik, peta potensi interaktif, katalog BUMDes & UMKM, berita desa, layanan pengaduan warga, serta panel admin untuk mengelola seluruh konten dan memantau statistik kunjungan.

## Fitur

**Halaman Publik**
- Beranda: statistik kependudukan, sambutan Kepala Desa, layanan publik, **peta interaktif desa**, transparansi APBDes, UMKM & wisata, berita terbaru, struktur perangkat desa, galeri kegiatan.
- Profil Desa: visi, misi, sejarah, dan struktur organisasi perangkat desa.
- Peta Potensi: peta titik lokasi **BUMDes, UMKM, Wisata, dan Fasilitas** dengan filter kategori dan popup (foto + WhatsApp).
- Katalog Usaha: daftar BUMDes & UMKM dengan pencarian dan filter kategori.
- Berita: daftar dan detail berita/pengumuman.
- Pengaduan: formulir aduan warga dengan proteksi spam (honeypot) dan rate limit.

**Panel Admin** (khusus akun admin)
- Dashboard: ringkasan statistik pengunjung, konten, dan APBDes.
- Kelola Konten: berita, statistik & profil, APBDes, perangkat desa, galeri, potensi/UMKM/fasilitas, aduan warga, dan analitik kunjungan (grafik 30 hari + halaman terpopuler).

## Teknologi

| Komponen | Versi |
|---|---|
| PHP | 8.3+ (disarankan 8.4) |
| Laravel | 13 |
| Livewire | 4 |
| Flux UI | 2 |
| Fortify (auth + 2FA + passkey) | 1 |
| Database | MySQL 8+ |
| Frontend | Tailwind CSS 4 + Vite |
| Testing | Pest / PHPUnit |

## Persyaratan

- PHP 8.3+ dengan ekstensi: `pdo_mysql`, `mbstring`, `xml`, `curl`, `fileinfo`, `intl`
- Composer 2
- Node.js 20+ dan npm
- MySQL 8+
- Git

## Instalasi (Lokal / Development)

### 1. Clone repository

```bash
git clone <url-repository-github> web-desa-hebat
cd web-desa-hebat
```

### 2. Install dependensi

```bash
composer install
npm install
```

### 3. Siapkan file `.env`

```bash
copy .env.example .env        # Windows (cmd/PowerShell)
cp .env.example .env          # Linux/Mac
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Konfigurasi database

Buka file `.env` dan sesuaikan koneksi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_desa_hebat
DB_USERNAME=root
DB_PASSWORD=
```

Buat database kosong terlebih dahulu, misalnya:

```sql
CREATE DATABASE web_desa_hebat CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Jalankan migrasi dan seeder

```bash
php artisan migrate
php artisan db:seed
```

Seeder akan membuat:
- **Akun admin** (lihat bagian "Akun Admin" di bawah)
- Data contoh: potensi/UMKM/fasilitas, berita, perangkat desa, galeri, statistik kependudukan, dan item APBDes.

### 7. Symlink storage (agar gambar hasil upload dapat diakses)

```bash
php artisan storage:link
```

### 8. Build aset frontend

```bash
npm run build
```

### 9. Jalankan aplikasi

```bash
php artisan serve
```

Buka `http://localhost:8000` di browser.

Untuk development yang lebih nyaman (server + queue + Vite sekaligus):

```bash
composer run dev
```

## Akun Admin

Registrasi publik **dimatikan** di aplikasi ini. Akun admin dibuat otomatis oleh seeder dengan membaca variabel di `.env`:

```env
ADMIN_NAME="Administrator Desa"
ADMIN_EMAIL=admin@dalangan.desa.id
ADMIN_PASSWORD=ganti-dengan-password-kuat
```

- Jika `ADMIN_PASSWORD` tidak diisi, sistem akan membuatkan password acak dan **mencetaknya di terminal** saat `php artisan db:seed` dijalankan.
- Login melalui URL `http://localhost:8000/login` (tombol login tidak ditampilkan di halaman publik).
- Hanya akun dengan `is_admin = true` yang bisa mengakses halaman **Kelola Konten**. Untuk menjadikan user lain admin:

```bash
php artisan tinker
```

```php
$user = App\Models\User::where('email', 'email@user')->first();
$user->update(['is_admin' => true]);
```

> **Keamanan:** selalu ganti `ADMIN_PASSWORD` menjadi password yang kuat sebelum deploy ke produksi.

## Menjalankan Test

```bash
php artisan test --compact
```

Kode diformat dengan Laravel Pint:

```bash
composer lint          # perbaiki otomatis
composer lint:check    # hanya cek
```

## Deploy ke Server (Produksi)

### 1. Persiapan

- PHP 8.3+, MySQL, Node.js, Composer terpasang di server.
- Pastikan ekstensi PHP yang dibutuhkan aktif.

### 2. Deploy kode

```bash
git clone <url-repository-github> /var/www/web-desa-hebat
cd /var/www/web-desa-hebat

composer install --no-dev --optimize-autoloader
npm ci
npm run build
```

### 3. Konfigurasi `.env` produksi

```bash
cp .env.example .env
php artisan key:generate
```

Ubah nilai penting di `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_desa_hebat
DB_USERNAME=desa_user
DB_PASSWORD=password-kuat

ADMIN_EMAIL=admin@dalangan.desa.id
ADMIN_PASSWORD=password-admin-kuat
```

Sesuaikan juga pengaturan mail (untuk reset password):

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=user@example.com
MAIL_PASSWORD=password
MAIL_FROM_ADDRESS=admin@dalangan.desa.id
```

### 4. Migrasi, seeder, dan storage

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

> Sebelum `db:seed`, pastikan `ADMIN_PASSWORD` sudah diisi di `.env` agar tidak muncul password acak.

### 5. Optimasi & izin folder

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache

chmod -R 775 storage bootstrap/cache
```

### 6. Jadwalkan cron scheduler

Aplikasi menjadwalkan `model:prune` harian (pembersihan data analitik lama). Tambahkan cron di server:

```
* * * * * cd /var/www/web-desa-hebat && php artisan schedule:run >> /dev/null 2>&1
```

### 7. Web server

Arahkan vhost/Nginx/Apache ke folder `public/` pada project. Contoh Nginx:

```nginx
server {
    listen 80;
    server_name domain-anda.com;
    root /var/www/web-desa-hebat/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
    }
}
```

> **Catatan penting:** file `public/js/batas-dusun.js` (data batas wilayah desa untuk peta) **wajib ikut ter-commit di git** — jangan sampai tertinggal, karena peta interaktif akan rusak bila file ini hilang di server.

## Struktur Proyek

```
app/
├── Enums/                    # PotencyCategory, ApbdesCategory
├── Http/
│   ├── Controllers/          # HomeController, DashboardController
│   └── Middleware/           # TrackVisitor (statistik kunjungan)
├── Models/                   # News, Potency, Apparatus, Gallery, Complaint, ApbdesItem, Visitor, PageView, ...
└── Providers/
database/
├── factories/                # Factory untuk testing & seeding
├── migrations/
└── seeders/                  # AdminUserSeeder, PotencySeeder, NewsSeeder, ...
resources/views/
├── layouts/                  # layout publik, app (sidebar), auth
├── pages/                    # Livewire SFC (peta-potensi, katalog-usaha, pengaduan, dsb.)
├── partials/
└── welcome.blade.php         # halaman beranda
routes/web.php                # definisi route publik & admin
```

## Troubleshooting

**Gambar tidak muncul setelah upload**
Jalankan `php artisan storage:link` (symlink `storage/app/public` → `public/storage`).

**Halaman tampak tanpa styling**
Jalankan `npm run build` (produksi) atau `npm run dev` (development).

**Error `Unable to locate file in Vite manifest`**
Aset belum di-build: jalankan `npm run build`.

**Peta interaktif tidak muncul**
Pastikan `public/js/batas-dusun.js` ada (ter-commit) dan koneksi internet dapat menjangkau CDN OpenStreetMap/Leaflet.

**Data analitik menumpuk**
Pastikan cron scheduler aktif (lihat bagian Deploy, poin 6) agar `model:prune` berjalan harian.

## Lisensi

© Pemerintah Desa Dalangan. Seluruh hak cipta dilindungi.
