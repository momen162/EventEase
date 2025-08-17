<?php
require __DIR__ . '/_config.php';
require_admin();

$pageTitle = 'Sales (Tickets)';

$status = $_GET['status'] ?? '';             // '', 'paid', 'unpaid', 'cancelled'
$option = $_GET['payment_option'] ?? '';     // '', 'pay_now', 'pay_later'
$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
$q      = trim($_GET['q'] ?? '');            // search by ticket_code, buyer name/email
$from   = $_GET['from'] ?? '';               // YYYY-MM-DD
$to     = $_GET['to'] ?? '';                 // YYYY-MM-DD
$limit  = max(10, min((int)($_GET['limit'] ?? 200), 2000)); // default 200, cap 2000

$where  = [];
$params = [];

if ($status !== '' && in_array($status, ['unpaid','paid','cancelled'], true)) {
  $where[] = "t.payment_status = ?";
  $params[] = $status;
}

if ($option !== '' && in_array($option, ['pay_now','pay_later'], true)) {
  $where[] = "t.payment_option = ?";
  $params[] = $option;
}

if ($eventId > 0) {
  $where[] = "t.event_id = ?";
  $params[] = $eventId;
}

if ($q !== '') {
  $where[] = "(t.ticket_code LIKE ? OR u.name LIKE ? OR u.email LIKE ?)";
  $like = '%'.$q.'%';
  array_push($params, $like, $like, $like);
}

if ($from !== '') {
  $where[] = "DATE(t.created_at) >= ?";
  $params[] = $from;
}
if ($to !== '') {
  $where[] = "DATE(t.created_at) <= ?";
  $params[] = $to;
}

$whereSql = $where ? ('WHERE '.implode(' AND ', $where)) : '';

// Fetch rows
$sql = "
  SELECT
    t.id, t.ticket_code, t.quantity, t.total_amount, t.payment_option, t.payment_status, t.created_at,
    e.id AS event_id, e.title AS event_title,
    u.id AS user_id, u.name AS buyer_name, u.email AS buyer_email, u.phone AS buyer_phone
  FROM tickets t
  JOIN users  u ON u.id = t.user_id
  JOIN events e ON e.id = t.event_id
  $whereSql
  ORDER BY t.created_at DESC
  LIMIT $limit
";
$st = $pdo->prepare($sql);
$st->execute($params);
$rows = $st->fetchAll();

// Totals (for filtered set) — needs the same joins because $whereSql may reference u.name/email
$sqlSum = "
  SELECT
    COUNT(*) AS tickets_count,
    SUM(t.quantity) AS qty_sum,
    SUM(t.total_amount) AS amount_sum,
    SUM(CASE WHEN t.payment_status = 'paid' THEN t.total_amount ELSE 0 END) AS amount_paid
  FROM tickets t
  JOIN users  u ON u.id = t.user_id
  JOIN events e ON e.id = t.event_id
  $whereSql
";
$st2 = $pdo->prepare($sqlSum);
$st2->execute($params);
$tot = $st2->fetch() ?: ['tickets_count'=>0,'qty_sum'=>0,'amount_sum'=>0,'amount_paid'=>0];

// Events list for filter dropdown
$ev = $pdo->query("SELECT id, title FROM events ORDER BY starts_at DESC")->fetchAll();

include __DIR__ . '/_layout_top.php';
?>
<h2 style="margin:0 0 1rem;"><?= htmlspecialchars($pageTitle) ?></h2>

