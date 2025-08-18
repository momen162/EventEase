@extends('admin.layout')
@section('title','Statistics')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"
        integrity="sha256-+i2m6w6s3pX8r0P9pQJwTNC3aSjcUjL/O0mH9M9m+eI=" crossorigin="anonymous"></script>
@endpush

@section('content')
<div class="grid">
  <div class="col-12">
    <div class="card">
      <h2>Event Statistics</h2>
      <p class="help">Overview of tickets created vs. sold for each event.</p>

      <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:10px">
        <div class="badge">Total Created: <strong style="margin-left:6px">{{ array_sum($created->toArray()) }}</strong></div>
        <div class="badge">Total Sold: <strong style="margin-left:6px">{{ array_sum($sold->toArray()) }}</strong></div>
        <div class="badge">Events: <strong style="margin-left:6px">{{ $events->count() }}</strong></div>
      </div>

      @if (!$events->count())
        <div class="empty" style="margin-top:16px">No events found.</div>
      @else
        <div style="margin-top:16px">
          <canvas id="barChart" height="120" aria-label="Tickets created vs sold per event" role="img"></canvas>
        </div>

        <div style="margin-top:24px; display:grid; grid-template-columns: 1fr 1fr; gap:18px">
          <div class="card">
            <h3 style="margin:0 0 8px">Top Selling (Pie)</h3>
            <p class="help">Distribution of sold tickets among top events.</p>
            <canvas id="pieChart" height="220" aria-label="Top selling events pie chart" role="img"></canvas>
          </div>

          <div class="card">
            <h3 style="margin:0 0 8px">Top Selling Events</h3>
            <div class="table-wrap" style="margin-top:8px">
              <table>
                <thead>
                  <tr><th>#</th><th>Event</th><th>Sold</th><th>Created</th><th>Buyers</th></tr>
                </thead>
                <tbody>
                  @foreach ($top as $i => $r)
                    <tr>
                      <td>{{ $i+1 }}</td>
                      <td>{{ $r->title }}</td>
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

    const labels  = @json($labels, JSON_UNESCAPED_UNICODE);
    const created = @json($created);
    const sold    = @json($sold);

    const short = (s) => (s && s.length > 22) ? s.slice(0, 21) + '…' : s;
    const barLabels = labels.map(short);

    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: barLabels,
        datasets: [
          { label: 'Created', data: created, borderWidth: 1 },
          { label: 'Sold',    data: sold,    borderWidth: 1 },
        ]
      },
      options: {
        responsive: true,
        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
        plugins: {
          legend: { position: 'top' },
          tooltip: {
            callbacks: { title(items){ return labels[items[0].dataIndex] || ''; } }
          }
        }
      }
    });

    const topData   = @json($top->pluck('tickets_sold')->map(fn($v)=>(int)$v));
    const topLabels = @json($top->pluck('title'), JSON_UNESCAPED_UNICODE);

    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
      type: 'pie',
      data: { labels: topLabels.map(short), datasets: [{ data: topData }] },
      options: { responsive: true }
    });
  })();
</script>
@endpush
@endsection
