<?php
// include AFTER you require _config.php (so session helpers exist)
// Usage: $pageTitle = 'Page Title'; require __DIR__.'/_layout_top.php';
if (!isset($pageTitle)) { $pageTitle = 'Admin'; }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($pageTitle) ?> • EventEase Admin</title>
  <link rel="stylesheet" href="/admin/admin.css">
</head>
<body>
<header class="app-header">
  <div class="wrap" style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px">
    <a href="/admin/index.php" class="brand-link" style="text-decoration:none;color:#2563eb;font-weight:800;">EventEase Admin</a>

    <nav class="nav">
      <?php if (function_exists('is_logged_in') && is_logged_in()): ?>
        <a href="/admin/users.php">Users</a>
        <a href="/admin/events.php">Events</a>
        <a href="/admin/logout.php" class="btn btn-ghost">Logout</a>
      <?php else: ?>
        <!-- Show nothing (or a Login link if you prefer) -->
        <!-- <a href="/admin/login.php" class="btn btn-ghost">Login</a> -->
      <?php endif; ?>
    </nav>
  </div>
</header>

<main class="wrap page">
