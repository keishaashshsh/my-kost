# My Kost

Sistem manajemen kos terpadu berbasis web untuk pemilik, penghuni, dan calon penghuni.

Dibuat oleh **Keisha Nabila Azzahra** (255150707111071)
Mata kuliah Pengembangan Aplikasi Web (E), Teknologi Informasi, Fakultas Ilmu Komputer, Universitas Brawijaya.

## Latar Belakang

Banyak kos masih dikelola secara manual lewat buku catatan atau chat WhatsApp. Akibatnya data penghuni dan pembayaran mudah salah atau hilang, pemilik sering lupa siapa yang belum membayar, keluhan penghuni tidak punya status yang jelas, dan calon penghuni sulit mengetahui kamar yang tersedia. My Kost mengumpulkan semua proses itu dalam satu website.

## Fitur

| Peran | Fitur |
|---|---|
| Publik | Landing page, katalog kamar dengan filter, detail kamar, login, register |
| Calon penghuni | Booking kamar |
| Penghuni | Dashboard, tagihan, unggah bukti bayar, unduh kuitansi PDF, keluhan dengan foto, pengumuman, perpanjang atau akhiri kontrak |
| Pemilik dan admin | Kelola kamar, booking, penghuni dan kontrak, tagihan dan verifikasi pembayaran, penanganan keluhan |
| Khusus pemilik | Laporan keuangan dengan grafik, pengumuman |
| Otomatis | Tagihan bulanan (tanggal 1), pengingat jatuh tempo lewat email atau WhatsApp |

## Teknologi

- Laravel (PHP) dan Blade
- Laravel Breeze (autentikasi)
- Tailwind CSS dan JavaScript (Vite)
- MySQL
- DomPDF (kuitansi PDF)
- Chart.js (grafik laporan)
- Figma (desain antarmuka)

## Cara Menjalankan

Kebutuhan: PHP 8.2 atau lebih baru, Composer, Node.js, dan MySQL.

```bash
git clone https://github.com/keishaashshsh/my-kost.git
cd my-kost
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Buat database kosong bernama `mykost`, lalu isi pengaturan database di file `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mykost
DB_USERNAME=root
DB_PASSWORD=
MAIL_MAILER=log
```

Lanjutkan dengan:

```bash
php artisan storage:link
php artisan migrate --seed
npm run dev
```

Di jendela Terminal kedua:

```bash
php artisan serve
```

Buka http://127.0.0.1:8000

## Akun Demo

Password semua akun: `password`

| Peran | Email |
|---|---|
| Pemilik | owner@mykost.test |
| Admin | admin@mykost.test |
| Penghuni | budi@mykost.test |

## Alur Penggunaan

1. Calon penghuni mendaftar, memilih kamar, lalu booking.
2. Pemilik mengonfirmasi booking, dan penghuni otomatis tercatat beserta kontraknya.
3. Setiap tanggal 1, sistem membuat tagihan. Pemilik mengisi pemakaian listrik dan air.
4. Penghuni mengunggah bukti bayar, lalu pemilik memverifikasinya.
5. Setelah verifikasi, kuitansi PDF dapat diunduh dan laporan keuangan diperbarui.

## Perintah Terjadwal

| Perintah | Fungsi | Jadwal |
|---|---|---|
| `php artisan bills:generate` | Membuat tagihan bulan ini untuk kontrak aktif | Tanggal 1, pukul 00.05 |
| `php artisan bills:remind` | Mengirim pengingat tagihan yang jatuh tempo dalam 3 hari | Setiap hari pukul 08.00 |

Untuk menjalankan jadwal di komputer sendiri: `php artisan schedule:work`.
Pengingat WhatsApp bersifat opsional dan memakai Fonnte (isi `FONNTE_TOKEN` di `.env`). Tarif listrik dan air diatur di `config/mykost.php`.

## Struktur Penting

| Lokasi | Isi |
|---|---|
| `routes/web.php` | Semua rute aplikasi |
| `app/Http/Controllers/` | Logika tiap fitur (Room, Booking, Bill, Complaint, Report, dan lain-lain) |
| `app/Http/Middleware/RoleMiddleware.php` | Pembatasan akses berdasarkan peran |
| `app/Console/Commands/` | Pembuat tagihan dan pengirim pengingat |
| `app/Models/` | Model data |
| `database/migrations/` | Struktur tabel |
| `resources/views/` | Tampilan halaman (Blade) |
| `resources/views/pdf/receipt.blade.php` | Template kuitansi PDF |

## Rencana Pengembangan

- Pembayaran online (virtual account atau QRIS)
- Aplikasi mobile atau PWA
- Manajemen banyak cabang kos
- Pembacaan meteran listrik dan air otomatis
