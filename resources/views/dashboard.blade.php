<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Kemacetan Jogja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <script>
        (function() {
            const storageKey = 'traffic-dashboard-theme';
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            const storedTheme = localStorage.getItem(storageKey);
            const themeChoice = ['system', 'light', 'dark'].includes(storedTheme) ? storedTheme : 'system';
            const resolvedTheme = themeChoice === 'system' ? (mediaQuery.matches ? 'dark' : 'light') : themeChoice;

            document.documentElement.dataset.theme = resolvedTheme;
            document.documentElement.dataset.themeChoice = themeChoice;
        })();
    </script>

    <style>
        :root {
            color-scheme: dark;
            --bg: #0b111a;
            --surface: #111a26;
            --surface-2: #151f2d;
            --surface-3: #1b2736;
            --border: rgba(148, 163, 184, 0.16);
            --border-strong: rgba(148, 163, 184, 0.28);
            --text: #e5edf7;
            --muted: #8b9aab;
            --muted-2: #64748b;
            --blue: #4f8cff;
            --green: #39d98a;
            --amber: #f7b955;
            --orange: #fb8c4b;
            --red: #f05d6a;
            --cyan: #45c9e8;
            --body-bg:
                radial-gradient(circle at top left, rgba(79, 140, 255, 0.08), transparent 34rem),
                linear-gradient(180deg, #0d1520 0%, var(--bg) 46%, #070b11 100%);
            --navbar-bg: rgba(10, 16, 25, 0.94);
            --brand-border: rgba(79, 140, 255, 0.36);
            --brand-bg: rgba(79, 140, 255, 0.11);
            --brand-color: #9cc2ff;
            --pill-bg: rgba(17, 26, 38, 0.82);
            --panel-bg: rgba(17, 26, 38, 0.94);
            --panel-header-bg: rgba(21, 31, 45, 0.72);
            --soft-bg: rgba(11, 17, 26, 0.45);
            --card-bg: rgba(21, 31, 45, 0.7);
            --card-hover-bg: rgba(27, 39, 54, 0.96);
            --card-active-bg: rgba(30, 46, 68, 0.96);
            --card-hover-border: rgba(79, 140, 255, 0.42);
            --card-active-border: rgba(79, 140, 255, 0.78);
            --vehicle-text: #aeb9c7;
            --scroll-thumb: rgba(148, 163, 184, 0.22);
            --video-bg: #05070b;
            --video-toolbar-bg: rgba(8, 13, 20, 0.95);
            --video-toolbar-title: #cbd5e1;
            --active-panel-bg: rgba(15, 23, 34, 0.76);
            --stat-bg: rgba(21, 31, 45, 0.82);
            --stat-icon-bg: rgba(11, 17, 26, 0.55);
            --chart-bg: rgba(17, 26, 38, 0.94);
            --chart-label: #cbd5e1;
            --chart-grid: rgba(148, 163, 184, 0.1);
            --chart-grid-strong: rgba(148, 163, 184, 0.12);
            --tooltip-bg: #0b111a;
            --tooltip-border: rgba(148, 163, 184, 0.22);
            --tooltip-title: #e5edf7;
            --tooltip-body: #cbd5e1;
            --live-ring: rgba(57, 217, 138, 0.12);
            --status-lancar-bg: rgba(57, 217, 138, 0.12);
            --status-lancar-border: rgba(57, 217, 138, 0.28);
            --status-lancar-text: #69e6a7;
            --status-ramai-bg: rgba(69, 201, 232, 0.12);
            --status-ramai-border: rgba(69, 201, 232, 0.28);
            --status-ramai-text: #76d9ef;
            --status-padat-bg: rgba(247, 185, 85, 0.14);
            --status-padat-border: rgba(247, 185, 85, 0.3);
            --status-padat-text: #ffd07c;
            --status-macet-bg: rgba(240, 93, 106, 0.13);
            --status-macet-border: rgba(240, 93, 106, 0.31);
            --status-macet-text: #ff8d98;
            --shadow: 0 18px 50px rgba(0, 0, 0, 0.28);
        }

        html[data-theme="light"] {
            color-scheme: light;
            --bg: #eef3f8;
            --surface: #ffffff;
            --surface-2: #f6f9fc;
            --surface-3: #e9eff6;
            --border: rgba(30, 41, 59, 0.12);
            --border-strong: rgba(30, 41, 59, 0.22);
            --text: #142033;
            --muted: #64748b;
            --muted-2: #7b8798;
            --blue: #2563eb;
            --green: #138a55;
            --amber: #b7791f;
            --orange: #c05621;
            --red: #dc3545;
            --cyan: #087ea4;
            --body-bg:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.11), transparent 32rem),
                linear-gradient(180deg, #f7fbff 0%, var(--bg) 54%, #e8eef5 100%);
            --navbar-bg: rgba(248, 251, 255, 0.94);
            --brand-border: rgba(37, 99, 235, 0.24);
            --brand-bg: rgba(37, 99, 235, 0.08);
            --brand-color: #1d4ed8;
            --pill-bg: rgba(255, 255, 255, 0.78);
            --panel-bg: rgba(255, 255, 255, 0.9);
            --panel-header-bg: rgba(246, 249, 252, 0.86);
            --soft-bg: rgba(226, 232, 240, 0.62);
            --card-bg: rgba(248, 250, 252, 0.86);
            --card-hover-bg: rgba(239, 246, 255, 0.96);
            --card-active-bg: rgba(219, 234, 254, 0.9);
            --card-hover-border: rgba(37, 99, 235, 0.28);
            --card-active-border: rgba(37, 99, 235, 0.62);
            --vehicle-text: #475569;
            --scroll-thumb: rgba(100, 116, 139, 0.26);
            --video-bg: #0b1220;
            --video-toolbar-bg: rgba(244, 248, 252, 0.96);
            --video-toolbar-title: #1e293b;
            --active-panel-bg: rgba(255, 255, 255, 0.82);
            --stat-bg: rgba(248, 250, 252, 0.9);
            --stat-icon-bg: rgba(226, 232, 240, 0.62);
            --chart-bg: rgba(255, 255, 255, 0.92);
            --chart-label: #334155;
            --chart-grid: rgba(100, 116, 139, 0.13);
            --chart-grid-strong: rgba(100, 116, 139, 0.18);
            --tooltip-bg: #ffffff;
            --tooltip-border: rgba(30, 41, 59, 0.16);
            --tooltip-title: #142033;
            --tooltip-body: #334155;
            --live-ring: rgba(19, 138, 85, 0.12);
            --status-lancar-bg: rgba(19, 138, 85, 0.1);
            --status-lancar-border: rgba(19, 138, 85, 0.22);
            --status-lancar-text: #087044;
            --status-ramai-bg: rgba(8, 126, 164, 0.1);
            --status-ramai-border: rgba(8, 126, 164, 0.2);
            --status-ramai-text: #075f7a;
            --status-padat-bg: rgba(183, 121, 31, 0.12);
            --status-padat-border: rgba(183, 121, 31, 0.24);
            --status-padat-text: #8a570f;
            --status-macet-bg: rgba(220, 53, 69, 0.1);
            --status-macet-border: rgba(220, 53, 69, 0.22);
            --status-macet-text: #b42335;
            --shadow: 0 18px 46px rgba(15, 23, 42, 0.1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: var(--body-bg);
            color: var(--text);
            font-family: "Inter", "Segoe UI", system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            letter-spacing: 0;
            transition: background-color 0.18s ease, color 0.18s ease;
        }

        .app-shell {
            min-height: 100vh;
        }

        .navbar-custom {
            min-height: 72px;
            background: var(--navbar-bg);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.22);
            backdrop-filter: blur(14px);
        }

        .brand-mark {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--brand-border);
            border-radius: 8px;
            background: var(--brand-bg);
            color: var(--brand-color);
        }

        .brand-title {
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .brand-subtitle {
            color: var(--muted);
            font-size: 0.72rem;
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .ops-status {
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .ops-pill {
            min-height: 34px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 11px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--pill-bg);
            color: var(--muted);
            font-size: 0.78rem;
            white-space: nowrap;
        }

        .theme-control {
            position: relative;
        }

        .theme-control i {
            color: var(--muted);
            pointer-events: none;
        }

        .theme-select {
            height: 100%;
            min-height: 18px;
            padding: 0 22px 0 0;
            border: 0;
            outline: 0;
            background: transparent;
            color: var(--text);
            font-size: 0.78rem;
            font-weight: 650;
            cursor: pointer;
            appearance: auto;
        }

        .theme-select option {
            color: #142033;
            background: #ffffff;
        }

        .ops-pill strong {
            color: var(--text);
            font-weight: 650;
        }

        .dashboard-grid {
            align-items: flex-start;
        }

        .panel,
        .video-shell,
        .stat-box,
        .chart-box {
            background: var(--panel-bg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        .panel {
            border-radius: 10px;
            overflow: hidden;
        }

        .panel-header,
        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .panel-header {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            background: var(--panel-header-bg);
        }

        .eyebrow {
            color: var(--muted-2);
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.11em;
            text-transform: uppercase;
        }

        .section-title {
            color: var(--text);
            font-size: 0.95rem;
            font-weight: 700;
            margin: 2px 0 0;
        }

        .section-note {
            color: var(--muted);
            font-size: 0.76rem;
        }

        .camera-count {
            color: var(--muted);
            font-size: 0.76rem;
            padding: 5px 8px;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: var(--soft-bg);
        }

        .camera-list {
            max-height: calc(100vh - 150px);
            overflow-y: auto;
            padding: 10px;
        }

        .camera-list::-webkit-scrollbar {
            width: 8px;
        }

        .camera-list::-webkit-scrollbar-thumb {
            background: var(--scroll-thumb);
            border-radius: 999px;
        }

        .card-jalan {
            position: relative;
            background: var(--card-bg);
            border: 1px solid transparent;
            border-radius: 8px;
            cursor: pointer;
            transition: border-color 0.18s ease, background-color 0.18s ease, transform 0.18s ease;
        }

        .card-jalan:hover {
            border-color: var(--card-hover-border);
            background: var(--card-hover-bg);
        }

        .card-jalan.active {
            border-color: var(--card-active-border);
            background: var(--card-active-bg);
        }

        .card-jalan.active::before {
            content: "";
            position: absolute;
            inset: 10px auto 10px 0;
            width: 3px;
            border-radius: 999px;
            background: var(--blue);
        }

        .camera-name {
            color: var(--text);
            font-size: 0.88rem;
            font-weight: 650;
            line-height: 1.25;
        }

        .camera-meta {
            color: var(--muted);
            font-size: 0.74rem;
        }

        .vehicle-count {
            color: var(--vehicle-text);
            font-size: 0.78rem;
        }

        .badge-status,
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            line-height: 1;
            padding: 6px 8px;
            white-space: nowrap;
        }

        .status-lancar {
            background-color: var(--status-lancar-bg);
            border-color: var(--status-lancar-border);
            color: var(--status-lancar-text);
        }

        .status-ramai-lancar {
            background-color: var(--status-ramai-bg);
            border-color: var(--status-ramai-border);
            color: var(--status-ramai-text);
        }

        .status-padat-merayap {
            background-color: var(--status-padat-bg);
            border-color: var(--status-padat-border);
            color: var(--status-padat-text);
        }

        .status-macet-total {
            background-color: var(--status-macet-bg);
            border-color: var(--status-macet-border);
            color: var(--status-macet-text);
        }

        .workspace-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 14px;
        }

        .workspace-title {
            color: var(--text);
            font-size: clamp(1.05rem, 2vw, 1.35rem);
            font-weight: 750;
            margin: 0;
        }

        .workspace-meta {
            color: var(--muted);
            font-size: 0.8rem;
        }

        .feed-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--pill-bg);
            color: var(--muted);
            font-size: 0.78rem;
        }

        .video-container {
            position: relative;
            background-color: var(--video-bg);
            overflow: hidden;
            min-height: 430px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .video-shell {
            border-radius: 10px;
            overflow: hidden;
        }

        .video-toolbar {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
            background: var(--video-toolbar-bg);
        }

        .video-toolbar-title {
            color: var(--video-toolbar-title);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .video-container video {
            width: 100%;
            height: min(62vh, 560px);
            min-height: 430px;
            object-fit: contain;
            display: block;
            background-color: #000;
        }

        .video-placeholder {
            text-align: center;
            color: var(--muted);
            padding: 64px 24px;
        }

        .active-camera-panel {
            margin-top: 18px;
            padding: 16px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--active-panel-bg);
        }

        .active-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .active-name {
            color: var(--text);
            font-size: 1rem;
            font-weight: 750;
        }

        .stat-box {
            min-height: 112px;
            border-radius: 9px;
            padding: 15px;
            background: var(--stat-bg);
        }

        .stat-icon {
            width: 30px;
            height: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--stat-icon-bg);
            color: var(--muted);
            margin-bottom: 12px;
        }

        .stat-box .angka {
            color: var(--text);
            font-size: clamp(1.55rem, 3vw, 2.05rem);
            font-weight: 780;
            line-height: 1;
        }

        .stat-box .label {
            color: var(--muted);
            font-size: 0.74rem;
            font-weight: 650;
            margin-top: 8px;
            text-transform: uppercase;
            letter-spacing: 0.07em;
        }

        .metric-motor {
            border-top: 2px solid rgba(247, 185, 85, 0.78);
        }

        .metric-mobil {
            border-top: 2px solid rgba(57, 217, 138, 0.78);
        }

        .metric-bus {
            border-top: 2px solid rgba(69, 201, 232, 0.78);
        }

        .metric-truk {
            border-top: 2px solid rgba(240, 93, 106, 0.78);
        }

        .chart-panel {
            margin-top: 18px;
        }

        .chart-box {
            border-radius: 10px;
            padding: 16px;
            height: 340px;
            background: var(--chart-bg);
        }

        .congestion-chart-box {
            height: 280px;
        }

        .dot-live {
            width: 8px;
            height: 8px;
            background-color: var(--green);
            border-radius: 50%;
            display: inline-block;
            animation: pulse 1.5s infinite;
            box-shadow: 0 0 0 4px var(--live-ring);
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        .last-update {
            font-size: 0.74rem;
            color: var(--muted);
        }

        .empty-state {
            color: var(--muted);
            padding: 36px 18px;
            text-align: center;
        }

        @media (max-width: 991.98px) {
            .camera-list {
                max-height: 360px;
            }

            .workspace-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 767.98px) {
            .navbar-custom {
                align-items: flex-start;
                gap: 14px;
            }

            .ops-status {
                justify-content: flex-start;
                width: 100%;
            }

            .video-container,
            .video-container video {
                min-height: 300px;
                height: 300px;
            }

            .active-summary {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    @php
        $defaultKey = $data->firstWhere('key', 'simpang_mirota')->key ?? (optional($data->first())->key ?? '');
        $aktif = $defaultKey ? $data->firstWhere('key', $defaultKey) : null;
    @endphp

    {{-- NAVBAR --}}
    <div class="app-shell">
        <nav class="navbar navbar-custom px-3 px-lg-4 py-3">
            <div class="d-flex align-items-center gap-3">
                <span class="brand-mark">
                    <i class="bi bi-camera-video-fill"></i>
                </span>
                <div>
                    <div class="brand-title">Monitoring Kemacetan Jogja</div>
                    <div class="brand-subtitle">Smart City Traffic Operations</div>
                </div>
            </div>

            <div class="ops-status d-flex align-items-center gap-2">
                <div class="ops-pill">
                    <span class="dot-live" id="ai-status-dot"></span>
                    <strong id="ai-status-text" class="text-success">AI Online</strong>
                </div>

                <div class="ops-pill">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Last Sync</span>
                    <strong id="last-sync-text">-</strong>
                </div>

                <div class="ops-pill">
                    <i class="bi bi-stopwatch"></i>
                    <span>Delay</span>
                    <strong><span id="data-delay-text">-</span>s</strong>
                </div>

                <label class="ops-pill theme-control" for="theme-select">
                    <i class="bi bi-circle-half"></i>
                    <span>Theme</span>
                    <select class="theme-select" id="theme-select" aria-label="Theme mode">
                        <option value="system">System</option>
                        <option value="light">Light</option>
                        <option value="dark">Dark</option>
                    </select>
                </label>
            </div>
        </nav>

        <main class="container-fluid px-3 px-lg-4 py-4">
            <div class="row g-4 dashboard-grid">

            {{-- KOLOM KIRI: Daftar Jalan --}}
                <aside class="col-lg-3">
                    <div class="panel">
                        <div class="panel-header">
                            <div>
                                <div class="eyebrow">Camera Network</div>
                                <div class="section-title">Pilih Lokasi</div>
                            </div>
                            <div class="camera-count">{{ $data->count() }} titik</div>
                        </div>

                        <div class="camera-list d-flex flex-column gap-2" id="daftar-jalan">
                    @forelse($data as $item)
                                <div class="card-jalan p-3 {{ $item->key == $defaultKey ? 'active' : '' }}"
                                    onclick="pilihJalan('{{ $item->key }}', this)">
                                    <div class="d-flex justify-content-between align-items-start gap-2">
                                <div class="pe-1">
                                    <div class="camera-name">{{ $item->nama }}</div>
                                    <div class="last-update mt-1">
                                        <i class="bi bi-clock me-1"></i>{{ $item->waktu_update }}
                                    </div>
                                </div>

                                <span
                                    class="badge-status
                                    @if ($item->status == 'Lancar') status-lancar
                                    @elseif($item->status == 'Ramai Lancar') status-ramai-lancar
                                    @elseif($item->status == 'Padat Merayap') status-padat-merayap
                                    @else status-macet-total @endif">
                                    {{ $item->status }}
                                </span>
                            </div>

                                    <div class="vehicle-count mt-3" data-total-kendaraan>
                                <i class="bi bi-car-front me-1"></i>{{ $item->total_kendaraan }} kendaraan
                            </div>
                        </div>
                    @empty
                                <div class="empty-state">
                            <i class="bi bi-hourglass-split d-block mb-2" style="font-size: 1.5rem;"></i>
                            Menunggu data dari Python...
                        </div>
                    @endforelse
                        </div>
                    </div>
                </aside>

            {{-- KOLOM KANAN: Video + Statistik + Chart --}}
                <section class="col-lg-9">
                    <div class="workspace-header">
                        <div>
                            <div class="eyebrow">Live Monitoring</div>
                            <h1 class="workspace-title" id="active-camera-name">
                                {{ $aktif ? $aktif->nama : 'Belum ada kamera aktif' }}
                            </h1>
                            <div class="workspace-meta">HLS stream, realtime count, dan riwayat 30 menit.</div>
                        </div>

                        <div class="feed-chip">
                            <span class="dot-live"></span>
                            <span>Realtime Feed</span>
                        </div>
                    </div>

                {{-- Video Stream --}}
                    <div class="video-shell mb-4">
                        <div class="video-toolbar">
                            <div class="video-toolbar-title">
                                <i class="bi bi-broadcast-pin me-2"></i>Live HLS Stream
                            </div>
                            <div class="section-note" id="active-camera-stream-label">
                                {{ $aktif ? $aktif->nama : 'Stream tidak tersedia' }}
                            </div>
                        </div>

                <div class="video-container" id="video-wrapper">
                    @if ($data->count() > 0)
                        <video id="video-stream" controls autoplay muted playsinline>
                            Browser tidak mendukung video HLS.
                        </video>
                    @else
                        <div class="video-placeholder">
                            <i class="bi bi-camera-video-off" style="font-size: 3rem;"></i>
                            <p class="mt-3 mb-1">Belum ada stream tersedia</p>
                            <small>Pastikan Python API sudah berjalan</small>
                        </div>
                    @endif
                </div>
                    </div>

                {{-- Statistik Jalan Aktif --}}
                <div id="statistik-aktif">
                    @if ($aktif)
                        <div class="active-camera-panel">
                            <div class="active-summary">
                                <div>
                                    <div class="eyebrow">Active Camera</div>
                                    <div class="active-name">{{ $aktif->nama }}</div>
                                </div>

                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span
                                        class="status-badge
                                        @if ($aktif->status == 'Lancar') status-lancar
                                        @elseif($aktif->status == 'Ramai Lancar') status-ramai-lancar
                                        @elseif($aktif->status == 'Padat Merayap') status-padat-merayap
                                        @else status-macet-total @endif">
                                        {{ $aktif->status }}
                                    </span>
                                    <span class="section-note">{{ $aktif->total_kendaraan }} kendaraan</span>
                                </div>
                            </div>

                        <div class="row g-3">
                            <div class="col-6 col-md-3">
                                <div class="stat-box metric-motor">
                                    <div class="stat-icon"><i class="bi bi-bicycle"></i></div>
                                    <div class="angka">{{ $aktif->motor }}</div>
                                    <div class="label">Motor</div>
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="stat-box metric-mobil">
                                    <div class="stat-icon"><i class="bi bi-car-front"></i></div>
                                    <div class="angka">{{ $aktif->mobil }}</div>
                                    <div class="label">Mobil</div>
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="stat-box metric-bus">
                                    <div class="stat-icon"><i class="bi bi-bus-front"></i></div>
                                    <div class="angka">{{ $aktif->bus }}</div>
                                    <div class="label">Bus</div>
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="stat-box metric-truk">
                                    <div class="stat-icon"><i class="bi bi-truck"></i></div>
                                    <div class="angka">{{ $aktif->truk }}</div>
                                    <div class="label">Truk</div>
                                </div>
                            </div>
                        </div>
                        </div>
                    @endif
                </div>

                {{-- Chart Riwayat --}}
                    <div class="chart-panel">
                        <div class="section-heading mb-3">
                            <div>
                                <div class="eyebrow">Traffic History</div>
                                <div class="section-title">Grafik Riwayat Kendaraan</div>
                            </div>
                            <div class="section-note">30 menit terakhir</div>
                        </div>

                    <div class="chart-box">
                        <canvas id="traffic-history-chart"></canvas>
                    </div>
                </div>

                    <div class="chart-panel">
                        <div class="section-heading mb-3">
                            <div>
                                <div class="eyebrow">Congestion Index</div>
                                <div class="section-title">Grafik Tingkat Kemacetan</div>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-wrap justify-content-end">
                                <span
                                    id="current-congestion-status"
                                    class="status-badge
                                    @if ($aktif && $aktif->status == 'Lancar') status-lancar
                                    @elseif($aktif && $aktif->status == 'Ramai Lancar') status-ramai-lancar
                                    @elseif($aktif && $aktif->status == 'Padat Merayap') status-padat-merayap
                                    @else status-macet-total @endif">
                                    {{ $aktif ? $aktif->status : 'Tidak tersedia' }}
                                </span>
                                <span class="section-note">30 menit terakhir</span>
                            </div>
                        </div>

                        <div class="chart-box congestion-chart-box">
                            <canvas id="congestion-history-chart"></canvas>
                        </div>
                    </div>

                </section>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const trafficData = @json($data->keyBy('key'));

        const themeStorageKey = 'traffic-dashboard-theme';
        const themeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

        let keyAktif = '{{ $defaultKey }}';
        let hlsPlayer = null;
        let trafficHistoryChart = null;
        let congestionHistoryChart = null;

        function getCssVar(name) {
            return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
        }

        function getThemeChoice() {
            const storedTheme = localStorage.getItem(themeStorageKey);
            return ['system', 'light', 'dark'].includes(storedTheme) ? storedTheme : 'system';
        }

        function resolveTheme(choice) {
            return choice === 'system' ? (themeMediaQuery.matches ? 'dark' : 'light') : choice;
        }

        function refreshThemeAwareCharts() {
            if (!keyAktif) return;

            if (trafficHistoryChart) {
                loadTrafficHistoryChart(keyAktif);
            }

            if (congestionHistoryChart) {
                loadCongestionHistoryChart(keyAktif);
            }
        }

        function applyThemeChoice(choice, persist = true) {
            const safeChoice = ['system', 'light', 'dark'].includes(choice) ? choice : 'system';

            if (persist) {
                localStorage.setItem(themeStorageKey, safeChoice);
            }

            document.documentElement.dataset.theme = resolveTheme(safeChoice);
            document.documentElement.dataset.themeChoice = safeChoice;

            const themeSelect = document.getElementById('theme-select');
            if (themeSelect) {
                themeSelect.value = safeChoice;
            }
        }

        function initializeThemeMode() {
            const themeSelect = document.getElementById('theme-select');
            applyThemeChoice(getThemeChoice(), false);

            if (themeSelect) {
                themeSelect.addEventListener('change', function() {
                    applyThemeChoice(this.value);
                    refreshThemeAwareCharts();
                });
            }

            const handleSystemThemeChange = function() {
                if (getThemeChoice() === 'system') {
                    applyThemeChoice('system', false);
                    refreshThemeAwareCharts();
                }
            };

            if (themeMediaQuery.addEventListener) {
                themeMediaQuery.addEventListener('change', handleSystemThemeChange);
            } else {
                themeMediaQuery.addListener(handleSystemThemeChange);
            }
        }

        function normalizeTrafficItem(item) {
            if (!item) return null;

            return {
                key: item.key,
                nama: item.nama,
                status: item.status,
                total_kendaraan: Number(item.total_kendaraan ?? 0),
                motor: Number(item.motor ?? item.detail?.motor ?? 0),
                mobil: Number(item.mobil ?? item.detail?.mobil ?? 0),
                bus: Number(item.bus ?? item.detail?.bus ?? 0),
                truk: Number(item.truk ?? item.detail?.truk ?? 0),
                waktu_update: item.waktu_update ?? '-',
            };
        }

        function getStatusClass(status) {
            if (status === 'Lancar') return 'status-lancar';
            if (status === 'Ramai Lancar') return 'status-ramai-lancar';
            if (status === 'Padat Merayap') return 'status-padat-merayap';
            return 'status-macet-total';
        }

        function mapStatusToCongestionScore(status) {
            if (status === 'Lancar') return 20;
            if (status === 'Ramai Lancar') return 45;
            if (status === 'Padat Merayap') return 70;
            if (status === 'Macet Total') return 90;
            return null;
        }

        function getHistoryRowStatus(row) {
            return row.status ??
                row.avg_status ??
                row.congestion_status ??
                row.status_kemacetan ??
                row.traffic_status ??
                null;
        }

        function getCongestionScore(row) {
            const score = Number(row.avg_congestion_score);

            if (Number.isFinite(score)) {
                return Math.max(0, Math.min(100, score));
            }

            const fallbackScore = mapStatusToCongestionScore(getHistoryRowStatus(row));
            return fallbackScore ?? 0;
        }

        function updateCongestionStatusBadge(status) {
            const badge = document.getElementById('current-congestion-status');
            if (!badge) return;

            badge.className = `status-badge ${getStatusClass(status)}`;
            badge.textContent = status || 'Tidak tersedia';
        }

        function loadHlsVideo(key) {
            const video = document.getElementById('video-stream');

            if (!video || !key) return;

            const hlsUrl = `http://localhost:5000/hls/${key}/index.m3u8?t=${Date.now()}`;

            if (hlsPlayer) {
                hlsPlayer.destroy();
                hlsPlayer = null;
            }

            video.pause();
            video.removeAttribute('src');
            video.load();

            if (Hls.isSupported()) {
                hlsPlayer = new Hls({
                    liveSyncDurationCount: 2,
                    maxBufferLength: 10,
                    enableWorker: true,
                });

                hlsPlayer.loadSource(hlsUrl);
                hlsPlayer.attachMedia(video);

                hlsPlayer.on(Hls.Events.MANIFEST_PARSED, function() {
                    video.play().catch(() => {});
                });

                hlsPlayer.on(Hls.Events.ERROR, function(event, data) {
                    console.error('HLS error:', data);
                });
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                video.src = hlsUrl;
                video.play().catch(() => {});
            } else {
                console.error('Browser tidak mendukung HLS');
            }
        }

        function pilihJalan(key, elCard) {
            document.querySelectorAll('.card-jalan').forEach(card => {
                card.classList.remove('active');
            });

            elCard.classList.add('active');
            keyAktif = key;

            loadHlsVideo(key);
            refreshActiveCameraStat();
            loadTrafficHistoryChart(key);
            loadCongestionHistoryChart(key);

            const item = normalizeTrafficItem(trafficData[key]);

            if (item) {
                updateStatistik(item);
                updateCongestionStatusBadge(item.status);
            }
        }

        function updateStatistik(item) {
            const statistikAktif = document.getElementById('statistik-aktif');

            if (!statistikAktif || !item) return;

            const activeCameraName = document.getElementById('active-camera-name');
            const activeCameraStreamLabel = document.getElementById('active-camera-stream-label');
            const statusClass = getStatusClass(item.status);

            if (activeCameraName) {
                activeCameraName.textContent = item.nama;
            }

            if (activeCameraStreamLabel) {
                activeCameraStreamLabel.textContent = item.nama;
            }

            updateCongestionStatusBadge(item.status);

            statistikAktif.innerHTML = `
                <div class="active-camera-panel">
                    <div class="active-summary">
                        <div>
                            <div class="eyebrow">Active Camera</div>
                            <div class="active-name">${item.nama}</div>
                        </div>

                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="status-badge ${statusClass}">${item.status}</span>
                            <span class="section-note">${item.total_kendaraan} kendaraan</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="stat-box metric-motor">
                                <div class="stat-icon"><i class="bi bi-bicycle"></i></div>
                                <div class="angka">${item.motor}</div>
                                <div class="label">Motor</div>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="stat-box metric-mobil">
                                <div class="stat-icon"><i class="bi bi-car-front"></i></div>
                                <div class="angka">${item.mobil}</div>
                                <div class="label">Mobil</div>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="stat-box metric-bus">
                                <div class="stat-icon"><i class="bi bi-bus-front"></i></div>
                                <div class="angka">${item.bus}</div>
                                <div class="label">Bus</div>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="stat-box metric-truk">
                                <div class="stat-icon"><i class="bi bi-truck"></i></div>
                                <div class="angka">${item.truk}</div>
                                <div class="label">Truk</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        function updateMeta(meta) {
            if (!meta) return;

            const statusDot = document.getElementById('ai-status-dot');
            const statusText = document.getElementById('ai-status-text');
            const lastSyncText = document.getElementById('last-sync-text');
            const dataDelayText = document.getElementById('data-delay-text');

            if (lastSyncText) {
                lastSyncText.textContent = meta.latest_update ?? '-';
            }

            if (dataDelayText) {
                const delay = Number(meta.data_delay_seconds ?? 0);
                dataDelayText.textContent = Math.abs(delay).toFixed(0);
            }

            if (!statusDot || !statusText) return;

            if (meta.ai_online) {
                statusDot.style.backgroundColor = getCssVar('--green');
                statusText.textContent = 'AI Online';
                statusText.className = 'text-success';
            } else {
                statusDot.style.backgroundColor = getCssVar('--red');
                statusText.textContent = 'AI Offline / Delay';
                statusText.className = 'text-danger';
            }
        }

        function updateCard(item) {
            const card = document.querySelector(`[onclick="pilihJalan('${item.key}', this)"]`);

            if (!card) return;

            const lastUpdate = card.querySelector('.last-update');
            const badge = card.querySelector('.badge-status');
            const totalText = card.querySelector('[data-total-kendaraan]');

            if (lastUpdate) {
                lastUpdate.innerHTML = `<i class="bi bi-clock me-1"></i>${item.waktu_update}`;
            }

            if (badge) {
                badge.className = `badge-status ${getStatusClass(item.status)}`;
                badge.textContent = item.status;
            }

            if (totalText) {
                totalText.innerHTML = `<i class="bi bi-car-front me-1"></i>${item.total_kendaraan} kendaraan`;
            }
        }

        function refreshTrafficData() {
            fetch('/api/traffic')
                .then(response => response.json())
                .then(json => {
                    if (!json.success) return;

                    updateMeta(json.meta);

                    json.data.forEach(rawItem => {
                        const item = normalizeTrafficItem(rawItem);

                        if (!item) return;

                        trafficData[item.key] = item;
                        updateCard(item);
                    });
                })
                .catch(error => {
                    console.error('Gagal mengambil data traffic Laravel:', error);

                    updateMeta({
                        ai_online: false,
                        latest_update: '-',
                        data_delay_seconds: '-'
                    });
                });
        }

        function refreshActiveCameraStat() {
            if (!keyAktif) return;

            fetch(`http://localhost:5000/api/traffic/${keyAktif}`)
                .then(response => response.json())
                .then(json => {
                    if (!json.success || !json.data) return;

                    const item = normalizeTrafficItem(json.data);

                    if (!item) return;

                    trafficData[item.key] = item;
                    updateStatistik(item);
                    updateCard(item);
                })
                .catch(error => {
                    console.error('Gagal ambil data realtime kamera aktif dari Python:', error);
                });
        }

        function formatTimeLabel(value) {
            if (!value) return '-';

            const date = new Date(String(value).replace(' ', 'T'));

            if (Number.isNaN(date.getTime())) {
                return value;
            }

            return date.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
            });
        }

        function getChartThemeColors() {
            return {
                label: getCssVar('--chart-label'),
                grid: getCssVar('--chart-grid'),
                gridStrong: getCssVar('--chart-grid-strong'),
                tooltipBg: getCssVar('--tooltip-bg'),
                tooltipBorder: getCssVar('--tooltip-border'),
                tooltipTitle: getCssVar('--tooltip-title'),
                tooltipBody: getCssVar('--tooltip-body'),
                blue: getCssVar('--blue'),
                green: getCssVar('--green'),
                amber: getCssVar('--amber'),
                red: getCssVar('--red'),
                cyan: getCssVar('--cyan'),
            };
        }

        function loadTrafficHistoryChart(key) {
            if (!key) return;

            fetch(`/api/traffic-history/${key}?minutes=30`)
                .then(response => response.json())
                .then(json => {
                    if (!json.success) return;

                    const labels = json.data.map(row => formatTimeLabel(row.window_start));

                    const totalData = json.data.map(row => Number(row.avg_total_kendaraan ?? 0));
                    const motorData = json.data.map(row => Number(row.avg_motor ?? 0));
                    const mobilData = json.data.map(row => Number(row.avg_mobil ?? 0));
                    const busData = json.data.map(row => Number(row.avg_bus ?? 0));
                    const trukData = json.data.map(row => Number(row.avg_truk ?? 0));

                    const canvas = document.getElementById('traffic-history-chart');
                    if (!canvas) return;

                    const ctx = canvas.getContext('2d');

                    if (trafficHistoryChart) {
                        trafficHistoryChart.destroy();
                    }

                    const chartColors = getChartThemeColors();

                    trafficHistoryChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Total',
                                    data: totalData,
                                    tension: 0.32,
                                    borderColor: chartColors.blue,
                                    backgroundColor: 'rgba(79, 140, 255, 0.12)',
                                    borderWidth: 2,
                                    pointRadius: 0,
                                    pointHoverRadius: 4,
                                },
                                {
                                    label: 'Motor',
                                    data: motorData,
                                    tension: 0.32,
                                    borderColor: chartColors.amber,
                                    backgroundColor: 'rgba(247, 185, 85, 0.08)',
                                    borderWidth: 2,
                                    pointRadius: 0,
                                    pointHoverRadius: 4,
                                },
                                {
                                    label: 'Mobil',
                                    data: mobilData,
                                    tension: 0.32,
                                    borderColor: chartColors.green,
                                    backgroundColor: 'rgba(57, 217, 138, 0.08)',
                                    borderWidth: 2,
                                    pointRadius: 0,
                                    pointHoverRadius: 4,
                                },
                                {
                                    label: 'Bus',
                                    data: busData,
                                    tension: 0.32,
                                    borderColor: chartColors.cyan,
                                    backgroundColor: 'rgba(69, 201, 232, 0.08)',
                                    borderWidth: 2,
                                    pointRadius: 0,
                                    pointHoverRadius: 4,
                                },
                                {
                                    label: 'Truk',
                                    data: trukData,
                                    tension: 0.32,
                                    borderColor: chartColors.red,
                                    backgroundColor: 'rgba(240, 93, 106, 0.08)',
                                    borderWidth: 2,
                                    pointRadius: 0,
                                    pointHoverRadius: 4,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: false,
                            plugins: {
                                legend: {
                                    labels: {
                                        color: chartColors.label,
                                        boxWidth: 10,
                                        boxHeight: 10,
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        padding: 18,
                                    }
                                },
                                tooltip: {
                                    backgroundColor: chartColors.tooltipBg,
                                    borderColor: chartColors.tooltipBorder,
                                    borderWidth: 1,
                                    titleColor: chartColors.tooltipTitle,
                                    bodyColor: chartColors.tooltipBody,
                                    displayColors: true,
                                }
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        color: chartColors.label,
                                        maxRotation: 0,
                                    },
                                    grid: {
                                        color: chartColors.grid,
                                        drawBorder: false,
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: chartColors.label,
                                        precision: 0
                                    },
                                    grid: {
                                        color: chartColors.gridStrong,
                                        drawBorder: false,
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Gagal ambil history chart:', error);
                });
        }

        function loadCongestionHistoryChart(key) {
            if (!key) return;

            fetch(`/api/traffic-history/${key}?minutes=30`)
                .then(response => response.json())
                .then(json => {
                    if (!json.success) return;

                    const labels = json.data.map(row => formatTimeLabel(row.window_start));
                    const congestionData = json.data.map(row => getCongestionScore(row));

                    const canvas = document.getElementById('congestion-history-chart');
                    if (!canvas) return;

                    const ctx = canvas.getContext('2d');

                    if (congestionHistoryChart) {
                        congestionHistoryChart.destroy();
                    }

                    const chartColors = getChartThemeColors();

                    congestionHistoryChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Tingkat Kemacetan',
                                data: congestionData,
                                tension: 0.34,
                                borderColor: chartColors.red,
                                backgroundColor: 'rgba(240, 93, 106, 0.12)',
                                borderWidth: 2,
                                pointRadius: 0,
                                pointHoverRadius: 4,
                                fill: true,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: false,
                            plugins: {
                                title: {
                                    display: false,
                                    text: 'Grafik Tingkat Kemacetan',
                                    color: chartColors.label,
                                },
                                legend: {
                                    labels: {
                                        color: chartColors.label,
                                        boxWidth: 10,
                                        boxHeight: 10,
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        padding: 18,
                                    }
                                },
                                tooltip: {
                                    backgroundColor: chartColors.tooltipBg,
                                    borderColor: chartColors.tooltipBorder,
                                    borderWidth: 1,
                                    titleColor: chartColors.tooltipTitle,
                                    bodyColor: chartColors.tooltipBody,
                                    callbacks: {
                                        label: function(context) {
                                            return `Tingkat Kemacetan: ${Math.round(context.parsed.y)} / 100`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        color: chartColors.label,
                                        maxRotation: 0,
                                    },
                                    grid: {
                                        color: chartColors.grid,
                                        drawBorder: false,
                                    }
                                },
                                y: {
                                    min: 0,
                                    max: 100,
                                    ticks: {
                                        color: chartColors.label,
                                        stepSize: 20,
                                        callback: function(value) {
                                            return `${value}`;
                                        }
                                    },
                                    grid: {
                                        color: chartColors.gridStrong,
                                        drawBorder: false,
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Gagal ambil congestion history chart:', error);
                });
        }

        if (keyAktif) {
            loadHlsVideo(keyAktif);
            refreshActiveCameraStat();
            loadTrafficHistoryChart(keyAktif);
            loadCongestionHistoryChart(keyAktif);
        }

        initializeThemeMode();
        refreshTrafficData();

        setInterval(refreshTrafficData, 3000);
        setInterval(refreshActiveCameraStat, 1000);
        setInterval(() => {
            loadTrafficHistoryChart(keyAktif);
            loadCongestionHistoryChart(keyAktif);
        }, 30000);
    </script>
</body>

</html>
