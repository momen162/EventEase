<?php
// Include this after _config.php in each page
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
  <div class="wrap header-inner">
    <a href="<?= is_admin_logged_in() ? '/admin/index.php' : '/admin/login.php' ?>" class="brand-link">EventEase Admin</a>

    <nav class="nav">
      <?php if (is_admin_logged_in()): ?>
        <a href="/admin/users.php">Users</a>
        <a href="/admin/events.php">Events</a>
        <a href="/admin/event_requests.php">Pending Requests</a>
        <a href="/admin/blogs.php">Blogs</a>
        <a href="/admin/stats.php">Stats</a>
        <a href="/admin/messages.php">Messages</a>
        <a href="/admin/logout.php" class="btn btn-ghost">Logout</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<main class="wrap page">
