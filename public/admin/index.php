<?php require __DIR__.'/_config.php'; require_login(); ?>
<!doctype html><html><body>
<h2>Admin Dashboard</h2>
<p>Welcome, <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></p>
<ul>
  <li><a href="/admin/users.php">Manage Users</a></li>
  <li><a href="/admin/events.php">Manage Events</a></li>
  <li><a href="/admin/logout.php">Logout</a></li>
</ul>
</body></html>
