<?php
require __DIR__.'/_config.php';  // gives $pdo + session helpers
require_admin();

$page    = max(1, (int)($_GET['page'] ?? 1));
$perPage = 20;
$offset  = ($page - 1) * $perPage;

$total = (int)$pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();

$stmt = $pdo->prepare("
  SELECT id, name, email, created_at
  FROM contacts
  ORDER BY id DESC
  LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit',  $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset,  PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();

$pageTitle = 'Contact Messages';
require __DIR__.'/_layout_top.php';
?>
<h1>Contact Messages</h1>

<table class="table">
  <thead>
    <tr>
      <th>ID</th><th>Name</th><th>Email</th><th>Received</th><th>Action</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= (int)$r['id'] ?></td>
      <td><?= htmlspecialchars($r['name']) ?></td>
      <td><a href="mailto:<?= htmlspecialchars($r['email']) ?>"><?= htmlspecialchars($r['email']) ?></a></td>
      <td><?= htmlspecialchars($r['created_at']) ?></td>
      <td><a class="btn" href="/admin/message_view.php?id=<?= (int)$r['id'] ?>">View</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php
$pages = max(1, (int)ceil($total/$perPage));
if ($pages > 1): ?>
<div class="pagination">
  <?php for ($i=1; $i<=$pages; $i++): ?>
    <a class="<?= $i===$page ? 'active' : '' ?>" href="?page=<?= $i ?>"><?= $i ?></a>
  <?php endfor; ?>
</div>
<?php endif; ?>

<?php require __DIR__.'/_layout_bottom.php'; ?>
