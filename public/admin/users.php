<?php
require __DIR__.'/_config.php'; require_admin();

if(isset($_GET['delete'])){
  $id = (int)$_GET['delete'];
  if($id > 0 && $id !== (int)($_SESSION['admin_id'] ?? 0)){
    $pdo->prepare("DELETE FROM users WHERE id=?")->execute([$id]);
  }
  header('Location: /admin/users.php'); exit;
}

$rows = $pdo->query("SELECT id,name,email,role,created_at FROM users ORDER BY id DESC")->fetchAll();
$pageTitle = 'Users';
require __DIR__.'/_layout_top.php';
?>

<div class="grid">
  <div class="col-12">
    <div class="card">
      <div style="display:flex; align-items:center; justify-content:space-between; gap:12px">
        <div>
          <h2>Users</h2>
          <p class="help">List of all registered users.</p>
        </div>
        <div class="help">Total: <span class="badge"><?= count($rows) ?></span></div>
      </div>

      <?php if(!$rows): ?>
        <div class="empty">No users found.</div>
      <?php else: ?>
        <div class="table-wrap">
          <table>
            <thead>
              <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Created</th><th>Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($rows as $u): ?>
              <tr>
                <td><?= (int)$u['id'] ?></td>
                <td><?= htmlspecialchars($u['name']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td>
                  <?php if(($u['role'] ?? '') === 'admin'): ?>
                    <span class="badge admin">Admin</span>
                  <?php else: ?>
                    <span class="badge"><?= htmlspecialchars($u['role']) ?></span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($u['created_at'] ?? '') ?></td>
                <td>
                  <?php if((int)$u['id'] !== (int)($_SESSION['admin_id'] ?? 0)): ?>
                    <a class="btn btn-sm btn-danger" href="?delete=<?= (int)$u['id'] ?>" onclick="return confirm('Delete user?')">Delete</a>
                  <?php else: ?>
                    <span class="help">You</span>
                  <?php endif; ?>
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
