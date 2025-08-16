<?php
require __DIR__.'/_config.php';
require_admin();
csrf_check();

// Basic validation
$title   = trim($_POST['title'] ?? '');
$author  = trim($_POST['author'] ?? '');
$short   = trim($_POST['short_description'] ?? '');
$full    = trim($_POST['full_content'] ?? '');

if ($title==='' || $author==='' || $short==='' || $full==='') {
  http_response_code(422); exit('All fields are required.');
}

// Image upload
if (empty($_FILES['image']['tmp_name'])) { http_response_code(422); exit('Image required.'); }

$imgTmp  = $_FILES['image']['tmp_name'];
$imgName = $_FILES['image']['name'];
$imgSize = (int)($_FILES['image']['size'] ?? 0);
$allowed = ['image/jpeg'=>'jpg','image/png'=>'png'];

$mime = mime_content_type($imgTmp);
if (!isset($allowed[$mime])) { http_response_code(422); exit('Only JPG/PNG allowed.'); }
if ($imgSize > 2*1024*1024) { http_response_code(422); exit('Image too large (max 2MB).'); }

$ext = $allowed[$mime];
$basename = 'blog_'.date('Ymd_His').'_'.bin2hex(random_bytes(4)).'.'.$ext;
$dest = __DIR__.'/../assets/images/'.$basename;

if (!is_dir(__DIR__.'/../assets/images')) {
  mkdir(__DIR__.'/../assets/images', 0775, true);
}
if (!move_uploaded_file($imgTmp, $dest)) {
  http_response_code(500); exit('Failed to save image.');
}

// Insert
$st = $pdo->prepare("
  INSERT INTO blogs (title, author, short_description, full_content, image, created_at, updated_at)
  VALUES (:t,:a,:s,:f,:i,NOW(),NOW())
");
$st->execute([
  ':t'=>$title, ':a'=>$author, ':s'=>$short, ':f'=>$full, ':i'=>$basename
]);

header('Location: /admin/blogs.php');
exit;
