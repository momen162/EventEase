<?php
require __DIR__ . '/_config.php';
require_admin();
csrf_check();

$id = (int)($_POST['id'] ?? 0);
if (!$id) { http_response_code(400); exit('Bad request'); }

$adminId = admin_session_id();

$st = $pdo->prepare("UPDATE events SET status='approved', approved_by=?, approved_at=NOW() WHERE id=? AND status='pending'");
$st->execute([$adminId, $id]);

header('Location: /admin/event_requests.php');
