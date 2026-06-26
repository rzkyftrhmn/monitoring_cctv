# Monitoring CCTV Dashboard - Laravel

Dashboard monitoring kemacetan berbasis Laravel untuk menampilkan data realtime dari Python YOLO CCTV API.

Project ini digunakan sebagai tampilan utama sistem monitoring lalu lintas. Laravel bertugas menampilkan dashboard, menyimpan data traffic ke database, menjalankan queue untuk mengambil data dari Python API, dan menampilkan grafik riwayat dari tabel log.

## Fitur Utama

- Dashboard monitoring kemacetan
- Daftar lokasi CCTV
- Video live hasil deteksi YOLO menggunakan HLS
- Statistik kendaraan realtime:
    - Motor
    - Mobil
    - Bus
    - Truk

- Status kemacetan:
    - Lancar
    - Ramai Lancar
    - Padat Merayap
    - Macet Total

- Indikator AI online/offline
- Last sync dan data delay
- Grafik riwayat kendaraan dari database
- Grafik tingkat kemacetan selama 30 menit terakhir
- Penyimpanan data terbaru dan data historis
- Queue worker untuk sinkronisasi data dari Python API

## Arsitektur Singkat

```text
CCTV .m3u8
↓
Python Flask YOLO API
↓
Laravel Queue Worker
↓
MySQL Database
↓
Laravel Dashboard
```

Laravel tidak melakukan deteksi kendaraan secara langsung.

Deteksi dilakukan oleh Python API. Laravel hanya mengambil hasil deteksi, menyimpan ke database, lalu menampilkannya di dashboard.

## Tech Stack

- Laravel
- Blade Template
- MySQL
- Laravel Queue
- Bootstrap 5
- Bootstrap Icons
- hls.js
- Chart.js
- Python Flask API sebagai service eksternal

## Kebutuhan Sistem

Pastikan sudah terinstall:

- PHP sesuai versi Laravel project
- Composer
- MySQL / MariaDB
- Node.js dan npm
- Python API sudah berjalan di port `5000`
- Browser modern

## Setup Project Laravel

Clone repository:

```bash
git clone <url-repository-laravel>
cd <nama-folder-project>
```

Install dependency Laravel:

```bash
composer install
```

Install dependency frontend:

```bash
npm install
```

Copy file environment:

```bash
copy .env.example .env
```

Generate app key:

```bash
php artisan key:generate
```

Atur database di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=monitoring
DB_USERNAME=root
DB_PASSWORD=
```

Pastikan queue menggunakan database:

```env
QUEUE_CONNECTION=database
```

Jalankan migration:

```bash
php artisan migrate
```

## Menjalankan Project

Project ini membutuhkan beberapa proses yang berjalan bersamaan.

### Terminal 1 - Laravel Server

```bash
php artisan serve
```

Dashboard akan berjalan di:

```text
http://127.0.0.1:8000
```

### Terminal 2 - Queue Worker

```bash
php artisan queue:work
```

Queue worker digunakan untuk mengambil data traffic dari Python API lalu menyimpannya ke database.

### Terminal 3 - Python API

Python API berada di repository terpisah.

Pastikan Python API berjalan di:

```text
http://localhost:5000
```

Laravel membutuhkan endpoint Python berikut:

```text
GET http://localhost:5000/api/traffic
GET http://localhost:5000/api/traffic/{key}
GET http://localhost:5000/hls/{key}/index.m3u8
```

## Database

Project ini menggunakan dua tabel utama.

### `traffic_data`

Menyimpan data traffic terbaru untuk setiap lokasi CCTV.

Data pada tabel ini akan terus diperbarui.

Contoh kolom:

- `key`
- `nama`
- `status`
- `total_kendaraan`
- `motor`
- `mobil`
- `bus`
- `truk`
- `waktu_update`

Tabel ini digunakan untuk card lokasi dan statistik terbaru.

### `traffic_histories`

Menyimpan data historis traffic per window waktu.

Data ini digunakan untuk grafik riwayat.

Contoh kolom:

- `key`
- `nama`
- `window_start`
- `window_end`
- `avg_total_kendaraan`
- `avg_motor`
- `avg_mobil`
- `avg_bus`
- `avg_truk`
- `max_total_kendaraan`
- `dominant_status`
- `peak_status`
- `avg_congestion_score`
- `max_congestion_score`

## Endpoint Laravel

### Dashboard

```text
GET /
```

Menampilkan halaman dashboard monitoring.

### Data Traffic Terbaru

```text
GET /api/traffic
```

Mengambil data traffic terbaru dari database Laravel.

Digunakan untuk update card lokasi dan metadata dashboard.

### Data History Traffic

```text
GET /api/traffic-history/{key}?minutes=30
```

Mengambil riwayat traffic dari tabel `traffic_histories`.

Digunakan untuk grafik:

- Riwayat jumlah kendaraan
- Tingkat kemacetan 30 menit terakhir

## Video HLS

Dashboard menampilkan video menggunakan tag `<video>` dan `hls.js`.

Format URL video:

```text
http://localhost:5000/hls/{key}/index.m3u8
```

Contoh:

```text
http://localhost:5000/hls/simpang_mirota/index.m3u8
```

Video HLS dibuat oleh Python API menggunakan FFmpeg. Laravel hanya menampilkan stream tersebut.

## Mode Tema

Dashboard mendukung:

- System mode
- Light mode
- Dark mode

Mode system mengikuti preferensi browser atau sistem operasi user.

Preferensi tema disimpan di `localStorage`.

## Cara Kerja Realtime

Dashboard menggunakan beberapa sumber data:

```text
Video HLS
→ langsung dari Python API

