@extends('admin.layout')
@section('title','Statistics')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"
        integrity="sha256-+i2m6w6s3pX8r0P9pQJwTNC3aSjcUjL/O0mH9M9m+eI=" crossorigin="anonymous"></script>

<style>
  :root {
    --bg: #b1badeff;
    --bg-soft: #12162a;
    --card: #161a31;
    --muted: #131415ff;
    --text: #4372b4ff;
    --accent: #141e32ff;
    --accent-2: #03020cff;
    --ring: rgba(108,156,255,.35);
    --success: #4d5d59ff;
    --danger: #ff7a7a;
    --table-border: rgba(231,236,243,.06);
  }
  @media (prefers-color-scheme: light) {
    :root {
      --bg: #326bdcff;
      --bg-soft: #c4e2e2ff;
      --card: #575050ff;
      --muted: #5b6876;
      --text: #14171eff;
      --accent: #3b82f6;
      --accent-2: #4d455aff;
      --ring: rgba(59,130,246,.25);
      --success: #10b981;
      --danger: #ef4444;
      --table-border: rgba(13,19,32,.08);
    }
  }

  /* Page wrapper tweaks (works with your admin layout) */
  body { background: radial-gradient(1200px 600px at 10% -10%, rgba(108,156,255,.12), transparent 40%) ,
                      radial-gradient(900px 500px at 100% 10%, rgba(138,125,255,.10), transparent 45%),
                      var(--bg); }

  .grid {
    display: grid;
    gap: 18px;
  }

  .card {
    background: linear-gradient(160deg, var(--card), var(--bg-soft));
    border: 1px solid rgba(255,255,255,.06);
    border-radius: 16px;
    padding: 18px;
    color: var(--text);
    box-shadow: 0 6px 20px rgba(0,0,0,.25);
    position: relative;
    overflow: hidden;
  }
  .card::after{
    content:"";
    position:absolute; inset:auto -20% -60% auto;
    width:60%; height:120%;
    background: radial-gradient(300px 180px at right bottom, rgba(108,156,255,.12), transparent 40%);
    pointer-events:none;
  }

  h2 {
    margin: 0 0 6px;
    font-weight: 700;
    letter-spacing:.2px;
  }
  .help {
    color: var(--muted);
    margin: 6px 0 0;
    font-size: .95rem;
  }

  .badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 999px;
    font-size: .92rem;
    color: var(--text);
    background:
      linear-gradient(180deg, rgba(255,255,255,.08), rgba(255,255,255,.02)),
      linear-gradient(90deg, rgba(108,156,255,.20), rgba(138,125,255,.18));
    border: 1px solid rgba(255,255,255,.10);
    box-shadow: inset 0 0 0 1px rgba(255,255,255,.03), 0 4px 14px rgba(0,0,0,.18);
  }
  .badge strong { color: #fff; letter-spacing:.3px; }

  .empty {
    background: linear-gradient(160deg, var(--bg-soft), var(--card));
    border: 1px dashed var(--table-border);
    color: var(--muted);
    padding: 18px;
    border-radius: 14px;
    text-align: center;
  }

  /* 2-column area below charts */
  .two-col {
    display: grid;
    grid-template-columns: 1.2fr .8fr;
    gap: 18px;
  }
  @media (max-width: 1100px) {
    .two-col { grid-template-columns: 1fr; }
  }

  /* Table */
  .table-wrap { overflow: auto; border-radius: 12px; border: 1px solid var(--table-border); }
  table { width: 100%; border-collapse: separate; border-spacing: 0; }
  thead th {
    text-align: left; font-weight: 600; font-size: .9rem; color: var(--muted);
    background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,0));
    position: sticky; top: 0; z-index: 1;
    padding: 12px 14px; border-bottom: 1px solid var(--table-border);
  }
  tbody td {
    padding: 12px 14px; color: var(--text); border-bottom: 1px solid var(--table-border);
  }
  tbody tr:hover { background: rgba(108,156,255,.06); }

  /* Canvas ring & spacing */
  canvas { background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,0));
           border-radius: 14px; border: 1px solid rgba(255,255,255,.05); }
  .canvas-pad { padding: 8px; border-radius: 16px; background: radial-gradient(400px 180px at 20% -10%, rgba(108,156,255,.08), transparent 50%); }

  /* Small buttons/legend feel */
  .subcard {
    border-radius: 16px;
    padding: 16px;
    background: linear-gradient(160deg, var(--card), var(--bg-soft));
    border: 1px solid rgba(255,255,255,.06);
  }
</style>
@endpush

