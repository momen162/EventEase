<?php
require __DIR__ . '/_config.php';
require_admin();

$pageTitle = 'Sales by Event';

$status = $_GET['status'] ?? 'paid'; // default to paid totals
$valid  = ['paid','unpaid','cancelled','all'];
if (!in_array($status, $valid, true)) $status = 'paid';

$where  = '';
$params = [];

if ($status !== 'all') {
  $where = "WHERE t.payment_status = ?";
  $params[] = $status;
}

$sql = "
  SELECT
    e.id         AS event_id,
    e.title      AS event_title,
    e.starts_at  AS starts_at,
    e.location   AS location,
    COUNT(t.id)  AS tickets_count,
    COALESCE(SUM(t.quantity),0)      AS qty_sum,
    COALESCE(SUM(t.total_amount),0)  AS amount_sum
  FROM events e
  LEFT JOIN tickets t ON t.event_id = e.id
  $where
  GROUP BY e.id, e.title, e.starts_at, e.location
  ORDER BY e.starts_at DESC
";
$st = $pdo->prepare($sql);
$st->execute($params);
$rows = $st->fetchAll();

// Totals across listed rows (client-side)
$totals = ['events'=>0,'tickets'=>0,'qty'=>0,'amount'=>0.0];
foreach ($rows as $r) {
  $totals['events']++;
  $totals['tickets'] += (int)$r['tickets_count'];
  $totals['qty']     += (int)$r['qty_sum'];
  $totals['amount']  += (float)$r['amount_sum'];
}

include __DIR__ . '/_layout_top.php';
?>
<h2 style="margin:0 0 1rem;"><?= htmlspecialchars($pageTitle) ?></h2>

