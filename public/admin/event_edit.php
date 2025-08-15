<?php
require __DIR__.'/_config.php'; require_login();
$id = (int)($_GET['id'] ?? 0);
if($id <= 0){ header('Location: /admin/events.php'); exit; }

if($_SERVER['REQUEST_METHOD']==='POST'){
  $pdo->prepare("UPDATE events SET title=:t,description=:d,location=:l,starts_at=:sa,ends_at=:ea,capacity=:c,updated_at=NOW() WHERE id=:id")
      ->execute([
        ':id'=>$id, ':t'=>$_POST['title'] ?? '',
        ':d'=>$_POST['description'] ?? null, ':l'=>$_POST['location'] ?? null,
        ':sa'=>$_POST['starts_at'] ?? null, ':ea'=>$_POST['ends_at'] ?? null,
        ':c'=>(int)($_POST['capacity'] ?? 0),
      ]);
  header('Location: /admin/events.php'); exit;
}
$st = $pdo->prepare("SELECT * FROM events WHERE id=?"); $st->execute([$id]); $e = $st->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html><html><body>
<h2>Edit Event #<?= (int)$id ?></h2>
<form method="post">
  <label>Title <input name="title" value="<?= htmlspecialchars($e['title']) ?>" required></label><br>
  <label>Description <textarea name="description"><?= htmlspecialchars($e['description']) ?></textarea></label><br>
  <label>Location <input name="location" value="<?= htmlspecialchars($e['location']) ?>"></label><br>
  <label>Starts at <input type="datetime-local" name="starts_at" value="<?= $e['starts_at'] ? str_replace(' ', 'T', $e['starts_at']) : '' ?>"></label><br>
  <label>Ends at <input type="datetime-local" name="ends_at" value="<?= $e['ends_at'] ? str_replace(' ', 'T', $e['ends_at']) : '' ?>"></label><br>
  <label>Capacity <input type="number" name="capacity" min="0" value="<?= (int)$e['capacity'] ?>"></label><br>
  <button type="submit">Update</button>
</form>
<p><a href="/admin/events.php">Back</a></p>
</body></html>
