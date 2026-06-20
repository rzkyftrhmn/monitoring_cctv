<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Kemacetan Bandung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #343434;
            color: #e0e0e0;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar-custom {
            background-color: #1a1d27;
            border-bottom: 1px solid #2a2d3e;
        }

        .card-jalan {
            background-color: #1a1d27;
            border: 1px solid #2a2d3e;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .card-jalan:hover {
            border-color: #4e6ef2;
            transform: translateY(-2px);
        }

        .card-jalan.active {
            border-color: #4e6ef2;
            background-color: #1e2235;
        }

        .badge-status {
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .status-lancar        { background-color: #1a472a; color: #4ade80; }
        .status-ramai-lancar  { background-color: #1e3a5f; color: #60a5fa; }
        .status-padat-merayap { background-color: #7c2d12; color: #fb923c; }
        .status-macet-total   { background-color: #450a0a; color: #f87171; }

        .video-container {
            background-color: #1a1d27;
            border: 1px solid #2a2d3e;
            border-radius: 12px;
            overflow: hidden;
            min-height: 400px;
            max-height: 480px; /* tambahkan ini */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .video-container img {
            width: 100%;
            height: 480px;      /* tambahkan ini */
            object-fit: contain; /* tambahkan ini, biar tidak crop/stretch */
            display: block;
        }

        .video-placeholder {
            text-align: center;
            color: #4a4d5e;
        }

        .stat-box {
            background-color: #1a1d27;
            border: 1px solid #2a2d3e;
            border-radius: 10px;
            padding: 16px;
            text-align: center;
        }

        .stat-box .angka {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-box .label {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 4px;
        }

        .dot-live {
            width: 8px;
            height: 8px;
            background-color: #4ade80;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .last-update {
            font-size: 0.75rem;
            color: #6b7280;
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-custom px-4 py-3">
    <span class="navbar-brand text-white fw-bold">
        <i class="bi bi-camera-video-fill me-2 text-primary"></i>
        Monitoring Kemacetan Bandung
    </span>
    <div class="d-flex align-items-center gap-2">
        <span class="dot-live"></span>
        <small class="text-success">Live</small>
    </div>
</nav>

<div class="container-fluid px-4 py-4">
    <div class="row g-4">

        {{-- KOLOM KIRI: Daftar Jalan --}}
        <div class="col-md-4 col-lg-3">
            <h6 class="text-secondary mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;">
                Pilih Lokasi
            </h6>

            <div class="d-flex flex-column gap-2" id="daftar-jalan">
                @forelse($data as $item)
                    <div class="card-jalan p-3 {{ $loop->first ? 'active' : '' }}"
                         onclick="pilihJalan('{{ $item->key }}', this)">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold" style="font-size: 0.9rem;">{{ $item->nama }}</div>
                                <div class="last-update mt-1">
                                    <i class="bi bi-clock me-1"></i>{{ $item->waktu_update }}
                                </div>
                            </div>
                            <span class="badge-status
                                @if($item->status == 'Lancar') status-lancar
                                @elseif($item->status == 'Ramai Lancar') status-ramai-lancar
                                @elseif($item->status == 'Padat Merayap') status-padat-merayap
                                @else status-macet-total
                                @endif">
                                {{ $item->status }}
                            </span>
                        </div>
                        <div class="mt-2" style="font-size: 0.8rem; color: #6b7280;">
                            <i class="bi bi-car-front me-1"></i>{{ $item->total_kendaraan }} kendaraan
                        </div>
                    </div>
                @empty
                    <div class="text-secondary text-center py-4">
                        <i class="bi bi-hourglass-split d-block mb-2" style="font-size: 1.5rem;"></i>
                        Menunggu data dari Python...
                    </div>
                @endforelse
            </div>
        </div>

        {{-- KOLOM KANAN: Video + Statistik --}}
        <div class="col-md-8 col-lg-9">

            {{-- Video Stream --}}
            <div class="video-container mb-4" id="video-wrapper">
                @if($data->count() > 0)
                    <img id="video-stream"
                         src="http://localhost:5000/api/stream/{{ $data->first()->key }}"
                         alt="Live Stream">
                @else
                    <div class="video-placeholder">
                        <i class="bi bi-camera-video-off" style="font-size: 3rem;"></i>
                        <p class="mt-3">Belum ada stream tersedia</p>
                        <small>Pastikan Python API sudah berjalan</small>
                    </div>
                @endif
            </div>

            {{-- Statistik Jalan Aktif --}}
            <div id="statistik-aktif">
                @if($data->count() > 0)
                    @php $aktif = $data->first(); @endphp
                    <h6 class="text-secondary mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;">
                        Statistik — {{ $aktif->nama }}
                    </h6>
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <div class="angka text-warning">{{ $aktif->motor }}</div>
                                <div class="label"><i class="bi bi-bicycle me-1"></i>Motor</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <div class="angka text-success">{{ $aktif->mobil }}</div>
                                <div class="label"><i class="bi bi-car-front me-1"></i>Mobil</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <div class="angka text-info">{{ $aktif->bus }}</div>
                                <div class="label"><i class="bi bi-bus-front me-1"></i>Bus</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <div class="angka text-danger">{{ $aktif->truk }}</div>
                                <div class="label"><i class="bi bi-truck me-1"></i>Truk</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Simpan semua data di variable JS
    const trafficData = @json($data->keyBy('key'));

    function pilihJalan(key, elCard) {
        // Update active state card
        document.querySelectorAll('.card-jalan').forEach(c => c.classList.remove('active'));
        elCard.classList.add('active');

        // Ganti src video stream
        document.getElementById('video-stream').src = `http://localhost:5000/api/stream/${key}`;

        // Update statistik
        const item = trafficData[key];
        if (!item) return;

        document.getElementById('statistik-aktif').innerHTML = `
            <h6 class="text-secondary mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;">
                Statistik — ${item.nama}
            </h6>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="angka text-warning">${item.motor}</div>
                        <div class="label"><i class="bi bi-bicycle me-1"></i>Motor</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="angka text-success">${item.mobil}</div>
                        <div class="label"><i class="bi bi-car-front me-1"></i>Mobil</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="angka text-info">${item.bus}</div>
                        <div class="label"><i class="bi bi-bus-front me-1"></i>Bus</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="angka text-danger">${item.truk}</div>
                        <div class="label"><i class="bi bi-truck me-1"></i>Truk</div>
                    </div>
                </div>
            </div>
        `;
    }

    // Tracking jalan yang sedang aktif
    let keyAktif = '{{ $data->first()->key ?? '' }}';

    function pilihJalan(key, elCard) {
        document.querySelectorAll('.card-jalan').forEach(c => c.classList.remove('active'));
        elCard.classList.add('active');
        keyAktif = key;

        document.getElementById('video-stream').src = `http://localhost:5000/api/stream/${key}`;

        const item = trafficData[key];
        if (item) updateStatistik(item);
    }

    function getStatusClass(status) {
        if (status === 'Lancar')        return 'status-lancar';
        if (status === 'Ramai Lancar')  return 'status-ramai-lancar';
        if (status === 'Padat Merayap') return 'status-padat-merayap';
        return 'status-macet-total';
    }

    function updateStatistik(item) {
        document.getElementById('statistik-aktif').innerHTML = `
            <h6 class="text-secondary mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.7rem;">
                Statistik — ${item.nama}
            </h6>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="angka text-warning">${item.motor}</div>
                        <div class="label"><i class="bi bi-bicycle me-1"></i>Motor</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="angka text-success">${item.mobil}</div>
                        <div class="label"><i class="bi bi-car-front me-1"></i>Mobil</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="angka text-info">${item.bus}</div>
                        <div class="label"><i class="bi bi-bus-front me-1"></i>Bus</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-box">
                        <div class="angka text-danger">${item.truk}</div>
                        <div class="label"><i class="bi bi-truck me-1"></i>Truk</div>
                    </div>
                </div>
            </div>
        `;
    }

    // Polling tiap 5 detik
    setInterval(() => {
        fetch('/api/traffic')
            .then(res => res.json())
            .then(json => {
                if (!json.success) return;

                json.data.forEach(item => {
                    // Update trafficData di memory
                    trafficData[item.key] = item;

                    // Update card kiri (status + jumlah kendaraan + waktu)
                    const card = document.querySelector(`[onclick="pilihJalan('${item.key}', this)"]`);
                    if (card) {
                        card.querySelector('.fw-semibold').nextElementSibling.innerHTML =
                            `<i class="bi bi-clock me-1"></i>${item.waktu_update}`;

                        card.querySelector('.badge-status').className =
                            `badge-status ${getStatusClass(item.status)}`;
                        card.querySelector('.badge-status').textContent = item.status;

                        card.querySelector('[style*="0.8rem"]').innerHTML =
                            `<i class="bi bi-car-front me-1"></i>${item.total_kendaraan} kendaraan`;
                    }

                    // Update statistik bawah jika jalan ini yang sedang aktif
                    if (item.key === keyAktif) {
                        updateStatistik(item);
                    }
                });
            })
            .catch(() => {
                // Diam saja jika gagal, tidak perlu alert
            });
    }, 5000);
</script>

</body>
</html>