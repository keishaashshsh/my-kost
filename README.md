Nama: Keisha Nabila Azzahra
NIM: 255150707111071

# My Kost

Sistem manajemen kos terpadu berbasis web untuk pemilik, penghuni, dan calon penghuni. Project ini disusun sebagai tugas mata kuliah Pengembangan Aplikasi Web (E).

## Latar Belakang

Pengelolaan kos di banyak tempat masih dilakukan secara manual menggunakan buku catatan atau pesan WhatsApp. Kondisi ini menimbulkan beberapa kendala, yaitu data penghuni dan pembayaran yang rawan salah atau hilang, pemilik yang kesulitan memantau tunggakan, keluhan penghuni yang tidak memiliki status penanganan yang jelas, serta calon penghuni yang sulit memperoleh informasi kamar terkini. My Kost dikembangkan untuk mengelola seluruh proses tersebut secara terpusat.

## Fitur

**Halaman Publik**
- Landing page dan katalog kamar dengan filter tipe, harga, dan fasilitas
- Detail kamar dengan foto
- Login dan registrasi

**Calon Penghuni dan Penghuni**
- Pemesanan (booking) kamar
- Dashboard informasi kamar dan status pembayaran
- Tagihan, unggah bukti pembayaran, dan unduh kuitansi PDF
- Pengiriman keluhan beserta foto dan pelacakan status (Diterima, Diproses, Selesai)
- Pengumuman serta perpanjangan atau pengakhiran kontrak

**Pemilik dan Admin**
- Manajemen kamar, booking, penghuni, dan kontrak
- Pembuatan tagihan, perhitungan listrik dan air berdasarkan meteran, serta verifikasi pembayaran
- Penanganan keluhan
- Khusus pemilik: laporan keuangan dengan grafik dan pengumuman

**Otomatisasi**
- Pembuatan tagihan bulanan setiap tanggal 1
- Pengingat jatuh tempo melalui email (WhatsApp bersifat opsional)

## Teknologi

- Laravel (PHP) dan Blade
- Laravel Breeze (autentikasi)
- Tailwind CSS dan JavaScript
- MySQL
- DomPDF (kuitansi PDF)
- Chart.js (grafik laporan)
- Figma (perancangan antarmuka)

## Instalasi dan Menjalankan Aplikasi

Prasyarat: PHP 8.2 atau lebih baru, Composer, Node.js, dan MySQL.

```bash
git clone https://github.com/keishaashshsh/my-kost.git
cd my-kost
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Buat database kosong bernama `mykost`, kemudian atur berkas `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mykost
DB_USERNAME=root
DB_PASSWORD=
MAIL_MAILER=log
```

Lanjutkan dengan perintah berikut:

```bash
php artisan storage:link
php artisan migrate --seed
npm run dev
```

Pada jendela terminal kedua, jalankan `php artisan serve`, lalu akses http://127.0.0.1:8000

## Akun Demo

Kata sandi seluruh akun adalah `password`.

| Peran | Email |
|---|---|
| Pemilik | owner@mykost.test |
| Admin | admin@mykost.test |
| Penghuni | budi@mykost.test |

## Alur Sistem

1. Calon penghuni mendaftar, memilih kamar, dan melakukan booking.
2. Pemilik mengonfirmasi booking, sehingga penghuni dan kontraknya tercatat otomatis.
3. Setiap tanggal 1, sistem membuat tagihan. Pemilik mengisi pemakaian listrik dan air.
4. Penghuni mengunggah bukti pembayaran, kemudian pemilik memverifikasinya.
5. Kuitansi PDF diterbitkan dan laporan keuangan diperbarui.

## Perintah Terjadwal

| Perintah | Fungsi | Jadwal |
|---|---|---|
| `php artisan bills:generate` | Membuat tagihan bulan berjalan untuk kontrak aktif | Tanggal 1, pukul 00.05 |
| `php artisan bills:remind` | Mengirim pengingat tagihan yang jatuh tempo dalam 3 hari | Setiap hari pukul 08.00 |

Pada lingkungan lokal, penjadwalan dapat dijalankan dengan `php artisan schedule:work`. Tarif listrik dan air diatur pada `config/mykost.php`. Pengingat WhatsApp memerlukan `FONNTE_TOKEN` pada berkas `.env`.

## Struktur Direktori Utama

| Lokasi | Keterangan |
|---|---|
| `routes/web.php` | Seluruh rute aplikasi |
| `app/Http/Controllers/` | Logika setiap fitur |
| `app/Http/Middleware/RoleMiddleware.php` | Pembatasan akses berdasarkan peran |
| `app/Console/Commands/` | Pembuatan tagihan dan pengiriman pengingat |
| `app/Models/` | Model data |
| `database/migrations/` | Struktur tabel |
| `resources/views/` | Tampilan halaman (Blade), termasuk `pdf/receipt.blade.php` untuk kuitansi |

## Catatan Pengembangan

Sebagian kode project ini dikembangkan dengan bantuan AI (Claude), kemudian dijalankan, diuji, dan disesuaikan oleh penulis.

## Rencana Pengembangan Lanjutan

- Pembayaran online (virtual account atau QRIS)
- Aplikasi mobile atau PWA
- Manajemen banyak cabang kos
- Pembacaan meteran listrik dan air otomatis
