# Monitoring CCTV Python API

Project ini adalah Python Flask API untuk monitoring lalu lintas dari CCTV. Aplikasi membaca stream CCTV HLS `.m3u8`, menjalankan deteksi kendaraan dengan YOLO, menggambar bounding box pada frame, menyediakan data realtime dalam bentuk JSON, menyediakan MJPEG fallback, dan menghasilkan video HLS menggunakan FFmpeg.

README ini hanya membahas service Python API.

## Fitur Utama

- Membaca stream CCTV HLS `.m3u8`
- Deteksi kendaraan dengan YOLO
- Kelas kendaraan: motor, mobil, bus, truk
- Realtime JSON API
- MJPEG fallback lewat `GET /api/stream/{key}`
- HLS video lewat `GET /hls/{key}/index.m3u8`
- Status HLS lewat `GET /api/hls/{key}/status`
- Support GPU CUDA jika tersedia
- Fallback otomatis ke CPU jika CUDA tidak tersedia

## Requirement

Pastikan sudah tersedia:

- Python
- pip
- Virtual environment
- FFmpeg
- Flask
- OpenCV
- Ultralytics YOLO
- PyTorch

Catatan penting: FFmpeg bukan package Python. FFmpeg adalah software sistem yang harus diinstall terpisah dan tersedia lewat command `ffmpeg`.

## Instalasi FFmpeg Windows

Install FFmpeg:

```powershell
winget install --id Gyan.FFmpeg -e
```

Setelah install, restart terminal lalu cek:

```powershell
ffmpeg -version
```

Jika command `ffmpeg` belum dikenali, tambahkan folder `bin` dari instalasi FFmpeg ke environment variable `PATH`, lalu restart terminal.

## Setup Python

Buat dan aktifkan virtual environment:

```powershell
python -m venv .venv
.venv\Scripts\activate
pip install -r requirements.txt
```

Model default yang digunakan sekarang adalah `yolo11n.pt`. Jika file model belum ada secara lokal, Ultralytics biasanya akan mengunduh model saat pertama kali dijalankan.

## CPU dan GPU

Aplikasi bisa berjalan di CPU-only, tetapi proses deteksi akan lebih lambat. Jika ingin memakai GPU NVIDIA, install PyTorch versi CUDA yang sesuai dengan driver dan versi CUDA di komputer.

Cek apakah CUDA terdeteksi:

```powershell
python -c "import torch; print(torch.cuda.is_available()); print(torch.cuda.get_device_name(0) if torch.cuda.is_available() else 'CPU only')"
```

Kode otomatis memakai `cuda:0` jika CUDA tersedia, dan fallback ke `cpu` jika CUDA tidak tersedia.

## Cara Menjalankan

Jalankan API:

```powershell
python api_yolo.py
```

Server berjalan di:

```text
http://localhost:5000
```

## Endpoint API

- `GET /api/health` - cek status API
- `GET /api/jalan` - daftar lokasi/jalan CCTV
- `GET /api/traffic` - data traffic realtime semua kamera
- `GET /api/traffic/{key}` - data traffic realtime berdasarkan key kamera
- `GET /api/stream/{key}` - MJPEG fallback stream
- `GET /api/hls/{key}/status` - status output HLS kamera
- `GET /hls/{key}/index.m3u8` - playlist HLS hasil deteksi

## Testing

Buka endpoint berikut di browser atau tool HTTP:

```text
http://localhost:5000/api/health
http://localhost:5000/api/traffic
http://localhost:5000/api/hls/simpang_mirota/status
http://localhost:5000/hls/simpang_mirota/index.m3u8
```

HLS berhasil jika response `index.m3u8` berisi:

```text
#EXTM3U
```

## Troubleshooting

### `ffmpeg not found`

Pastikan FFmpeg sudah diinstall dan command ini berjalan:

```powershell
ffmpeg -version
```

Jika belum dikenali, tambahkan folder `bin` FFmpeg ke `PATH`, lalu restart terminal.

### HLS loading terus

Cek status HLS:

```text
http://localhost:5000/api/hls/{key}/status
```

Pastikan playlist tersedia dan segment `.ts` sudah terbentuk. Jika belum, cek apakah FFmpeg berjalan dan stream CCTV sumber bisa diakses.

### GPU 100%

Ini normal jika deteksi berjalan realtime. Kurangi jumlah kamera aktif, gunakan model yang lebih ringan, turunkan resolusi/frame rate input, atau jalankan di CPU jika GPU ingin dipakai untuk pekerjaan lain.

### Motor belum banyak terdeteksi

Model umum seperti `yolo11n.pt` bisa kurang optimal untuk kondisi CCTV tertentu. Solusinya gunakan model yang lebih besar, tingkatkan kualitas stream, atau fine-tune model dengan dataset motor dari sudut kamera terkait.

### CCTV tidak muncul

Pastikan URL `.m3u8` sumber masih aktif, bisa dibuka dari jaringan komputer, dan tidak diblokir. Cek juga key kamera yang dipakai di endpoint.

### Port 5000 sudah dipakai

Matikan proses lain yang memakai port `5000`, atau ubah port Flask di konfigurasi/run command aplikasi.
