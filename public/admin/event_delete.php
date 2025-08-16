<?php
require __DIR__.'/_config.php';  // DB + admin session helpers
require_admin();                 // 🔒 only logged-in admins can access

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: /admin/events.php'); 
    exit;
}

// Load event first
$st = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$st->execute([$id]);
$event = $st->fetch();

if (!$event) {
    header('Location: /admin/events.php');
    exit;
}

// Delete banner file if exists
if (!empty($event['banner'])) {
    $oldFs = realpath(__DIR__ . '/..' . $event['banner']);
    if ($oldFs && is_file($oldFs)) {
        @unlink($oldFs);
    }
}

// Delete tickets linked to this event (optional cleanup, depends on your DB design)
$pdo->prepare("DELETE FROM tickets WHERE event_id = ?")->execute([$id]);

// Delete event itself
$pdo->prepare("DELETE FROM events WHERE id = ?")->execute([$id]);

header('Location: /admin/events.php');
exit;
