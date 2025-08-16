<?php
require __DIR__.'/_config.php';

// If already logged-in admin hits login page, bounce to dashboard
if ($_SERVER['REQUEST_METHOD'] === 'GET' && is_admin_logged_in()) {
  header('Location: /admin/index.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  csrf_check();

  $email = trim($_POST['email'] ?? '');
  $pass  = (string)($_POST['password'] ?? '');

  $st = $pdo->prepare("SELECT id, name, email, password, role FROM users WHERE email = :email LIMIT 1");
  $st->execute([':email' => $email]);
  $u = $st->fetch();

  if ($u && strtolower($u['role']) === 'admin' && password_verify($pass, $u['password'])) {
    session_regenerate_id(true);
    $_SESSION['admin_id']   = (int)$u['id'];
    $_SESSION['admin_name'] = $u['name'] ?: 'Admin';
    header('Location: /admin/index.php'); exit;
  }

  $error = 'Invalid credentials or not an admin account.';
}
