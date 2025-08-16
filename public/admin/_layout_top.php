<?php
// include AFTER you require _config.php (so session is ready)
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
  <div class="wrap">
    <div class="brand">
      <a href="/admin/index.php" class="brand-link" aria-label="Dashboard">EventEase <span>Admin</span></a>
    </div>
    <nav class="nav">
      <a href="/admin/users.php">Users</a>
      <a href="/admin/events.php">Events</a>
      <a href="/admin/logout.php" class="btn btn-ghost">Logout right now</a>
    </nav>
  </div>
</header>

<main class="wrap page">