@section('content')
<div class="grid">
  <div class="col-12">
    <div class="card">
      <h2>Event Statistics</h2>
      <p class="help">Overview of tickets created vs. sold for each event.</p>

      <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:12px">
        <div class="badge">Total Created: <strong style="margin-left:4px">{{ array_sum($created->toArray()) }}</strong></div>
        <div class="badge">Total Sold: <strong style="margin-left:4px">{{ array_sum($sold->toArray()) }}</strong></div>
        <div class="badge">Events: <strong style="margin-left:4px">{{ $events->count() }}</strong></div>
      </div>

      @if (!$events->count())
        <div class="empty" style="margin-top:16px">No events found.</div>
      @else
        <div class="canvas-pad" style="margin-top:16px">
          <canvas id="barChart" height="120" aria-label="Tickets created vs sold per event" role="img"></canvas>
        </div>

        <div class="two-col" style="margin-top:20px">
          <div class="subcard">
            <h3 style="margin:0 0 8px">Top Selling (Pie)</h3>
            <p class="help">Distribution of sold tickets among top events.</p>
            <div class="canvas-pad" style="margin-top:10px">
              <canvas id="pieChart" height="220" aria-label="Top selling events pie chart" role="img"></canvas>
            </div>
          </div>

          <div class="subcard">
            <div style="display:flex; align-items:baseline; justify-content:space-between; gap:12px">
              <h3 style="margin:0">Top Selling Events</h3>
              <span class="help">Sorted by sold tickets</span>
            </div>
            <div class="table-wrap" style="margin-top:10px">
              <table>
                <thead>
                  <tr><th>#</th><th>Event</th><th>Sold</th><th>Created</th><th>Buyers</th></tr>
                </thead>
                <tbody>
                  @foreach ($top as $i => $r)
                    <tr>
                      <td>{{ $i+1 }}</td>
                      <td style="max-width:380px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap">{{ $r->title }}</td>
                      <td>{{ (int)$r->tickets_sold }}</td>
                      <td>{{ (int)$r->tickets_created }}</td>
                      <td>{{ (int)$r->unique_buyers }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

        </div>
      @endif
    </div>
  </div>
</div>

@push('scripts')
<script>
  (function () {
    const hasData = {{ (bool) $events->count() ? 'true': 'false' }};
    if (!hasData) return;

    // -------- Data (unchanged) --------
    const labels  = @json($labels, JSON_UNESCAPED_UNICODE);
    const created = @json($created);
    const sold    = @json($sold);

    const short = (s) => (s && s.length > 22) ? s.slice(0, 21) + '…' : s;
    const barLabels = labels.map(short);

    // -------- Visual helpers (styling-only) --------
    const withAlpha = (hex, a=0.3) => {
      const c = hex.replace('#','');
      const r = parseInt(c.substring(0,2),16);
      const g = parseInt(c.substring(2,4),16);
      const b = parseInt(c.substring(4,6),16);
      return `rgba(${r},${g},${b},${a})`;
    };

    // Light/Dark friendly palette
    const light = window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches;
    const cBlue  = light ? '#3b82f6' : '#6c9cff';
    const cVio   = light ? '#7c3aed' : '#8a7dff';
    const cGreen = light ? '#10b981' : '#3dd9b2';
    const cRed   = light ? '#ef4444' : '#ff7a7a';

    const mkBarGradient = (ctx, hex) => {
      const g = ctx.createLinearGradient(0, 0, 0, 220);
      g.addColorStop(0, withAlpha(hex, .55));
      g.addColorStop(1, withAlpha(hex, .12));
      return g;
    };

    // -------- Bar Chart --------
    const barCtx = document.getElementById('barChart').getContext('2d');
    const createdGrad = mkBarGradient(barCtx, cBlue);
    const soldGrad    = mkBarGradient(barCtx, cGreen);

    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: barLabels,
        datasets: [
          {
            label: 'Created',
            data: created,
            backgroundColor: createdGrad,
            borderColor: cBlue,
            borderWidth: 1.5,
            borderRadius: 8,
            maxBarThickness: 46
          },
          {
            label: 'Sold',
            data: sold,
            backgroundColor: soldGrad,
            borderColor: cGreen,
            borderWidth: 1.5,
            borderRadius: 8,
            maxBarThickness: 46
          },
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            grid: { display: false },
            ticks: { color: getCss('--muted'), maxRotation: 0, minRotation: 0 }
          },
          y: {
            beginAtZero: true,
            ticks: { precision: 0, color: getCss('--muted') },
            grid: { color: withAlpha('#9aa4b2', .12) }
          }
        },
        plugins: {
          legend: {
            position: 'top',
            labels: { color: getCss('--text'), usePointStyle: true, pointStyle: 'round' }
          },
          tooltip: {
            backgroundColor: '#111827',
            titleColor: '#e5e7eb',
            bodyColor: '#e5e7eb',
            borderColor: withAlpha('#6c9cff', .35),
            borderWidth: 1,
            padding: 10,
            callbacks: { title(items){ return labels[items[0].dataIndex] || ''; } }
          }
        },
        animation: { duration: 600, easing: 'easeOutQuart' }
      }
    });

    // -------- Pie Chart (Top Selling) --------
    const topData   = @json($top->pluck('tickets_sold')->map(fn($v)=>(int)$v));
    const topLabels = @json($top->pluck('title'), JSON_UNESCAPED_UNICODE);
    const pieCtx = document.getElementById('pieChart').getContext('2d');

    const pieColors = [
      cBlue, cVio, cGreen, cRed, '#f59e0b', '#14b8a6', '#a855f7', '#60a5fa', '#f43f5e', '#22c55e'
    ];
    const bgColors = pieColors.map(hex => withAlpha(hex, .65));
    const borderColors = pieColors;

    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: topLabels.map(short),
        datasets: [{
          data: topData,
          backgroundColor: bgColors,
          borderColor: borderColors,
          borderWidth: 1.5
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { color: getCss('--text'), boxWidth: 12, boxHeight: 12, usePointStyle: true, pointStyle: 'circle' }
          },
          tooltip: {
            backgroundColor: '#111827',
            titleColor: '#e5e7eb',
            bodyColor: '#e5e7eb',
            borderColor: withAlpha('#8a7dff', .35),
            borderWidth: 1,
            padding: 10
          }
        },
        animation: { animateScale: true, duration: 700, easing: 'easeOutQuint' }
      }
    });

    function getCss(varName) {
      return getComputedStyle(document.documentElement).getPropertyValue(varName).trim() || '#e7ecf3';
    }
  })();
</script>
@endpush
@endsection
