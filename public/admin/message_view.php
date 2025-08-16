<?php
require __DIR__.'/_config.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
$st = $pdo->prepare("SELECT * FROM contacts WHERE id = :id LIMIT 1");
$st->execute([':id' => $id]);
$contact = $st->fetch();

if (!$contact) { http_response_code(404); exit('Message not found'); }

$pageTitle = 'Message #'.$contact['id'];
require __DIR__.'/_layout_top.php';
?>
<h1>Message #<?= (int)$contact['id'] ?></h1>

<div class="card">
  <p><strong>Name:</strong> <?= htmlspecialchars($contact['name']) ?></p>
  <p><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars($contact['email']) ?>"><?= htmlspecialchars($contact['email']) ?></a></p>
  <p><strong>Received:</strong> <?= htmlspecialchars($contact['created_at']) ?></p>
  <p><strong>Message:</strong></p>
  <pre class="pre-wrap"><?= htmlspecialchars($contact['message']) ?></pre>
</div>

<h2>Reply</h2>
<?php if (!empty($_GET['sent'])): ?>
  <div class="notice success">Reply email sent.</div>
<?php endif; ?>

<form method="POST" action="/admin/message_reply.php" class="form">
  <?php csrf_field(); ?>
  <input type="hidden" name="id" value="<?= (int)$contact['id'] ?>">
  <label>To</label>
  <input type="email" name="to" value="<?= htmlspecialchars($contact['email']) ?>" required>

  <label>Subject</label>
  <input type="text" name="subject" value="Re: Your message to EventEase" required>

  <label>Message</label>
  <textarea name="body" rows="8" required></textarea>

  <button class="btn btn-primary" type="submit">Send Reply</button>
</form>

<p style="margin-top:14px"><a href="/admin/messages.php">&larr; Back to list</a></p>

<?php require __DIR__.'/_layout_bottom.php'; ?>
