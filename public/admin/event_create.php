<?php
require __DIR__.'/_config.php'; require_login();

if($_SERVER['REQUEST_METHOD']==='POST'){
  $bannerPath = null;
  if(!empty($_FILES['banner']['name'])){
    $dir = __DIR__.'/../uploads/events';
    if(!is_dir($dir)) mkdir($dir, 0775, true);
    $ext = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);
    $file = 'ev_'.time().'_'.mt_rand(1000,9999).'.'.$ext;
    move_uploaded_file($_FILES['banner']['tmp_name'], $dir.'/'.$file);
    $bannerPath = '/uploads/events/'.$file;
  }

  $stmt = $pdo->prepare("
    INSERT INTO events (title,description,location,venue,starts_at,ends_at,capacity,price,purchase_option,banner,created_by,created_at,updated_at)
    VALUES (:t,:d,:loc,:v,:sa,:ea,:cap,:price,:opt,:banner,:cb,NOW(),NOW())
  ");
  $stmt->execute([
    ':t'=>$_POST['title']??'',
    ':d'=>$_POST['description']??null,
    ':loc'=>$_POST['location']??null,
    ':v'=>$_POST['venue']??null,
    ':sa'=>$_POST['starts_at']??null,
    ':ea'=>$_POST['ends_at']??null,
    ':cap'=>(int)($_POST['capacity']??0),
    ':price'=>(float)($_POST['price']??0),
    ':opt'=>$_POST['purchase_option']??'both',
    ':banner'=>$bannerPath,
    ':cb'=>(int)($_SESSION['admin_id']??0),
  ]);
  header('Location: /admin/events.php'); exit;
}

$pageTitle = 'Create Event';
require __DIR__.'/_layout_top.php';
?>

<div class="grid">
  <div class="col-12">
    <div class="card">
      <h2>Create Event</h2>
      <form method="post" enctype="multipart/form-data" style="margin-top:10px">
        <label>Title <input name="title" required class="input"></label>
        <label>Description <textarea name="description" rows="6" class="input"></textarea></label>

        <div class="form-row">
          <label>Location <input name="location" class="input"></label>
          <label>Venue <input name="venue" class="input"></label>
        </div>

        <div class="form-row">
          <label>Starts at <input type="datetime-local" name="starts_at" required class="input"></label>
          <label>Ends at <input type="datetime-local" name="ends_at" class="input"></label>
        </div>

        <div class="form-row">
          <label>Capacity <input type="number" name="capacity" min="0" class="input"></label>
          <label>Price <input type="number" step="0.01" name="price" min="0" class="input"></label>
        </div>

        <label>Purchase option
          <select name="purchase_option" class="input">
            <option value="both">Both</option>
            <option value="pay_now">Pay now</option>
            <option value="pay_later">Pay later</option>
          </select>
        </label>

        <label>Banner <input type="file" name="banner" accept="image/*" class="input"></label>

        <div style="display:flex; gap:10px; flex-wrap:wrap">
          <button type="submit" class="btn btn-primary">Save</button>
          <a href="/admin/events.php" class="btn btn-ghost">Back</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__.'/_layout_bottom.php'; ?>
