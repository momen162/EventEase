<?php
require __DIR__ . '/_config.php';
require_admin();

// Same filters as sales.php
$status = $_GET['status'] ?? '';
$option = $_GET['payment_option'] ?? '';
$eventId = isset($_GET['event_id']) ? (int)$_GET['event_id'] : 0;
$q      = trim($_GET['q'] ?? '');
$from   = $_GET['from'] ?? '';
$to     = $_GET['to'] ?? '';

$where  = [];
$params = [];

if ($status !== '' && in_array($status, ['unpaid','paid','cancelled'], true)) {
  $where[] = "t.payment_status = ?";
  $params[] = $status;
}
if ($option !== '' && in_array($option, ['pay_now','pay_later'], true)) {
  $where[] = "t.payment_option = ?";
  $params[] = $option;
}
if ($eventId > 0) {
  $where[] = "t.event_id = ?";
  $params[] = $eventId;
}
if ($q !== '') {
  $where[] = "(t.ticket_code LIKE ? OR u.name LIKE ? OR u.email LIKE ?)";
  $like = '%'.$q.'%';
  array_push($params, $like, $like, $like);
}
if ($from !== '') {
  $where[] = "DATE(t.created_at) >= ?";
  $params[] = $from;
}
if ($to !== '') {
  $where[] = "DATE(t.created_at) <= ?";
  $params[] = $to;
}

$whereSql = $where ? ('WHERE '.implode(' AND ', $where)) : '';

$sql = "
  SELECT
    t.id, t.ticket_code, t.quantity, t.total_amount, t.payment_option, t.payment_status, t.created_at,
    e.id AS event_id, e.title AS event_title,
    u.id AS user_id, u.name AS buyer_name, u.email AS buyer_email, u.phone AS buyer_phone
  FROM tickets t
  JOIN users  u ON u.id = t.user_id
  JOIN events e ON e.id = t.event_id
  $whereSql
  ORDER BY t.created_at DESC
";
$st = $pdo->prepare($sql);
$st->execute($params);
$rows = $st->fetchAll();

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=sales_export_'.date('Ymd_His').'.csv');

$out = fopen('php://output', 'w');
fputcsv($out, ['Ticket ID','Ticket Code','Event ID','Event Title','Buyer Name','Buyer Email','Buyer Phone','Quantity','Total Amount','Payment Option','Payment Status','Purchased At']);

foreach ($rows as $r) {
  fputcsv($out, [
    $r['id'],
    $r['ticket_code'],
    $r['event_id'],
    $r['event_title'],
    $r['buyer_name'],
    $r['buyer_email'],
    $r['buyer_phone'],
    $r['quantity'],
    number_format((float)$r['total_amount'],2,'.',''),
    $r['payment_option'],
    $r['payment_status'],
    $r['created_at'],
  ]);
}
fclose($out);
