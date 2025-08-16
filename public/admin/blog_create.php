<?php
require __DIR__.'/_config.php';
require_admin();
$pageTitle = 'New Blog';
require __DIR__.'/_layout_top.php';
?>
<h1>New Blog</h1>

<form method="POST" action="/admin/blog_store.php" enctype="multipart/form-data" class="form">
  <?php csrf_field(); ?>
  <label>Title</label>
  <input type="text" name="title" required>

  <label>Author</label>
  <input type="text" name="author" required>

  <label>Short Description</label>
  <textarea name="short_description" rows="3" maxlength="500" required></textarea>

  <label>Full Content</label>
  <textarea name="full_content" rows="10" required></textarea>

  <label>Image (JPG/PNG, ≤ 2MB)</label>
  <input type="file" name="image" accept=".jpg,.jpeg,.png" required>

  <button class="btn btn-primary" type="submit">Create</button>
  <a class="btn btn-ghost" href="/admin/blogs.php">Cancel</a>
</form>

<?php require __DIR__.'/_layout_bottom.php'; ?>
