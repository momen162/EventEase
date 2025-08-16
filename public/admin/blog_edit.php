<?php
require __DIR__.'/_config.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
$st = $pdo->prepare("SELECT * FROM blogs WHERE id=:id LIMIT 1");
$st->execute([':id'=>$id]);
$blog = $st->fetch();
if (!$blog) { http_response_code(404); exit('Not found'); }

$pageTitle = 'Edit Blog #'.$blog['id'];
require __DIR__.'/_layout_top.php';
?>
<h1>Edit Blog</h1>

<form method="POST" action="/admin/blog_update.php" enctype="multipart/form-data" class="form">
  <?php csrf_field(); ?>
  <input type="hidden" name="id" value="<?= (int)$blog['id'] ?>">

  <label>Title</label>
  <input type="text" name="title" value="<?= htmlspecialchars($blog['title']) ?>" required>

  <label>Author</label>
  <input type="text" name="author" value="<?= htmlspecialchars($blog['author']) ?>" required>

  <label>Short Description</label>
  <textarea name="short_description" rows="3" required><?= htmlspecialchars($blog['short_description']) ?></textarea>

  <label>Full Content</label>
  <textarea name="full_content" rows="10" required><?= htmlspecialchars($blog['full_content']) ?></textarea>

  <label>Current Image</label><br>
  <?php if (!empty($blog['image'])): ?>
    <img src="/assets/images/<?= htmlspecialchars($blog['image']) ?>" alt="" style="height:80px"><br>
  <?php endif; ?>

  <label>Replace Image (optional, JPG/PNG ≤ 2MB)</label>
  <input type="file" name="image" accept=".jpg,.jpeg,.png">

  <button class="btn btn-primary" type="submit">Save Changes</button>
  <a class="btn btn-ghost" href="/admin/blogs.php">Cancel</a>
</form>

<?php require __DIR__.'/_layout_bottom.php'; ?>