<style>
  /* ---- Scoped Admin Styles (sales UI) ---- */
  .sa-container { display: grid; gap: 1rem; }
  .sa-card {
    background: #fff;
    border: 1px solid rgba(0,0,0,.06);
    border-radius: 16px;
    box-shadow: 0 10px 25px -18px rgba(0,0,0,.25);
  }
  .sa-card-body { padding: 1rem; }
  .sa-card-header {
    display:flex; align-items:center; justify-content:space-between;
    padding: .9rem 1rem; border-bottom:1px solid #eef2f7;
  }
  .sa-title { margin:0; font-size:1rem; font-weight:700; letter-spacing:.2px; }

  /* Stat cards */
  .sa-stats { display:grid; gap:.75rem; grid-template-columns: repeat(4, minmax(0,1fr)); }
  .sa-stat { padding:1rem; border-radius:14px; background:#f9fafb; border:1px solid #eef2f7; }
  .sa-stat .k { font-size:.8rem; color:#6b7280; }
  .sa-stat .v { font-size:1.15rem; font-weight:800; margin-top:.2rem; font-variant-numeric: tabular-nums; }

  /* Filter form */
  .sa-filter .grid {
    display:grid; gap:.75rem; grid-template-columns: repeat(6, minmax(0,1fr)); align-items:end;
  }
  .sa-filter label { display:block; font-weight:600; margin-bottom:.35rem; font-size:.9rem; color:#374151; }
  .sa-input, .sa-select {
    width:100%; border:1px solid #e5e7eb; border-radius:12px; padding:.65rem .75rem; background:#fff;
    transition: border-color .15s, box-shadow .15s; outline:none;
  }
  .sa-input:focus, .sa-select:focus { border-color:#6366f1; box-shadow:0 0 0 4px rgba(99,102,241,.15); }
  .sa-actions { display:flex; flex-wrap:wrap; gap:.5rem; }
  .sa-right { justify-self:end; }

  /* Buttons */
  .sa-btn {
    appearance:none; border:none; border-radius:999px; padding:.7rem 1rem; font-weight:700; cursor:pointer;
    background: linear-gradient(135deg, #6366f1, #8b5cf6); color:#fff; box-shadow:0 8px 18px -12px rgba(99,102,241,.8);
    transition: filter .15s, transform .06s;
  }
  .sa-btn:hover { filter:brightness(1.05); }
  .sa-btn:active { transform:translateY(1px); }
  .sa-btn-ghost {
    background:#fff; color:#111827; border:1px solid #e5e7eb; box-shadow:none;
  }
  .sa-btn-ghost:hover { background:#f9fafb; }

  /* Table */
  .sa-table-wrap { overflow:auto; border:1px solid #eef2f7; border-radius:14px; }
  table.sa-table { width:100%; border-collapse: collapse; font-size:.95rem; }
  .sa-table thead th {
    position: sticky; top: 0; z-index: 1;
    background:#f8fafc; color:#111827; text-align:left; font-weight:700; letter-spacing:.2px;
    border-bottom:1px solid #e5e7eb; padding:.75rem .75rem;
  }
  .sa-table tbody td { border-bottom:1px solid #f1f5f9; padding:.75rem .75rem; vertical-align: top; }
  .sa-table tbody tr:hover { background:#fafafa; }
  .sa-num { text-align:right; font-variant-numeric: tabular-nums; }

  /* Badges */
  .sa-badge { display:inline-flex; align-items:center; gap:.35rem; padding:.35rem .55rem; font-size:.8rem; font-weight:800;
    border-radius:999px; border:1px solid transparent; text-transform:capitalize; white-space:nowrap;
  }
  .sa-badge.pay_now { background:#ecfeff; color:#0e7490; border-color:#a5f3fc; }
  .sa-badge.pay_later { background:#fef9c3; color:#854d0e; border-color:#fde68a; text-transform:none; }
  .sa-badge.status-paid { background:#ecfdf5; color:#065f46; border-color:#a7f3d0; }
  .sa-badge.status-unpaid { background:#fff7ed; color:#9a3412; border-color:#fed7aa; }
  .sa-badge.status-cancelled { background:#fee2e2; color:#991b1b; border-color:#fecaca; }

  /* Empty state */
  .sa-empty {
    text-align:center; padding:2.25rem 1rem; color:#6b7280;
  }
  .sa-empty h3 { margin:.25rem 0 .35rem; font-size:1.05rem; color:#111827; }
  .sa-empty p { margin:0; }

  @media (max-width: 1024px) {
    .sa-stats { grid-template-columns: repeat(2, minmax(0,1fr)); }
    .sa-filter .grid { grid-template-columns: repeat(2, minmax(0,1fr)); }
  }
</style>

<div class="sa-container">

  <!-- Stat Summary -->
  <div class="sa-stats">
    <div class="sa-stat">
      <div class="k">Total rows</div>
      <div class="v"><?= (int)$tot['tickets_count'] ?></div>
    </div>
    <div class="sa-stat">
      <div class="k">Total quantity</div>
      <div class="v"><?= (int)$tot['qty_sum'] ?></div>
    </div>
    <div class="sa-stat">
      <div class="k">Gross amount</div>
      <div class="v"><?= number_format((float)$tot['amount_sum'], 2) ?></div>
    </div>
    <div class="sa-stat">
      <div class="k">Paid amount</div>
      <div class="v"><?= number_format((float)$tot['amount_paid'], 2) ?></div>
    </div>
  </div>

  <!-- Filters -->
  <div class="sa-card sa-filter">
    <div class="sa-card-header">
      <h3 class="sa-title">Filters</h3>
      <div class="sa-actions">
        <a href="/admin/sales_export.php?<?= http_build_query($_GET) ?>" class="sa-btn">Export CSV</a>
      </div>
    </div>
    <div class="sa-card-body">
      <form method="GET" class="grid">
        <div>
          <label>Status</label>
          <select name="status" class="sa-select">
            <option value="">All</option>
            <?php foreach (['unpaid','paid','cancelled'] as $s): ?>
              <option value="<?= $s ?>" <?= $status===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label>Payment Option</label>
          <select name="payment_option" class="sa-select">
            <option value="">All</option>
            <?php foreach (['pay_now','pay_later'] as $op): ?>
              <option value="<?= $op ?>" <?= $option===$op?'selected':'' ?>><?= str_replace('_',' ',$op) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label>Event</label>
          <select name="event_id" class="sa-select">
            <option value="0">All events</option>
            <?php foreach ($ev as $e): ?>
              <option value="<?= (int)$e['id'] ?>" <?= $eventId===(int)$e['id']?'selected':'' ?>>
                #<?= (int)$e['id'] ?> — <?= htmlspecialchars($e['title']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label>Search</label>
          <input type="text" name="q" class="sa-input" value="<?= htmlspecialchars($q) ?>" placeholder="Ticket code, name, email">
        </div>

        <div>
          <label>From</label>
          <input type="date" name="from" class="sa-input" value="<?= htmlspecialchars($from) ?>">
        </div>

        <div>
          <label>To</label>
          <input type="date" name="to" class="sa-input" value="<?= htmlspecialchars($to) ?>">
        </div>

        <div>
          <label>Limit</label>
          <input type="number" name="limit" class="sa-input" min="10" max="2000" value="<?= (int)$limit ?>">
        </div>

        <div style="grid-column: span 2;">
          <div class="sa-actions">
            <button type="submit" class="sa-btn">Apply Filters</button>
            <a href="/admin/sales.php" class="sa-btn sa-btn-ghost">Reset</a>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Results -->
  <div class="sa-card">
    <div class="sa-card-header">
      <h3 class="sa-title">Results</h3>
      <div style="color:#6b7280; font-size:.9rem;">
        <?= (int)$tot['tickets_count'] ?> matching row<?= ((int)$tot['tickets_count'] === 1 ? '' : 's') ?>
      </div>
    </div>

    <?php if (!$rows): ?>
      <div class="sa-card-body sa-empty">
        <h3>No tickets found</h3>
        <p>Try adjusting your filters or date range.</p>
      </div>
    <?php else: ?>
      <div class="sa-card-body sa-table-wrap">
        <table class="sa-table">
          <thead>
            <tr>
              <th>Ticket ID</th>
              <th>Code</th>
              <th>Event</th>
              <th>Buyer</th>
              <th class="sa-num">Qty</th>
              <th class="sa-num">Total</th>
              <th>Pay Opt</th>
              <th>Status</th>
              <th>Purchased At</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r): ?>
              <?php
                $opt = (string)$r['payment_option'];
                $statusBadge = 'status-'.strtolower((string)$r['payment_status']);
              ?>
              <tr>
                <td>#<?= (int)$r['id'] ?></td>
                <td><?= htmlspecialchars($r['ticket_code']) ?></td>
                <td>#<?= (int)$r['event_id'] ?> — <?= htmlspecialchars($r['event_title']) ?></td>
                <td>
                  <?= htmlspecialchars($r['buyer_name']) ?><br>
                  <small><?= htmlspecialchars($r['buyer_email']) ?><?= $r['buyer_phone'] ? ' • '.htmlspecialchars($r['buyer_phone']) : '' ?></small>
                </td>
                <td class="sa-num"><?= (int)$r['quantity'] ?></td>
                <td class="sa-num"><?= number_format((float)$r['total_amount'], 2) ?></td>
                <td>
                  <span class="sa-badge <?= $opt === 'pay_later' ? 'pay_later' : 'pay_now' ?>">
                    <?= str_replace('_',' ', htmlspecialchars($opt)) ?>
                  </span>
                </td>
                <td>
                  <span class="sa-badge <?= htmlspecialchars($statusBadge) ?>">
                    <?= ucfirst(htmlspecialchars($r['payment_status'])) ?>
                  </span>
                </td>
                <td><?= htmlspecialchars(date('M d, Y H:i', strtotime($r['created_at']))) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>

</div>

<?php include __DIR__ . '/_layout_bottom.php'; ?>
