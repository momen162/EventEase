<?php
require __DIR__.'/_config.php';
require_admin();
csrf_check();

$id     = (int)($_POST['id'] ?? 0);
$title  = trim($_POST['title'] ?? '');
$author = trim($_POST['author'] ?? '');
$short  = trim($_POST['short_description'] ?? '');
$full   = trim($_POST['full_content'] ?? '');

if (!$id || $title==='' || $author==='' || $short==='' || $full==='') {
  http_response_code(422); exit('Invalid input.');
}

// Fetch current to know old image
$st = $pdo->prepare("SELECT image FROM blogs WHERE id=:id LIMIT 1");
$st->execute([':id'=>$id]);
$existing = $st->fetch();
if (!$existing) { http_response_code(404); exit('Not found'); }

$newImage = $existing['image'];

// If a new image uploaded
if (!empty($_FILES['image']['tmp_name'])) {
  $imgTmp  = $_FILES['image']['tmp_name'];
  $imgSize = (int)($_FILES['image']['size'] ?? 0);
  $allowed = ['image/jpeg'=>'jpg','image/png'=>'png'];
  $mime = mime_content_type($imgTmp);
  if (!isset($allowed[$mime])) { http_response_code(422); exit('Only JPG/PNG allowed.'); }
  if ($imgSize > 2*1024*1024) { http_response_code(422); exit('Image too large (max 2MB).'); }

  $ext = $allowed[$mime];
  $basename = 'blog_'.date('Ymd_His').'_'.bin2hex(random_bytes(4)).'.'.$ext;
  $dest = __DIR__.'/../assets/images/'.$basename;
  if (!is_dir(__DIR__.'/../assets/images')) { mkdir(__DIR__.'/../assets/images', 0775, true); }
  if (!move_uploaded_file($imgTmp, $dest)) { http_response_code(500); exit('Failed to save image.'); }

  // delete old image (optional)
  if (!empty($existing['image'])) {
    $oldPath = __DIR__.'/../assets/images/'.$existing['image'];
    if (is_file($oldPath)) @unlink($oldPath);
  }
  $newImage = $basename;
}

// Update
$st = $pdo->prepare("
  UPDATE blogs
  SET title=:t, author=:a, short_description=:s, full_content=:f, image=:i, updated_at=NOW()
  WHERE id=:id
");
$st->execute([
  ':t'=>$title, ':a'=>$author, ':s'=>$short, ':f'=>$full, ':i'=>$newImage, ':id'=>$id
]);

header('Location: /admin/blogs.php');
exit;
