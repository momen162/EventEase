<?php
require __DIR__.'/_config.php'; require_login();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $pdo->prepare("INSERT INTO events (title,description,location,starts_at,ends_at,capacity,created_by,created_at,updated_at)
                 VALUES (:t,:d,:l,:sa,:ea,:c,:cb,NOW(),NOW())")
      ->execute([
        ':t'=>$_POST['title'] ?? '',
        ':d'=>$_POST['description'] ?? null,
        ':l'=>$_POST['location'] ?? null,
        ':sa'=>$_POST['starts_at'] ?? null,
        ':ea'=>$_POST['ends_at'] ?? null,
        ':c'=>(int)($_POST['capacity'] ?? 0),
        ':cb'=>(int)($_SESSION['admin_id'] ?? 0),
      ]);
  header('Location: /admin/events.php'); exit;
}
?>
<!doctype html><html><body>
<h2>Create Event</h2>
<form method="post">
  <label>Title <input name="title" required></label><br>
  <label>Description <textarea name="description"></textarea></label><br>
  <label>Location <input name="location"></label><br>
  <label>Starts at <input type="datetime-local" name="starts_at" required></label><br>
  <label>Ends at <input type="datetime-local" name="ends_at"></label><br>
  <label>Capacity <input type="number" name="capacity" min="0"></label><br>
  <button type="submit">Save</button>
</form>
<p><a href="/admin/events.php">Back</a></p>
</body></html>