<style>
  /* ---- Scoped Admin Styles (sales-by-event UI) ---- */
  .se-container { display: grid; gap: 1rem; }
  .se-card {
    background:#fff; border:1px solid rgba(0,0,0,.06); border-radius:16px;
    box-shadow:0 10px 25px -18px rgba(0,0,0,.25);
  }
  .se-card-header { display:flex; align-items:center; justify-content:space-between; padding:.9rem 1rem; border-bottom:1px solid #eef2f7; }
  .se-card-body { padding: 1rem; }
  .se-title { margin:0; font-size:1rem; font-weight:700; letter-spacing:.2px; }

  /* Stat chips */
  .se-stats { display:grid; gap:.75rem; grid-template-columns: repeat(4, minmax(0,1fr)); }
  .se-stat { padding:1rem; border-radius:14px; background:#f9fafb; border:1px solid #eef2f7; }
  .se-stat .k { font-size:.8rem; color:#6b7280; }
  .se-stat .v { font-size:1.15rem; font-weight:800; margin-top:.2rem; font-variant-numeric: tabular-nums; }

  /* Status filter pills */
  .se-pills { display:flex; flex-wrap:wrap; gap:.5rem; }
  .se-pill {
    display:inline-flex; align-items:center; gap:.4rem; padding:.55rem .85rem; border-radius:999px; border:1px solid #e5e7eb;
    background:#fff; color:#111827; font-weight:700; text-decoration:none;
  }
  .se-pill.active { background: linear-gradient(135deg, #6366f1, #8b5cf6); color:#fff; border-color:transparent; }
  .se-pill .count { opacity:.9; font-weight:800; }

  /* Actions */
  .se-actions { display:flex; gap:.5rem; align-items:center; }
  .se-btn {
    appearance:none; border:none; border-radius:999px; padding:.7rem 1rem; font-weight:700; cursor:pointer;
    background: linear-gradient(135deg, #6366f1, #8b5cf6); color:#fff; box-shadow:0 8px 18px -12px rgba(99,102,241,.8);
    transition: filter .15s, transform .06s;
  }
  .se-btn:hover { filter:brightness(1.05); }
  .se-btn:active { transform:translateY(1px); }
  .se-btn-ghost { background:#fff; color:#111827; border:1px solid #e5e7eb; box-shadow:none; }
  .se-btn-ghost:hover { background:#f9fafb; }

  /* Table */
  .se-table-wrap { overflow:auto; border:1px solid #eef2f7; border-radius:14px; }
  table.se-table { width:100%; border-collapse: collapse; font-size:.95rem; }
  .se-table thead th {
    position: sticky; top: 0; z-index: 1;
    background:#f8fafc; color:#111827; text-align:left; font-weight:700; letter-spacing:.2px;
    border-bottom:1px solid #e5e7eb; padding:.75rem .75rem;
  }
  .se-table tbody td { border-bottom:1px solid #f1f5f9; padding:.75rem .75rem; vertical-align: top; }
  .se-table tbody tr:hover { background:#fafafa; }
  .se-num { text-align:right; font-variant-numeric: tabular-nums; }
  .se-loc { color:#6b7280; }

  /* Empty state */
  .se-empty { text-align:center; padding:2.25rem 1rem; color:#6b7280; }
  .se-empty h3 { margin:.25rem 0 .35rem; font-size:1.05rem; color:#111827; }
  .se-empty p { margin:0; }

  @media (max-width: 1024px) {
    .se-stats { grid-template-columns: repeat(2, minmax(0,1fr)); }
  }
</style>

<div class="se-container">

  <!-- Status Pills + Export -->
  <div class="se-card">
    <div class="se-card-header">
      <h3 class="se-title">View totals by status</h3>
      <div class="se-actions">
        <a class="se-btn" href="/admin/sales_export.php?<?= http_build_query(['group'=>'event','status'=>$status]) ?>">Export CSV</a>
      </div>
    </div>
    <div class="se-card-body">
      <div class="se-pills">
        <?php
          // Helper to render pill link
          $statuses = [
            'paid'      => 'Paid',
            'unpaid'    => 'Unpaid',
            'cancelled' => 'Cancelled',
            'all'       => 'All'
          ];
          foreach ($statuses as $key => $label):
            $active = $status === $key ? 'active' : '';
        ?>
          <a class="se-pill <?= $active ?>" href="?status=<?= urlencode($key) ?>">
            <?= htmlspecialchars($label) ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Stat Summary -->
  <div class="se-stats">
    <div class="se-stat">
      <div class="k">Events listed</div>
      <div class="v"><?= (int)$totals['events'] ?></div>
    </div>
    <div class="se-stat">
      <div class="k">Tickets (rows)</div>
      <div class="v"><?= (int)$totals['tickets'] ?></div>
    </div>
    <div class="se-stat">
      <div class="k">Total quantity</div>
      <div class="v"><?= (int)$totals['qty'] ?></div>
    </div>
    <div class="se-stat">
      <div class="k">Grand total</div>
      <div class="v"><?= number_format((float)$totals['amount'], 2) ?></div>
    </div>
  </div>

  <!-- Results -->
  <div class="se-card">
    <div class="se-card-header">
      <h3 class="se-title">Sales by Event — <?= htmlspecialchars(ucfirst($status)) ?></h3>
      <div style="color:#6b7280; font-size:.9rem;">
        <?= (int)$totals['events'] ?> event<?= $totals['events'] === 1 ? '' : 's' ?>
      </div>
    </div>

    <?php if (!$rows): ?>
      <div class="se-card-body se-empty">
        <h3>No events found</h3>
        <p>Try a different status.</p>
      </div>
    <?php else: ?>
      <div class="se-card-body se-table-wrap">
        <table class="se-table">
          <thead>
            <tr>
              <th>Event</th>
              <th>Starts</th>
              <th>Location</th>
              <th class="se-num">Tickets</th>
              <th class="se-num">Qty</th>
              <th class="se-num">Total Amount</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r): ?>
              <tr>
                <td>#<?= (int)$r['event_id'] ?> — <?= htmlspecialchars($r['event_title']) ?></td>
                <td><?= htmlspecialchars(date('M d, Y H:i', strtotime($r['starts_at']))) ?></td>
                <td class="se-loc"><?= htmlspecialchars($r['location'] ?? '—') ?></td>
                <td class="se-num"><?= (int)$r['tickets_count'] ?></td>
                <td class="se-num"><?= (int)$r['qty_sum'] ?></td>
                <td class="se-num"><?= number_format((float)$r['amount_sum'], 2) ?></td>
                <td>
                  <a class="se-btn se-btn-ghost" href="/admin/sales.php?event_id=<?= (int)$r['event_id'] ?>&status=<?= urlencode($status==='all'?'':$status) ?>">View Tickets</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" style="text-align:right;">Totals</th>
              <th class="se-num"><?= (int)$totals['tickets'] ?></th>
              <th class="se-num"><?= (int)$totals['qty'] ?></th>
              <th class="se-num"><?= number_format((float)$totals['amount'], 2) ?></th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>
    <?php endif; ?>
  </div>

</div>

<?php include __DIR__ . '/_layout_bottom.php'; ?>
