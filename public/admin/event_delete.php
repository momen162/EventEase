<?php
require __DIR__.'/_config.php'; require_login();
$id = (int)($_GET['id'] ?? 0);
if($id > 0){ $pdo->prepare("DELETE FROM events WHERE id=?")->execute([$id]); }
header('Location: /admin/events.php');