Statistik kamera aktif
→ langsung dari Python API

Card lokasi
→ dari Laravel database

Chart history
→ dari tabel traffic_histories
```

Alur ini dipakai agar video dan statistik aktif terasa lebih realtime, sementara data historis tetap tersimpan di database.

## Testing

Pastikan Laravel berjalan:

```text
http://127.0.0.1:8000
```

Pastikan API Laravel berjalan:

```text
http://127.0.0.1:8000/api/traffic
```

Pastikan history berjalan:

```text
http://127.0.0.1:8000/api/traffic-history/simpang_mirota
```

Pastikan Python API berjalan:

```text
http://localhost:5000/api/health
```

Pastikan HLS video tersedia:

```text
http://localhost:5000/hls/simpang_mirota/index.m3u8
```

Jika HLS berhasil, response akan berisi teks seperti:

```text
#EXTM3U
#EXT-X-VERSION:3
#EXTINF:2.000000,
segment_000.ts
```

## Troubleshooting

### Dashboard muncul tapi data kosong

Pastikan Python API sudah berjalan:

```bash
python api_yolo.py
```

Lalu pastikan queue worker Laravel juga berjalan:

```bash
php artisan queue:work
```

### Card tidak update

Pastikan endpoint Laravel ini mengeluarkan data:

```text
http://127.0.0.1:8000/api/traffic
```

Kalau kosong, cek queue worker dan koneksi Python API.

### Video loading terus

Pastikan HLS untuk kamera tersebut tersedia:

```text
http://localhost:5000/api/hls/{key}/status
```

Pastikan `playlist_exists` bernilai `true` dan `segments_count` lebih dari `0`.

### Chart kosong

Pastikan tabel `traffic_histories` sudah terisi.

Cek endpoint:

```text
http://127.0.0.1:8000/api/traffic-history/simpang_mirota
```

Kalau data kosong, jalankan queue worker dan tunggu beberapa menit agar log history terbentuk.

### AI Offline / Delay

Kemungkinan:

- Python API mati
- Queue worker mati
- Koneksi ke Python API gagal
- Data terakhir tidak terupdate

Jalankan ulang:

```bash
php artisan queue:work
```

dan pastikan Python API aktif.

## Catatan Development

Jangan commit file berikut:

```text
.env
vendor/
node_modules/
```

Pastikan file `.env.example` tetap tersedia untuk teman yang ingin clone project.

## Perintah Penting

```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
php artisan queue:work
```

## Status Project

Project Laravel ini berperan sebagai dashboard utama.

Untuk menjalankan sistem penuh, wajib menjalankan:

1. Python YOLO API
2. Laravel server
3. Laravel queue worker
4. MySQL database

Kalau salah satu mati, sistem tetap bisa tampil sebagian, tapi realtime data bisa tidak sinkron.
