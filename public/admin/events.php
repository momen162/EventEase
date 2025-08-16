<?php
require __DIR__.'/_config.php'; require_admin();
$events = $pdo->query("SELECT id,title,location,starts_at,ends_at,capacity FROM events ORDER BY starts_at DESC")->fetchAll();
$pageTitle = 'Events';
require __DIR__.'/_layout_top.php';
?>

<div class="grid">
  <div class="col-12">
    <div class="card">
      <div style="display:flex; align-items:center; justify-content:space-between; gap:12px">
        <div>
          <h2>Events</h2>
          <p class="help">Create, edit, and manage events.</p>
        </div>
        <a class="btn btn-primary" href="/admin/event_create.php">+ New Event</a>
      </div>

      <?php if(!$events): ?>
        <div class="empty">No events yet. Click <strong>+ New Event</strong> to create one.</div>
      <?php else: ?>
        <div class="table-wrap">
          <table>
            <thead>
              <tr><th>ID</th><th>Title</th><th>When</th><th>Location</th><th>Cap.</th><th>Actions</th></tr>
            </thead>
            <tbody>
              <?php foreach($events as $e): ?>
              <tr>
                <td><?= (int)$e['id'] ?></td>
                <td><?= htmlspecialchars($e['title']) ?></td>
                <td><?= htmlspecialchars($e['starts_at']) ?> — <?= htmlspecialchars($e['ends_at']) ?></td>
                <td><?= htmlspecialchars($e['location']) ?></td>
                <td><?= htmlspecialchars($e['capacity']) ?></td>
                <td>
                  <a class="btn btn-sm" href="/admin/event_edit.php?id=<?= (int)$e['id'] ?>">Edit</a>
                  <a class="btn btn-sm btn-danger" href="/admin/event_delete.php?id=<?= (int)$e['id'] ?>" onclick="return confirm('Delete event?')">Delete</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

      <div style="margin-top:14px">
        <a href="/admin/index.php" class="btn btn-ghost">Back</a>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__.'/_layout_bottom.php'; ?>
