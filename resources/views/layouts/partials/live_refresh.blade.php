{{--
    ╔══════════════════════════════════════════════════════════════╗
    ║  PARTIAL: Live Dashboard Refresh Widget                      ║
    ║  Include this at the bottom of every role dashboard view.    ║
    ║                                                              ║
    ║  Usage:                                                      ║
    ║    @include('layouts.partials.live_refresh', [               ║
    ║        'statsUrl'    => route('admin.stats'),                ║
    ║        'intervalSec' => 30,   // optional, default 30        ║
    ║        'statMap'     => [     // optional DOM id → key       ║
    ║            'stat-trainees' => 'trainees',                    ║
    ║        ],                                                     ║
    ║    ])                                                         ║
    ╚══════════════════════════════════════════════════════════════╝
--}}
@php
    $intervalSec = $intervalSec ?? 30;
    $statMap     = $statMap ?? [];
@endphp

{{-- ── Toast notification container ─────────────────────────────── --}}
<div id="live-toast-container"
     style="position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:8px;pointer-events:none;">
</div>

{{-- ── Refresh indicator badge ────────────────────────────────────── --}}
<div id="live-refresh-badge"
     title="Live refresh aktif — data diperbarui otomatis setiap {{ $intervalSec }} detik"
     style="
        position:fixed;bottom:24px;left:80px;z-index:9990;
        display:none;align-items:center;gap:6px;
        background:rgba(15,23,42,.85);backdrop-filter:blur(8px);
        border:1px solid rgba(255,255,255,.08);border-radius:999px;
        padding:5px 12px;cursor:default;user-select:none;
        font-size:10px;font-weight:700;color:#94a3b8;
        transition:opacity .3s;
     ">
    <span id="live-pulse"
          style="width:7px;height:7px;border-radius:50%;background:#22c55e;
                 animation:livePulse 1.8s ease-in-out infinite;flex-shrink:0;"></span>
    LIVE &nbsp;·&nbsp; <span id="live-last-ts">--:--</span>
</div>

<style>
@keyframes livePulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:.4; transform:scale(1.35); }
}
.live-toast {
    min-width: 220px; max-width: 320px;
    background: rgba(15,23,42,.92); backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.08); border-radius: 12px;
    padding: 10px 14px;
    font-size: 11px; font-weight: 600; color: #e2e8f0;
    display: flex; align-items: center; gap: 8px;
    pointer-events: auto;
    animation: toastIn .3s ease forwards;
    box-shadow: 0 8px 24px rgba(0,0,0,.35);
}
.live-toast.hide { animation: toastOut .3s ease forwards; }
@keyframes toastIn  { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
@keyframes toastOut { from { opacity:1; transform:translateY(0); } to { opacity:0; transform:translateY(12px); } }
</style>

<script>
(function () {
    const STATS_URL  = @json($statsUrl);
    const INTERVAL   = {{ $intervalSec }} * 1000;
    const STAT_MAP   = @json($statMap);
    let   prevData   = null;

    /** Show a toast message */
    function showToast(icon, msg, color) {
        const container = document.getElementById('live-toast-container');
        if (!container) return;
        const t = document.createElement('div');
        t.className = 'live-toast';
        t.innerHTML = `<span style="font-size:15px;">${icon}</span><span style="color:${color||'#e2e8f0'}">${msg}</span>`;
        container.appendChild(t);
        setTimeout(() => {
            t.classList.add('hide');
            setTimeout(() => t.remove(), 350);
        }, 3500);
    }

    /** Update a DOM element's text if it changed */
    function updateEl(id, newVal) {
        const el = document.getElementById(id);
        if (!el) return false;
        const old = el.textContent.trim();
        if (String(newVal) !== old) {
            el.textContent = newVal;
            el.style.transition = 'background .4s,color .4s';
            el.style.background = 'rgba(34,197,94,.18)';
            el.style.borderRadius = '4px';
            el.style.color = '#4ade80';
            setTimeout(() => { el.style.background = ''; el.style.color = ''; }, 1500);
            return true;
        }
        return false;
    }

    /** Compare two stats objects and fire toasts for changed keys */
    function detectChanges(prev, next) {
        const labels = {
            trainees:'Peserta', lulus:'Lulus', pending:'Pembayaran Pending',
            asesis:'Asesi', asesors:'Asesor', programs:'Program', articles:'Artikel',
            chats:'Sesi Chat', schemes:'Skema', published:'Dipublikasikan',
            schedules:'Jadwal', attempts:'Percobaan Ujian', completed:'Ujian Selesai',
            enrollments:'Pendaftaran', users:'Pengguna',
        };
        let changed = false;
        for (const [key, label] of Object.entries(labels)) {
            if (prev[key] !== undefined && next[key] !== undefined && prev[key] !== next[key]) {
                const delta = next[key] - prev[key];
                const icon  = delta > 0 ? '🔔' : '📉';
                const color = delta > 0 ? '#4ade80' : '#f87171';
                showToast(icon, `${label}: ${prev[key]} → ${next[key]}`, color);
                changed = true;
            }
        }
        return changed;
    }

    async function fetchStats() {
        try {
            const resp = await fetch(STATS_URL, {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            });
            if (!resp.ok) return;
            const data = await resp.json();

            // Update mapped DOM elements
            for (const [domId, key] of Object.entries(STAT_MAP)) {
                if (data[key] !== undefined) updateEl(domId, data[key]);
            }

            // Detect & announce changes
            if (prevData) detectChanges(prevData, data);
            prevData = data;

            // Update last-updated badge
            const ts = document.getElementById('live-last-ts');
            if (ts && data.ts) {
                const d = new Date(data.ts);
                ts.textContent = d.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit', second:'2-digit' });
            }
        } catch (e) {
            // Silently ignore network errors
        }
    }

    // Initial fetch then poll
    document.addEventListener('DOMContentLoaded', () => {
        fetchStats();
        setInterval(fetchStats, INTERVAL);
    });
})();
</script>
