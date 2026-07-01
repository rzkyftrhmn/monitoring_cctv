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
            --bg: #0f1724;
            --surface: #141e2b;
            --surface-2: #1a2533;
            --surface-3: #223044;
            --border: #2b3a4d;
            --border-strong: #415168;
            --text: #edf2f7;
            --muted: #a6b2c2;
            --muted-2: #8996a8;
            --blue: #4d83d8;
            --green: #2fb36f;
            --amber: #d79a2b;
            --orange: #c96e31;
            --red: #d14b5a;
            --cyan: #3398b8;
            --body-bg: #0f1724;
            --navbar-bg: #111b28;
            --brand-border: #4d83d8;
            --brand-bg: #182840;
            --brand-color: #b9d2fa;
            --pill-bg: #172232;
            --panel-bg: #141e2b;
            --panel-header-bg: #182434;
            --soft-bg: #101927;
            --card-bg: #172232;
            --card-hover-bg: #1c2a3d;
            --card-active-bg: #20324a;
            --card-hover-border: #4d83d8;
            --card-active-border: #7aa5e6;
            --vehicle-text: #c2cad6;
            --scroll-thumb: #43546b;
            --video-bg: #05070b;
            --video-toolbar-bg: #101927;
            --video-toolbar-title: #cbd5e1;
            --active-panel-bg: #141e2b;
            --stat-bg: #172232;
            --stat-icon-bg: #101927;
            --chart-bg: #141e2b;
            --chart-label: #cbd5e1;
            --chart-grid: rgba(166, 178, 194, 0.14);
            --chart-grid-strong: rgba(166, 178, 194, 0.18);
            --tooltip-bg: #0b111a;
            --tooltip-border: #415168;
            --tooltip-title: #e5edf7;
            --tooltip-body: #cbd5e1;
            --live-ring: transparent;
            --status-lancar-bg: #123321;
            --status-lancar-border: #2fb36f;
            --status-lancar-text: #9be0ba;
            --status-ramai-bg: #102d3a;
            --status-ramai-border: #3398b8;
            --status-ramai-text: #a4d9e8;
            --status-padat-bg: #352814;
            --status-padat-border: #d79a2b;
            --status-padat-text: #f0c56d;
            --status-macet-bg: #3b1820;
            --status-macet-border: #d14b5a;
            --status-macet-text: #f4a3ad;
            --shadow: 0 8px 20px rgba(0, 0, 0, 0.18);
        }

        html[data-theme="light"] {
            color-scheme: light;
            --bg: #f4f6f8;
            --surface: #ffffff;
            --surface-2: #f7f9fb;
            --surface-3: #e5ebf2;
            --border: #d5dde7;
            --border-strong: #9aa8b8;
            --text: #1b2733;
            --muted: #5d6b7c;
            --muted-2: #6f7c8d;
            --blue: #1a5fb4;
            --green: #0f7b4f;
            --amber: #946200;
            --orange: #a65418;
            --red: #b42335;
            --cyan: #006b8f;
            --body-bg: #f4f6f8;
            --navbar-bg: #ffffff;
            --brand-border: #1a5fb4;
            --brand-bg: #eef4fb;
            --brand-color: #174a8b;
            --pill-bg: #f7f9fb;
            --panel-bg: #ffffff;
            --panel-header-bg: #f7f9fb;
            --soft-bg: #eef2f6;
            --card-bg: #ffffff;
            --card-hover-bg: #f1f6fb;
            --card-active-bg: #e8f1fb;
            --card-hover-border: #8bb4df;
            --card-active-border: #1a5fb4;
            --vehicle-text: #415061;
            --scroll-thumb: #b6c0cc;
            --video-bg: #0b1220;
            --video-toolbar-bg: #ffffff;
            --video-toolbar-title: #1e293b;
            --active-panel-bg: #ffffff;
            --stat-bg: #f7f9fb;
            --stat-icon-bg: #eef2f6;
            --chart-bg: #ffffff;
            --chart-label: #334155;
            --chart-grid: rgba(93, 107, 124, 0.14);
            --chart-grid-strong: rgba(93, 107, 124, 0.2);
            --tooltip-bg: #ffffff;
            --tooltip-border: #d5dde7;
            --tooltip-title: #142033;
            --tooltip-body: #334155;
            --live-ring: transparent;
            --status-lancar-bg: #e7f6ee;
            --status-lancar-border: #0f7b4f;
            --status-lancar-text: #075f3c;
            --status-ramai-bg: #e6f4f8;
            --status-ramai-border: #006b8f;
            --status-ramai-text: #00536f;
            --status-padat-bg: #fff4d8;
            --status-padat-border: #946200;
            --status-padat-text: #6b4700;
            --status-macet-bg: #fae6ea;
            --status-macet-border: #b42335;
            --status-macet-text: #8f1b2a;
            --shadow: 0 3px 12px rgba(27, 39, 51, 0.08);
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
            box-shadow: var(--shadow);
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

        .theme-control i {
            color: var(--muted);
            pointer-events: none;
        }

        .theme-segment {
            display: inline-flex;
            align-items: center;
            gap: 2px;
            padding: 2px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--soft-bg);
        }

        .theme-option {
            min-height: 28px;
            padding: 4px 9px;
            border: 1px solid transparent;
            border-radius: 6px;
            background: transparent;
            color: var(--muted);
            font-size: 0.75rem;
            font-weight: 650;
            line-height: 1;
        }

        .theme-option:hover {
            color: var(--text);
            background: var(--card-hover-bg);
        }

        .theme-option.active,
        .theme-option[aria-pressed="true"] {
            border-color: var(--card-active-border);
            background: var(--card-active-bg);
            color: var(--text);
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
            max-height: calc(100vh - 430px);
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

        .status-badge::before,
        .badge-status::before {
            content: "";
            width: 6px;
            height: 6px;
            margin-right: 6px;
            border-radius: 50%;
            background: currentColor;
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

        .ai-insight-panel {
            margin-top: 18px;
        }

        .ai-insight-box {
            padding: 16px;
            border-radius: 10px;
            background: var(--panel-bg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        .insight-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            padding-bottom: 14px;
            margin-bottom: 14px;
            border-bottom: 1px solid var(--border);
        }

        .insight-title {
            color: var(--text);
            font-size: 1rem;
            font-weight: 750;
            margin: 2px 0 0;
        }

        .insight-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 14px;
        }

        .insight-metric {
            padding: 13px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--stat-bg);
        }

        .insight-metric-label {
            color: var(--muted);
            font-size: 0.72rem;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .insight-metric-value {
            color: var(--text);
            font-size: 1rem;
            font-weight: 760;
            line-height: 1.25;
        }

        .insight-recommendation {
            padding: 14px;
            border: 1px solid var(--border-strong);
            border-radius: 9px;
            background: var(--soft-bg);
        }

        .insight-recommendation-title {
            color: var(--muted);
            font-size: 0.72rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .insight-recommendation-body {
            color: var(--text);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .priority-score-track {
            width: 100%;
            height: 7px;
            border-radius: 999px;
            background: var(--soft-bg);
            overflow: hidden;
            margin-top: 9px;
        }

        .priority-score-fill {
            width: 0%;
            height: 100%;
            border-radius: inherit;
            background: var(--blue);
            transition: width 0.25s ease, background-color 0.25s ease;
        }

        .priority-panel {
            margin-bottom: 16px;
        }

        .priority-list {
            padding: 10px;
        }

        .priority-item {
            width: 100%;
            text-align: left;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--card-bg);
            color: var(--text);
            padding: 12px;
            cursor: pointer;
            transition: border-color 0.18s ease, background-color 0.18s ease;
        }

        .priority-item:hover,
        .priority-item:focus {
            border-color: var(--card-hover-border);
            background: var(--card-hover-bg);
            outline: 0;
        }

        .priority-item.active {
            border-color: var(--card-active-border);
            background: var(--card-active-bg);
        }

        .priority-rank {
            width: 26px;
            height: 26px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-strong);
            border-radius: 6px;
            color: var(--text);
            font-size: 0.78rem;
            font-weight: 750;
            flex: 0 0 auto;
        }

        .priority-title {
            color: var(--text);
            font-size: 0.86rem;
            font-weight: 750;
            line-height: 1.25;
        }

        .priority-meta,
        .priority-copy {
            color: var(--muted);
            font-size: 0.74rem;
            line-height: 1.4;
        }

        .priority-copy strong {
            color: var(--text);
            font-weight: 700;
        }

        .source-note {
            color: var(--muted);
            font-size: 0.72rem;
            line-height: 1.35;
            margin-top: 4px;
        }

        .dot-live {
            width: 8px;
            height: 8px;
            background-color: var(--green);
            border-radius: 50%;
            display: inline-block;
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

            .insight-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .insight-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
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
                    <div class="brand-subtitle">Pusat Pemantauan Lalu Lintas</div>
                </div>
            </div>

            <div class="ops-status d-flex align-items-center gap-2">
                <div class="ops-pill">
                    <span class="dot-live" id="ai-status-dot"></span>
                    <strong id="ai-status-text" class="text-success">Pemantauan Aktif</strong>
                </div>

                <div class="ops-pill">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Pembaruan Terakhir</span>
                    <strong id="last-sync-text">-</strong>
                </div>

                <div class="ops-pill">
                    <i class="bi bi-stopwatch"></i>
                    <span>Jeda Data</span>
                    <strong><span id="data-delay-text">-</span>s</strong>
                </div>

                <div class="ops-pill theme-control" aria-label="Pilihan tema">
                    <i class="bi bi-circle-half"></i>
                    <span>Tema</span>
                    <div class="theme-segment" role="group" aria-label="Pilihan tema">
                        <button class="theme-option" type="button" data-theme-choice="system"
                            aria-pressed="false">System</button>
                        <button class="theme-option" type="button" data-theme-choice="light"
                            aria-pressed="false">Light</button>
                        <button class="theme-option" type="button" data-theme-choice="dark"
                            aria-pressed="false">Dark</button>
                    </div>
                </div>
            </div>
        </nav>

        <main class="container-fluid px-3 px-lg-4 py-4">
            <div class="row g-4 dashboard-grid">

                {{-- KOLOM KIRI: Daftar Jalan --}}
                <aside class="col-lg-3">
                    <div class="panel priority-panel">
                        <div class="panel-header">
                            <div>
                                <div class="eyebrow">Prioritas Operasional</div>
                                <div class="section-title">Daftar Prioritas Lokasi</div>
                            </div>
                            <div class="camera-count">3 teratas</div>
                        </div>

                        <div class="priority-list d-flex flex-column gap-2" id="priority-list">
                            <div class="empty-state py-3">
                                Memuat prioritas lokasi...
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div>
                                <div class="eyebrow">Jaringan Kamera</div>
                                <div class="section-title">Pilih Lokasi</div>
                            </div>
                            <div class="camera-count">{{ $data->count() }} titik</div>
                        </div>

                        <div class="camera-list d-flex flex-column gap-2" id="daftar-jalan">
                            @forelse($data as $item)
                                <div class="card-jalan p-3 {{ $item->key == $defaultKey ? 'active' : '' }}"
                                    data-key="{{ $item->key }}"
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
                                    Menunggu data pemantauan...
                                </div>
                            @endforelse
                        </div>
                    </div>
                </aside>

                {{-- KOLOM KANAN: Video + Statistik + Chart --}}
                <section class="col-lg-9">
                    <div class="workspace-header">
                        <div>
                            <div class="eyebrow">Pemantauan Langsung</div>
                            <h1 class="workspace-title" id="active-camera-name">
                                {{ $aktif ? $aktif->nama : 'Belum ada kamera aktif' }}
                            </h1>
                            <div class="workspace-meta">Pantau arus kendaraan, kondisi terbaru, dan perubahan 30 menit terakhir.</div>
                        </div>

                        <div class="feed-chip">
                            <span class="dot-live"></span>
                            <span>Siaran Langsung</span>
                        </div>
                    </div>

                    {{-- Video --}}
                    <div class="video-shell mb-4">
                        <div class="video-toolbar">
                            <div class="video-toolbar-title">
                                <i class="bi bi-broadcast-pin me-2"></i>Siaran Kamera
                            </div>
                            <div class="section-note" id="active-camera-stream-label">
                                {{ $aktif ? $aktif->nama : 'Siaran tidak tersedia' }}
                            </div>
                        </div>

                        <div class="video-container" id="video-wrapper">
                            @if ($data->count() > 0)
                                <video id="video-stream" controls autoplay muted playsinline>
                                    Browser tidak dapat memutar siaran ini.
                                </video>
                            @else
                                <div class="video-placeholder">
                                    <i class="bi bi-camera-video-off" style="font-size: 3rem;"></i>
                                    <p class="mt-3 mb-1">Belum ada siaran tersedia</p>
                                    <small>Pastikan layanan pemantauan sudah berjalan</small>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Prioritas Penanganan --}}
                    <div class="ai-insight-panel" id="ai-insight-panel">
                        <div class="section-heading mb-3">
                            <div>
                                <div class="eyebrow">Ringkasan Pemantauan</div>
                                <div class="section-title">Prioritas Penanganan</div>
                            </div>
                            <div class="section-note">Ringkasan kondisi berdasarkan pemantauan 30 menit terakhir.</div>
                        </div>

                        <div class="ai-insight-box">
                            <div class="insight-header">
                                <div>
                                    <div class="eyebrow">Lokasi Aktif</div>
                                    <div class="insight-title" id="insight-location">
                                        {{ $aktif ? $aktif->nama : 'Belum ada data' }}
                                    </div>
                                    <div class="source-note">Ringkasan kondisi berdasarkan pemantauan 30 menit terakhir.</div>
                                </div>

                                <span class="status-badge status-padat-merayap" id="insight-priority">
                                    Menunggu Analisis
                                </span>
                            </div>

                            <div class="insight-grid">
                                <div class="insight-metric">
                                    <div class="insight-metric-label">Kondisi Terbaru</div>
                                    <div class="insight-metric-value" id="insight-status">
                                        {{ $aktif ? $aktif->status : '-' }}
                                    </div>
                                    <div class="source-note">Kondisi terbaru yang tercatat</div>
                                </div>

                                <div class="insight-metric">
                                    <div class="insight-metric-label">Tren 30 Menit</div>
                                    <div class="insight-metric-value" id="insight-trend">-</div>
                                    <div class="source-note">Dibandingkan dengan beberapa menit sebelumnya</div>
                                </div>

                                <div class="insight-metric">
                                    <div class="insight-metric-label">Tingkat Prioritas</div>
                                    <div class="insight-metric-value" id="insight-score">-</div>
                                    <div class="priority-score-track">
                                        <div class="priority-score-fill" id="priority-score-fill"></div>
                                    </div>
                                </div>

                                <div class="insight-metric">
                                    <div class="insight-metric-label">Perubahan Kondisi</div>
                                    <div class="insight-metric-value" id="insight-change">-</div>
                                    <div class="source-note">Perubahan selama 30 menit</div>
                                </div>
                            </div>

                            <div class="insight-recommendation">
                                <div class="insight-recommendation-title">Saran Tindakan</div>
                                <div class="insight-recommendation-body" id="insight-recommendation">
                                    Menunggu analisis dari data riwayat kemacetan.
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Statistik Jalan Aktif --}}
                    <div id="statistik-aktif">
                        @if ($aktif)
                            <div class="active-camera-panel">
                                <div class="active-summary">
                                    <div>
                                        <div class="eyebrow">Kondisi Terbaru Kamera Aktif</div>
                                        <div class="active-name">{{ $aktif->nama }}</div>
                                        <div class="source-note">Diperbarui dari pemantauan langsung</div>
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
                                <div class="eyebrow">Riwayat Kendaraan</div>
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
                                <div class="eyebrow">Riwayat Kondisi</div>
                                <div class="section-title">Grafik Tingkat Kemacetan</div>
                            </div>
                            <div class="d-flex align-items-center gap-2 flex-wrap justify-content-end">
                                <span id="current-congestion-status"
                                    class="status-badge
                                    @if ($aktif && $aktif->status == 'Lancar') status-lancar
                                    @elseif($aktif && $aktif->status == 'Ramai Lancar') status-ramai-lancar
                                    @elseif($aktif && $aktif->status == 'Padat Merayap') status-padat-merayap
                                    @else status-macet-total @endif">
                                    {{ $aktif ? $aktif->status : 'Tidak tersedia' }}
                                </span>
                                <span class="section-note">Kondisi terbaru dan tren 30 menit ditampilkan terpisah</span>
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

        function escapeHtml(value) {
            const div = document.createElement('div');
            div.textContent = value ?? '';
            return div.innerHTML;
        }

        function getCameraCard(key) {
            if (!key) return null;

            return Array.from(document.querySelectorAll('.card-jalan'))
                .find(card => card.dataset.key === key) ?? null;
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

        function updateThemeSegment(safeChoice) {
            document.querySelectorAll('[data-theme-choice]').forEach(button => {
                const isActive = button.dataset.themeChoice === safeChoice;
                button.classList.toggle('active', isActive);
                button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });
        }

        function applyThemeChoice(choice, persist = true) {
            const safeChoice = ['system', 'light', 'dark'].includes(choice) ? choice : 'system';

            if (persist) {
                localStorage.setItem(themeStorageKey, safeChoice);
            }

            document.documentElement.dataset.theme = resolveTheme(safeChoice);
            document.documentElement.dataset.themeChoice = safeChoice;
            updateThemeSegment(safeChoice);
        }

        function initializeThemeMode() {
            applyThemeChoice(getThemeChoice(), false);

            document.querySelectorAll('[data-theme-choice]').forEach(button => {
                button.addEventListener('click', function() {
                    applyThemeChoice(this.dataset.themeChoice);
                    refreshThemeAwareCharts();
                });
            });

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
                row.dominant_status ??
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

        function getPriorityClass(priority) {
            if (priority === 'Tinggi') return 'status-macet-total';
            if (priority === 'Sedang') return 'status-padat-merayap';
            return 'status-lancar';
        }

        function getPriorityColor(priority) {
            if (priority === 'Tinggi') return getCssVar('--red');
            if (priority === 'Sedang') return getCssVar('--amber');
            return getCssVar('--green');
        }

        function getPriorityDisplayText(priority) {
            if (priority === 'Tinggi') return 'Perlu diprioritaskan';
            if (priority === 'Sedang') return 'Perlu perhatian';
            return 'Aman dipantau berkala';
        }

        function formatConditionChange(change) {
            if (change > 0) return `Naik +${change} poin`;
            if (change < 0) return `Turun ${Math.abs(change)} poin`;
            return 'Tidak berubah';
        }

        function getOperatorRecommendation(data) {
            const priority = data?.priority ?? 'Rendah';
            const trend = data?.trend ?? 'Stabil';
            const status = data?.current_status ?? '';

            if (trend === 'Memburuk Cepat') {
                return 'Kemacetan meningkat cepat. Prioritaskan pemantauan dan pertimbangkan pengaturan arus.';
            }

            if (priority === 'Tinggi') {
                return 'Kondisi padat. Pertimbangkan koordinasi dengan petugas lapangan.';
            }

            if (trend === 'Memburuk') {
                return 'Arus mulai meningkat. Pantau lokasi ini lebih sering.';
            }

            if (status === 'Lancar' || priority === 'Rendah') {
                return 'Kondisi terkendali. Lokasi cukup dipantau secara berkala.';
            }

            return 'Pantau lokasi ini secara berkala dan perhatikan perubahan kondisi berikutnya.';
        }

        function updatePriorityActiveState() {
            document.querySelectorAll('.priority-item').forEach(item => {
                item.classList.toggle('active', item.dataset.key === keyAktif);
            });
        }

        function renderPriorityList(items) {
            const priorityList = document.getElementById('priority-list');
            if (!priorityList) return;

            const topItems = Array.isArray(items) ? items.slice(0, 3) : [];

            if (!topItems.length) {
                priorityList.innerHTML = `
                    <div class="empty-state py-3">
                        Belum ada data prioritas lokasi.
                    </div>
                `;
                return;
            }

            priorityList.innerHTML = topItems.map((item, index) => {
                const priority = item.priority ?? 'Rendah';
                const status = item.current_status ?? '-';
                const trend = item.trend ?? '-';
                const score = Math.round(Number(item.priority_score ?? 0));
                const priorityText = getPriorityDisplayText(priority);
                const recommendation = getOperatorRecommendation(item);

                return `
                    <button class="priority-item ${item.key === keyAktif ? 'active' : ''}" type="button"
                        data-key="${escapeHtml(item.key)}">
                        <div class="d-flex align-items-start gap-2">
                            <span class="priority-rank">${index + 1}</span>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-start justify-content-between gap-2">
                                    <div class="priority-title">${escapeHtml(item.nama ?? '-')}</div>
                                    <span class="status-badge ${getPriorityClass(priority)}">${escapeHtml(priorityText)}</span>
                                </div>
                                <div class="priority-meta mt-2">
                                    <span>${escapeHtml(status)}</span>
                                    <span class="mx-1">|</span>
                                    <span>${escapeHtml(trend)}</span>
                                    <span class="mx-1">|</span>
                                    <span>Prioritas ${score}/100</span>
                                </div>
                                <div class="priority-copy mt-2">
                                    <strong>Alasan:</strong> ${escapeHtml(item.reason ?? '-')}
                                </div>
                                <div class="priority-copy mt-1">
                                    <strong>Saran:</strong> ${escapeHtml(recommendation)}
                                </div>
                            </div>
                        </div>
                    </button>
                `;
            }).join('');

            priorityList.querySelectorAll('.priority-item').forEach(button => {
                button.addEventListener('click', function() {
                    pilihJalan(this.dataset.key);
                });
            });
        }

        function loadTrafficPriorities() {
            fetch('/api/traffic-priorities?minutes=30')
                .then(response => response.json())
                .then(json => {
                    if (!json.success) return;
                    renderPriorityList(json.data);
                    updatePriorityActiveState();
                })
                .catch(error => {
                    console.error('Gagal ambil daftar prioritas lokasi:', error);
                });
        }

        function updateTrafficInsightCard(data) {
            const locationEl = document.getElementById('insight-location');
            const priorityEl = document.getElementById('insight-priority');
            const statusEl = document.getElementById('insight-status');
            const trendEl = document.getElementById('insight-trend');
            const scoreEl = document.getElementById('insight-score');
            const changeEl = document.getElementById('insight-change');
            const recommendationEl = document.getElementById('insight-recommendation');
            const scoreFillEl = document.getElementById('priority-score-fill');

            if (!data) return;

            const priority = data.priority ?? 'Rendah';
            const score = Number(data.priority_score ?? 0);
            const change = Number(data.change_score ?? 0);

            if (locationEl) {
                locationEl.textContent = data.nama ?? '-';
            }

            if (priorityEl) {
                priorityEl.className = `status-badge ${getPriorityClass(priority)}`;
                priorityEl.textContent = getPriorityDisplayText(priority);
            }

            if (statusEl) {
                statusEl.textContent = data.current_status ?? '-';
            }

            if (trendEl) {
                trendEl.textContent = data.trend ?? '-';
            }

            if (scoreEl) {
                scoreEl.textContent = `${Math.round(score)} / 100`;
            }

            if (changeEl) {
                changeEl.textContent = formatConditionChange(change);
            }

            if (recommendationEl) {
                recommendationEl.textContent = getOperatorRecommendation(data);
            }

            if (scoreFillEl) {
                scoreFillEl.style.width = `${Math.max(0, Math.min(100, score))}%`;
                scoreFillEl.style.backgroundColor = getPriorityColor(priority);
            }
        }

        function loadTrafficInsight(key) {
            if (!key) return;

            fetch(`/api/traffic-insight/${key}?minutes=30`)
                .then(response => response.json())
                .then(json => {
                    if (!json.success) return;
                    updateTrafficInsightCard(json);
                })
                .catch(error => {
                    console.error('Gagal ambil prioritas penanganan:', error);
                });
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
                    console.error('Kesalahan pemutar video:', data);
                });
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                video.src = hlsUrl;
                video.play().catch(() => {});
            } else {
                console.error('Browser tidak dapat memutar siaran ini');
            }
        }

        function pilihJalan(key, elCard = null) {
            document.querySelectorAll('.card-jalan').forEach(card => {
                card.classList.remove('active');
            });

            const selectedCard = elCard ?? getCameraCard(key);

            if (selectedCard) {
                selectedCard.classList.add('active');
            }

            keyAktif = key;
            updatePriorityActiveState();

            loadHlsVideo(key);
            refreshActiveCameraStat();
            loadTrafficHistoryChart(key);
            loadCongestionHistoryChart(key);
            loadTrafficInsight(key);

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
                            <div class="eyebrow">Kondisi Terbaru Kamera Aktif</div>
                            <div class="active-name">${escapeHtml(item.nama)}</div>
                            <div class="source-note">Diperbarui dari pemantauan langsung</div>
                        </div>

                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="status-badge ${statusClass}">${escapeHtml(item.status)}</span>
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
                statusText.textContent = 'Pemantauan Aktif';
                statusText.className = 'text-success';
            } else {
                statusDot.style.backgroundColor = getCssVar('--red');
                statusText.textContent = 'Pemantauan Tertunda';
                statusText.className = 'text-danger';
            }
        }

        function updateCard(item) {
            const card = getCameraCard(item.key);

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
                    console.error('Gagal mengambil data lokasi:', error);

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
                    console.error('Gagal mengambil kondisi terbaru kamera aktif:', error);
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
                    console.error('Gagal mengambil grafik riwayat kendaraan:', error);
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
                    console.error('Gagal mengambil grafik tingkat kemacetan:', error);
                });
        }

        if (keyAktif) {
            loadHlsVideo(keyAktif);
            refreshActiveCameraStat();
            loadTrafficHistoryChart(keyAktif);
            loadCongestionHistoryChart(keyAktif);
            loadTrafficInsight(keyAktif);
        }

        initializeThemeMode();
        refreshTrafficData();
        loadTrafficPriorities();

        setInterval(refreshTrafficData, 3000);
        setInterval(refreshActiveCameraStat, 1000);
        setInterval(() => {
            loadTrafficHistoryChart(keyAktif);
            loadCongestionHistoryChart(keyAktif);
            loadTrafficInsight(keyAktif);
            loadTrafficPriorities();
        }, 30000);
    </script>
</body>

</html>
