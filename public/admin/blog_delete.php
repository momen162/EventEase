<?php
require __DIR__.'/_config.php';
require_admin();
csrf_check();

$id = (int)($_POST['id'] ?? 0);
if (!$id) { http_response_code(400); exit('Bad request'); }

// remove image file too
$st = $pdo->prepare("SELECT image FROM blogs WHERE id=:id LIMIT 1");
$st->execute([':id'=>$id]);
$blog = $st->fetch();

$pdo->prepare("DELETE FROM blogs WHERE id=:id")->execute([':id'=>$id]);

if ($blog && !empty($blog['image'])) {
  $path = __DIR__.'/../assets/images/'.$blog['image'];
  if (is_file($path)) @unlink($path);
}

header('Location: /admin/blogs.php');
exit;
