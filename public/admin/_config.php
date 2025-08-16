<?php
// --- DB connection shared with Laravel ---
$pdo = new PDO('mysql:host=127.0.0.1;dbname=eventticket;charset=utf8mb4', 'root', '', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false,
]);

// --- Dedicated session for the admin panel (separate from Laravel) ---
session_name('evadmin');              // different cookie than Laravel's
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
session_start();

// --- Helpers ---
function admin_session_id(): ?int {
  return isset($_SESSION['admin_id']) ? (int)$_SESSION['admin_id'] : null;
}
function is_admin_logged_in(): bool {
  return admin_session_id() !== null;
}

/**
 * Hard gate: requires admin session AND verifies role in DB each request.
 * Use on all admin pages except login.php and _auth.php.
 */
function require_admin() {
  if (!is_admin_logged_in()) { header('Location: /admin/login.php'); exit; }

  $id = admin_session_id();
  if (!$id) { header('Location: /admin/login.php'); exit; }

  global $pdo;
  $st = $pdo->prepare("SELECT role, name FROM users WHERE id = ? LIMIT 1");
  $st->execute([$id]);
  $u = $st->fetch();
  if (!$u || strtolower($u['role']) !== 'admin') {
    session_destroy();
    header('Location: /admin/login.php'); exit;
  }
  $_SESSION['admin_name'] = $u['name'] ?? 'Admin';
}

// --- Optional CSRF helpers (use on forms that mutate data) ---
if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(32)); }
function csrf_field(){ echo '<input type="hidden" name="csrf" value="'.htmlspecialchars($_SESSION['csrf']).'">'; }
function csrf_check(){ if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(403); exit('CSRF'); } }
