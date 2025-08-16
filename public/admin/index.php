<?php require __DIR__.'/_config.php'; require_admin(); ?>
<?php $pageTitle = 'Dashboard'; require __DIR__.'/_layout_top.php'; ?>

<div class="grid">
  <div class="col-12">
    <div class="card">
      <h2>Welcome, <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></h2>
      <p class="help">Quick links to common tasks.</p>
      <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:10px">
        <a class="btn btn-primary" href="/admin/users.php">Manage Users</a>
        <a class="btn btn-primary" href="/admin/events.php">Manage Events</a>
        <a class="btn btn-ghost" href="/admin/stats.php">View Stats</a>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__.'/_layout_bottom.php'; ?>
