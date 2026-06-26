# AGENTS.md

## Project Context

This is a Laravel-based traffic monitoring dashboard for an AI Smart City / traffic congestion monitoring system.

The dashboard displays:

- Live CCTV video stream using HLS through `<video>` and `hls.js`
- Realtime active camera statistics from the Python YOLO API
- Traffic cards from Laravel database data
- Historical traffic charts from `traffic_histories`
- AI online/offline metadata

The backend and realtime pipeline are already working. Do not break them.

## Tech Stack

- Laravel Blade
- Bootstrap 5
- Bootstrap Icons
- Vanilla JavaScript
- hls.js
- Chart.js
- Python Flask API for YOLO traffic detection
- MySQL tables:
    - `traffic_data`
    - `traffic_histories`

## Main File to Edit

Primary UI file:

`resources/views/dashboard.blade.php`

Avoid editing backend files unless absolutely necessary.

## Important Existing Features That Must Not Be Broken

Preserve these behaviors:

1. HLS video stream must keep using:
   `http://localhost:5000/hls/{key}/index.m3u8`

2. Active camera realtime stats must keep using:
   `http://localhost:5000/api/traffic/{key}`

3. Laravel traffic polling must keep using:
   `/api/traffic`

4. History chart must keep using:
   `/api/traffic-history/{key}?minutes=30`

5. Keep these JavaScript functions working:
    - `loadHlsVideo(key)`
    - `pilihJalan(key, elCard)`
    - `refreshTrafficData()`
    - `refreshActiveCameraStat()`
    - `loadTrafficHistoryChart(key)`
    - `updateStatistik(item)`
    - `updateCard(item)`
    - `updateMeta(meta)`

6. Do not remove:
    - hls.js
    - Chart.js
    - Bootstrap Icons
    - realtime polling
    - active camera state
    - card click behavior
    - chart loading behavior

## Design Goal

Redesign the dashboard UI to look like a polished smart city traffic operations dashboard.

The UI should feel:

- modern
- professional
- clean
- realistic
- government / command-center inspired
- suitable for a competition demo
- not generic
- not obviously AI-generated
- not like a random Bootstrap template

Avoid the common AI-generated look:

- do not use excessive glassmorphism
- do not use random gradients everywhere
- do not use oversized emoji-like icons
- do not make every card look identical
- do not use fake futuristic neon everywhere
- do not add meaningless decorative sections
- do not add fake data

## Visual Direction

Use a mature dark dashboard style.

Recommended visual feel:

- dark navy / charcoal background
- subtle borders
- soft shadows
- clear spacing
- compact information layout
- clean typography
- status colors with purpose:
    - green for online / lancar
    - blue for ramai lancar
    - orange for padat merayap
    - red for macet total

- video should be visually dominant
- traffic cards should be easy to scan
- statistics should be readable at a glance
- chart section should feel integrated, not pasted below

## Layout Requirements

Keep the current layout concept:

- top navbar
- left camera/location list
- right main content area
- video at the top
- active statistics below video
- historical chart below statistics

Improve the UI by:

- making the active camera card more obvious
- improving spacing and alignment
- making the video container look cleaner
- adding subtle section headers
- making AI status, last sync, and delay look professional
- making chart container visually consistent
- making cards responsive

## Coding Rules

- Use Blade, Bootstrap 5, and plain CSS/JS only.
- Do not install new frontend frameworks.
- Do not convert the project to React/Vue.
- Do not rewrite the backend.
- Do not rename database fields.
- Do not rename API routes.
- Do not change Python API URLs.
- Do not remove existing realtime behavior.
- Do not hardcode fake values.
- Keep code readable and maintainable.
- Keep comments short and useful.

## Acceptance Criteria

The task is complete when:

1. The dashboard still loads without JavaScript errors.
2. Clicking a location card changes the active camera.
3. HLS video still plays for the active camera.
4. Active statistics update in realtime.
5. Left-side cards keep updating from Laravel data.
6. The history chart still renders from `traffic_histories`.
7. The UI looks polished and custom, not like a generic AI-generated Bootstrap template.
8. The dashboard remains responsive on laptop screen sizes.

## Theme Mode Requirement

Add a theme system with three modes:

1. `system`
2. `light`
3. `dark`

Default mode must be `system`, which follows the browser or operating system preference using:

```css
@media (prefers-color-scheme: dark);
```

and JavaScript:

```js
window.matchMedia("(prefers-color-scheme: dark)");
```

Add a small theme toggle/control in the navbar. The control should allow the user to choose:

- System
- Light
- Dark

Persist the selected mode in `localStorage`.

Use this localStorage key:

```js
traffic - dashboard - theme;
```

Do not duplicate the whole stylesheet. Use CSS variables instead.

Recommended CSS variable structure:

```css
:root {
    --bg-page: #f4f6f8;
    --bg-surface: #ffffff;
    --bg-surface-soft: #f8fafc;
    --border-color: #d9dee8;
    --text-main: #172033;
    --text-muted: #667085;
}

[data-theme="dark"] {
    --bg-page: #343434;
    --bg-surface: #1a1d27;
    --bg-surface-soft: #1e2235;
    --border-color: #2a2d3e;
    --text-main: #e0e0e0;
    --text-muted: #6b7280;
}
```

The design must still look professional in both light and dark mode. Avoid making light mode look like plain unstyled Bootstrap.

## Congestion Chart Requirement

Add a second historical chart for congestion level over the last 30 minutes.

This chart must use the existing endpoint:

```txt
/api/traffic-history/{key}?minutes=30
```

Use data from `traffic_histories`.

Preferred field:

```txt
avg_congestion_score
```

If `avg_congestion_score` is missing or null, fallback to status mapping:

```txt
Lancar = 20
Ramai Lancar = 45
Padat Merayap = 70
Macet Total = 90
```

The chart should show whether traffic was congested or not over the last 30 minutes.

Use Chart.js.

Recommended chart:

- line chart
- x-axis: `window_start`
- y-axis: congestion score from 0 to 100
- label: `Tingkat Kemacetan`
- show current status label near the chart header
- keep it visually consistent with the existing vehicle history chart

Do not use fake data.
Do not remove the existing vehicle history chart.
Do not break existing HLS video, realtime statistics, card polling, or chart behavior.
