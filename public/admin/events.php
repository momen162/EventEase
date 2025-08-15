<?php
require __DIR__.'/_config.php'; require_login();
$events = $pdo->query("SELECT id,title,location,starts_at,ends_at,capacity FROM events ORDER BY starts_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html><html><body>
<h2>Events</h2>
<p><a href="/admin/event_create.php">+ New Event</a></p>
<table border="1" cellpadding="6">
<tr><th>ID</th><th>Title</th><th>When</th><th>Location</th><th>Cap.</th><th>Actions</th></tr>
<?php foreach($events as $e): ?>
<tr>
  <td><?= (int)$e['id'] ?></td>
  <td><?= htmlspecialchars($e['title']) ?></td>
  <td><?= htmlspecialchars($e['starts_at']) ?> - <?= htmlspecialchars($e['ends_at']) ?></td>
  <td><?= htmlspecialchars($e['location']) ?></td>
  <td><?= htmlspecialchars($e['capacity']) ?></td>
  <td>
    <a href="/admin/event_edit.php?id=<?= (int)$e['id'] ?>">Edit</a> |
    <a href="/admin/event_delete.php?id=<?= (int)$e['id'] ?>" onclick="return confirm('Delete event?')">Delete</a>
  </td>
</tr>
<?php endforeach; ?>
</table>
<p><a href="/admin/index.php">Back</a></p>
</body></html>
