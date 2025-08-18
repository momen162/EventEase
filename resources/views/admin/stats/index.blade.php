@extends('admin.layout')
@section('title','Statistics')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"
        integrity="sha256-+i2m6w6s3pX8r0P9pQJwTNC3aSjcUjL/O0mH9M9m+eI=" crossorigin="anonymous"></script>
@endpush

@section('content')
<div class="admin-stats"><!-- SCOPE WRAPPER -->
  <style>
    /* Page-scoped tokens */
    .admin-stats{
      --bg:#ffffff;
      --surface:#ffffff;
      --surface-2:#f9fafb;
      --text:#111827;
      --muted:#6b7280;
      --border:#e5e7eb;
      --ring: rgba(37,99,235,.35);

      --primary:#2563eb;      /* blue-600 */
      --primary-600:#1d4ed8;  /* blue-700 */
      --green:#22c55e;        /* green-500 */
      --green-200:#bbf7d0;    /* green-200 */
      --blue:#3b82f6;         /* blue-500 */
      --blue-200:#bfdbfe;     /* blue-200 */
      --amber:#f59e0b;        /* amber-500 */
      --purple:#8b5cf6;       /* violet-500 */
      --rose:#f43f5e;         /* rose-500 */
      --cyan:#06b6d4;         /* cyan-500 */

      --radius:14px;
      --shadow:0 10px 30px rgba(0,0,0,.06);
      --shadow-sm:0 2px 10px rgba(0,0,0,.05);
    }

    .admin-stats .as-wrap{ padding: clamp(12px,1.8vw,20px); background:var(--bg); color:var(--text); }

    /* Page head */
    .admin-stats .as-head{ margin-bottom: 10px; }
    .admin-stats .as-title{ margin:0; font-weight:800; letter-spacing:.2px; }
    .admin-stats .as-help{ margin:.25rem 0 0; color:var(--muted); }

    /* Card */
    .admin-stats .as-card{
      background:var(--surface); border:1px solid var(--border); border-radius:var(--radius);
      box-shadow:var(--shadow); padding: clamp(16px,2vw,22px);
    }
    .admin-stats .as-card + .as-card{ margin-top: 16px; }

    /* Badges row */
    .admin-stats .as-badges{ display:flex; gap:12px; flex-wrap:wrap; margin-top:10px; }
    .admin-stats .as-badge{
      display:inline-flex; align-items:center; gap:6px; padding:8px 12px; border-radius:999px;
      background:#eef2ff; color:#3730a3; border:1px solid #e0e7ff; font-weight:700;
      box-shadow:var(--shadow-sm);
    }

    /* Pills + actions */
    .admin-stats .as-header{
      display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;
      margin-top: 6px;
    }
    .admin-stats .as-actions{ display:flex; gap:8px; flex-wrap:wrap; }
    .admin-stats .as-btn{
      appearance:none; border:1px solid var(--border); border-radius:999px;
      padding:10px 14px; font-weight:700; text-decoration:none; cursor:pointer;
      display:inline-flex; align-items:center; gap:.5rem; transition:.18s ease;
      background:#fff; color:var(--text); box-shadow:var(--shadow-sm);
    }
    .admin-stats .as-btn:hover{ transform: translateY(-1px); box-shadow:var(--shadow); }
    .admin-stats .as-btn:focus-visible{ outline:3px solid var(--ring); outline-offset:2px; }
    .admin-stats .as-btn-primary{ background:var(--primary); color:#fff; border-color:transparent; }
    .admin-stats .as-btn-primary:hover{ background:var(--primary-600); }

    .admin-stats .as-pills{ display:flex; gap:.5rem; flex-wrap:wrap; }
    .admin-stats .as-pill{
      text-decoration:none; padding:.55rem .85rem; border-radius:999px;
      border:1px solid var(--border); background:#fff; color:var(--text); font-weight:700;
      transition:.15s ease;
    }
    .admin-stats .as-pill:hover{ transform:translateY(-1px); box-shadow:var(--shadow-sm); }
    .admin-stats .as-pill.active{ background:#e0ecff; border-color:#c7d2fe; color:#1d4ed8; }

    /* Grid for charts + table */
    .admin-stats .as-grid{ display:grid; grid-template-columns: 1fr 1fr; gap:18px; margin-top: 18px; }
    @media (max-width: 1000px){ .admin-stats .as-grid{ grid-template-columns: 1fr; } }

    /* Table */
    .admin-stats .as-table-wrap{
      margin-top:8px; border:1px solid var(--border); border-radius:12px; overflow:hidden;
      background:var(--surface); box-shadow:var(--shadow);
    }
    .admin-stats .as-table{ width:100%; border-collapse: separate; border-spacing:0; font-size:.96rem; }
    .admin-stats .as-table thead th{
      text-align:left; padding:12px 14px; background:#fff; border-bottom:1px solid var(--border);
      color:var(--muted); font-weight:800;
    }
    .admin-stats .as-table tbody td{
      padding:12px 14px; border-bottom:1px solid var(--border); vertical-align: top;
    }
    .admin-stats .as-table tbody tr:nth-child(even){ background:var(--surface-2); }
    .admin-stats .as-table tbody tr:hover{ background:#fff; }
    .admin-stats .num{ text-align:right; font-variant-numeric: tabular-nums; font-feature-settings: "tnum" 1; }

    /* Empty */
    .admin-stats .as-empty{
      border:1px dashed var(--border); border-radius:12px; background:var(--surface-2);
      padding:22px; color:var(--muted); text-align:center; box-shadow:var(--shadow-sm);
      margin-top:16px;
    }
  </style>

  <div class="as-wrap">
    <div class="as-card">
      <div class="as-head">
        <h2 class="as-title">Event Statistics</h2>
        <p class="as-help">Overview of tickets created vs. sold for each event.</p>
      </div>

      <div class="as-badges">
        <span class="as-badge">Total Created: <strong>{{ array_sum($created->toArray()) }}</strong></span>
        <span class="as-badge">Total Sold: <strong>{{ array_sum($sold->toArray()) }}</strong></span>
        <span class="as-badge">Events: <strong>{{ $events->count() }}</strong></span>
      </div>

      @if (!$events->count())
        <div class="as-empty">No events found.</div>
      @else
        <div class="as-header">
          <h3 class="as-title" style="margin:0;">Tickets Created vs. Sold</h3>
          <div class="as-actions">
            <a class="as-btn as-btn-primary" href="{{ route('admin.sales.export', ['group'=>'event','status'=>request('status','paid')]) }}">Export CSV</a>
          </div>
        </div>

        <div style="margin-top:12px">
          <canvas id="barChart" height="120" aria-label="Tickets created vs sold per event" role="img"></canvas>
        </div>

        <div class="as-grid">
          <div class="as-card">
            <h3 style="margin:0 0 6px">Top Selling (Pie)</h3>
            <p class="as-help">Distribution of sold tickets among top events.</p>
            <canvas id="pieChart" height="220" aria-label="Top selling events pie chart" role="img"></canvas>
          </div>

          <div class="as-card">
            <h3 style="margin:0 0 6px">Top Selling Events</h3>
            <div class="as-table-wrap">
              <table class="as-table">
                <thead>
                  <tr><th>#</th><th>Event</th><th class="num">Sold</th><th class="num">Created</th><th class="num">Buyers</th></tr>
                </thead>
                <tbody>
                  @foreach ($top as $i => $r)
                    <tr>
                      <td data-label="#" class="num">{{ $i+1 }}</td>
                      <td data-label="Event"><strong>{{ $r->title }}</strong></td>
                      <td data-label="Sold" class="num">{{ (int)$r->tickets_sold }}</td>
                      <td data-label="Created" class="num">{{ (int)$r->tickets_created }}</td>
                      <td data-label="Buyers" class="num">{{ (int)$r->unique_buyers }}</td>
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
    if (!hasData || !window.Chart) return;

    // Palette (mirrors scoped CSS tokens)
    const COLORS = {
      blue:    getVar('--blue',    '#3b82f6'),
      blue200: getVar('--blue-200','#bfdbfe'),
      green:   getVar('--green',   '#22c55e'),
      green200:getVar('--green-200','#bbf7d0'),
      amber:   getVar('--amber',   '#f59e0b'),
      purple:  getVar('--purple',  '#8b5cf6'),
      rose:    getVar('--rose',    '#f43f5e'),
      cyan:    getVar('--cyan',    '#06b6d4'),
      border:  getVar('--border',  '#e5e7eb'),
      text:    getVar('--text',    '#111827')
    };

    function getVar(name, fallback){ 
      return getComputedStyle(document.querySelector('.admin-stats')).getPropertyValue(name).trim() || fallback; 
    }

    const labels  = @json($labels, JSON_UNESCAPED_UNICODE);
    const created = @json($created);
    const sold    = @json($sold);

    const short = (s) => (s && s.length > 22) ? s.slice(0, 21) + '…' : s;
    const barLabels = labels.map(short);

    // BAR CHART
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: barLabels,
        datasets: [
          { label: 'Created',
            data: created,
            backgroundColor: COLORS.blue200,
            borderColor: COLORS.blue,
            borderWidth: 1.5,
            borderRadius: 6,
            maxBarThickness: 42
          },
          { label: 'Sold',
            data: sold,
            backgroundColor: COLORS.green200,
            borderColor: COLORS.green,
            borderWidth: 1.5,
            borderRadius: 6,
            maxBarThickness: 42
          },
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        aspectRatio: 2.2,
        scales: {
          x: {
            grid: { display:false, borderColor: COLORS.border },
            ticks: { color: COLORS.text }
          },
          y: {
            beginAtZero: true,
            ticks: { precision: 0, color: COLORS.text },
            grid: { color: COLORS.border, borderColor: COLORS.border }
          }
        },
        plugins: {
          legend: { position: 'top', labels: { color: COLORS.text } },
          tooltip: {
            callbacks: { title(items){ return labels[items[0].dataIndex] || ''; } }
          }
        }
      }
    });

    // PIE CHART
    const topData   = @json($top->pluck('tickets_sold')->map(fn($v)=>(int)$v));
    const topLabels = @json($top->pluck('title'), JSON_UNESCAPED_UNICODE);

    const pieCtx = document.getElementById('pieChart').getContext('2d');
    const pieColors = [
      COLORS.blue, COLORS.green, COLORS.amber, COLORS.purple, COLORS.rose, COLORS.cyan
    ];

    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: topLabels.map(short),
        datasets: [{ data: topData, backgroundColor: pieColors, borderColor: '#ffffff', borderWidth: 2 }]
      },
      options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { color: COLORS.text } } }
      }
    });
  })();
</script>
@endpush
@endsection
