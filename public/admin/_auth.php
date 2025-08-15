<?php
require __DIR__.'/_config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email = trim($_POST['email'] ?? '');
  $pass  = $_POST['password'] ?? '';
  $st = $pdo->prepare("SELECT id,name,email,password,role FROM users WHERE email=:email AND role='admin' LIMIT 1");
  $st->execute([':email'=>$email]);
  $u = $st->fetch(PDO::FETCH_ASSOC);
  if($u && password_verify($pass, $u['password'])){
    $_SESSION['admin_id'] = (int)$u['id'];
    $_SESSION['admin_name'] = $u['name'];
    header('Location: /admin/index.php'); exit;
  }
  $error = 'Invalid credentials';
}
