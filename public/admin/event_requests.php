<?php
require __DIR__ . '/_config.php';
require_admin();

$pageTitle = 'Pending Event Requests';

$st = $pdo->query("
  SELECT e.id, e.title, e.location, e.starts_at, e.ends_at, e.capacity, e.status,
         u.name AS requester_name, u.email AS requester_email
  FROM events e
  LEFT JOIN users u ON u.id = e.created_by
  WHERE e.status = 'pending'
  ORDER BY e.starts_at ASC
");
$rows = $st->fetchAll();

include __DIR__ . '/_layout_top.php';
?>
<h2>Pending Event Requests</h2>

<?php if (!$rows): ?>
  <p>No pending requests.</p>
<?php else: ?>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th><th>Title</th><th>When</th><th>Location</th>
        <th>Capacity</th><th>Requested By</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= (int)$r['id'] ?></td>
          <td><?= htmlspecialchars($r['title']) ?></td>
          <td>
            <?= htmlspecialchars(date('M d, Y H:i', strtotime($r['starts_at']))) ?>
            <?php if (!empty($r['ends_at'])): ?>
              – <?= htmlspecialchars(date('M d, Y H:i', strtotime($r['ends_at']))) ?>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($r['location'] ?? '—') ?></td>
          <td><?= htmlspecialchars($r['capacity'] ?? '—') ?></td>
          <td>
            <?= htmlspecialchars($r['requester_name'] ?? 'Unknown') ?><br>
            <small><?= htmlspecialchars($r['requester_email'] ?? '') ?></small>
          </td>
          <td style="white-space:nowrap;">
            <form action="/admin/event_approve.php" method="POST" style="display:inline;">
              <?php csrf_field(); ?>
              <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
              <button type="submit">Approve</button>
            </form>
            <form action="/admin/event_reject.php" method="POST" style="display:inline;" onsubmit="return confirm('Reject this request?');">
              <?php csrf_field(); ?>
              <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
              <button type="submit">Reject</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
