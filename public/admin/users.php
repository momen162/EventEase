<?php
require DIR.'/_config.php'; require_login();

if(isset($_GET['delete'])){
  $id = (int)$_GET['delete'];
  if($id > 0 && $id !== (int)($_SESSION['admin_id'] ?? 0)){
    $pdo->prepare("DELETE FROM users WHERE id=?")->execute([$id]);
  }
  header('Location: /admin/users.php'); exit;
}

$rows = $pdo->query("SELECT id,name,email,role,created_at FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html><html><body>
<h2>Users</h2>
<table border="1" cellpadding="6">
<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr>
<?php foreach($rows as $u): ?>
<tr>
  <td><?= (int)$u['id'] ?></td>
  <td><?= htmlspecialchars($u['name']) ?></td>
  <td><?= htmlspecialchars($u['email']) ?></td>
  <td><?= htmlspecialchars($u['role']) ?></td>
  <td><?php if((int)$u['id'] !== (int)($_SESSION['admin_id'] ?? 0)): ?>
        <a href="?delete=<?= (int)$u['id'] ?>" onclick="return confirm('Delete user?')">Delete</a>
      <?php endif; ?>
  </td>
</tr>
<?php endforeach; ?>
</table>
<p><a href="/admin/index.php">Back</a></p>
</body></html>