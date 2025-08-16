<?php
require __DIR__.'/_config.php';
require_admin();

$page    = max(1, (int)($_GET['page'] ?? 1));
$perPage = 20;
$offset  = ($page - 1) * $perPage;

$total = (int)$pdo->query("SELECT COUNT(*) FROM blogs")->fetchColumn();

$st = $pdo->prepare("
  SELECT id, title, author, image, created_at
  FROM blogs
  ORDER BY id DESC
  LIMIT :l OFFSET :o
");
$st->bindValue(':l', $perPage, PDO::PARAM_INT);
$st->bindValue(':o', $offset, PDO::PARAM_INT);
$st->execute();
$rows = $st->fetchAll();

$pageTitle = 'Blogs';
require __DIR__.'/_layout_top.php';
?>
<h1>Blogs</h1>

<p><a class="btn btn-primary" href="/admin/blog_create.php">+ New Blog</a></p>

<table class="table">
  <thead>
    <tr><th>ID</th><th>Title</th><th>Author</th><th>Image</th><th>Created</th><th>Actions</th></tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $b): ?>
      <tr>
        <td><?= (int)$b['id'] ?></td>
        <td><?= htmlspecialchars($b['title']) ?></td>
        <td><?= htmlspecialchars($b['author']) ?></td>
        <td>
          <?php if (!empty($b['image'])): ?>
            <img src="/assets/images/<?= htmlspecialchars($b['image']) ?>" alt="" style="height:40px">
          <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($b['created_at']) ?></td>
        <td style="white-space:nowrap">
          <a class="btn" href="/admin/blog_edit.php?id=<?= (int)$b['id'] ?>">Edit</a>
          <form action="/admin/blog_delete.php" method="POST" style="display:inline" onsubmit="return confirm('Delete this blog?')">
            <?php csrf_field(); ?>
            <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
            <button class="btn btn-ghost" type="submit">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php
$pages = max(1, (int)ceil($total/$perPage));
if ($pages > 1): ?>
<div class="pagination">
  <?php for ($i=1; $i<=$pages; $i++): ?>
    <a class="<?= $i===$page?'active':'' ?>" href="?page=<?= $i ?>"><?= $i ?></a>
  <?php endfor; ?>
</div>
<?php endif; ?>

<?php require __DIR__.'/_layout_bottom.php'; ?>
