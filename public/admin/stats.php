<?php
require __DIR__.'/_config.php';  // PDO + admin session helpers
require_admin();                 // 🔒 only logged-in admins can view

// Aggregate per-event stats
$sql = "
  SELECT
    e.id,
    e.title,
    COALESCE(SUM(t.quantity), 0) AS tickets_created,
    COALESCE(SUM(CASE WHEN t.payment_status='paid' THEN t.quantity ELSE 0 END), 0) AS tickets_sold,
    COALESCE(COUNT(DISTINCT CASE WHEN t.payment_status='paid' THEN t.user_id END), 0) AS unique_buyers
  FROM events e
  LEFT JOIN tickets t ON t.event_id = e.id
  GROUP BY e.id, e.title
  ORDER BY e.starts_at DESC
";
$events = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Build arrays for charts
$labels  = [];
$created = [];
$sold    = [];
foreach ($events as $row) {
  $labels[]  = $row['title'];
  $created[] = (int)$row['tickets_created'];
  $sold[]    = (int)$row['tickets_sold'];
}

// Top selling (by tickets_sold)
$top = $events;
usort($top, function($a,$b){ return ($b['tickets_sold'] <=> $a['tickets_sold']); });
$top = array_slice($top, 0, 10);

// Totals (nice to show at a glance)
$totalCreated = array_sum($created);
$totalSold    = array_sum($sold);

$pageTitle = 'Statistics';
require __DIR__.'/_layout_top.php';
?>

<div class="grid">
  <div class="col-12">
    <div class="card">
      <h2>Event Statistics</h2>
      <p class="help">Overview of tickets created vs. sold for each event.</p>

      <!-- Summary chips -->
      <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:10px">
        <div class="badge">Total Created: <strong style="margin-left:6px"><?= (int)$totalCreated ?></strong></div>
        <div class="badge">Total Sold: <strong style="margin-left:6px"><?= (int)$totalSold ?></strong></div>
        <div class="badge">Events: <strong style="margin-left:6px"><?= count($events) ?></strong></div>
      </div>

      <?php if (!$events): ?>
        <div class="empty" style="margin-top:16px">No events found.</div>
      <?php else: ?>
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
                  <tr>
                    <th>#</th>
                    <th>Event</th>
                    <th>Sold</th>
                    <th>Created</th>
                    <th>Buyers</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($top as $i => $r): ?>
                    <tr>
                      <td><?= $i+1 ?></td>
                      <td><?= htmlspecialchars($r['title']) ?></td>
                      <td><?= (int)$r['tickets_sold'] ?></td>
                      <td><?= (int)$r['tickets_created'] ?></td>
                      <td><?= (int)$r['unique_buyers'] ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Chart.js (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"
        integrity="sha256-+i2m6w6s3pX8r0P9pQJwTNC3aSjcUjL/O0mH9M9m+eI="
        crossorigin="anonymous"></script>

<script>
  (function () {
    // If there are no events, don't try to draw charts
    const hasData = <?= json_encode((bool) count($events)) ?>;
    if (!hasData) return;

    const labels  = <?= json_encode($labels, JSON_UNESCAPED_UNICODE) ?>;
    const created = <?= json_encode($created) ?>;
    const sold    = <?= json_encode($sold) ?>;

    // Shorten long labels for readability on the bar chart
    const short = (s) => (s && s.length > 22) ? s.slice(0, 21) + '…' : s;
    const barLabels = labels.map(short);

    // BAR: Tickets Created vs Sold per Event
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
        scales: {
          y: { beginAtZero: true, ticks: { precision: 0 } }
        },
        plugins: {
          legend: { position: 'top' },
          tooltip: {
            callbacks: {
              // Show full event title in tooltip
              title(items){ return labels[items[0].dataIndex] || ''; }
            }
          }
        }
      }
    });

    // PIE: Top selling distribution
    const topData   = <?= json_encode(array_map(fn($r)=> (int)$r['tickets_sold'], $top)) ?>;
    const topLabels = <?= json_encode(array_map(fn($r)=> $r['title'], $top), JSON_UNESCAPED_UNICODE) ?>;

    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: topLabels.map(short),
        datasets: [{ data: topData }]
      },
      options: { responsive: true }
    });
  })();
</script>

<?php require __DIR__.'/_layout_bottom.php'; ?>
