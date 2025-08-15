<?php
require __DIR__.'/_config.php';  // PDO + session helpers
require_login();

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: /admin/events.php'); exit; }

// Load existing event
$st = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$st->execute([$id]);
$event = $st->fetch(PDO::FETCH_ASSOC);
if (!$event) { header('Location: /admin/events.php'); exit; }

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $desc    = $_POST['description'] ?? null;
    $loc     = $_POST['location'] ?? null;
    $venue   = $_POST['venue'] ?? null;
    $starts  = $_POST['starts_at'] ?? null;
    $ends    = $_POST['ends_at'] ?? null;
    $cap     = (int)($_POST['capacity'] ?? 0);
    $price   = (float)($_POST['price'] ?? 0);
    $option  = $_POST['purchase_option'] ?? 'both';
    $removeBanner = isset($_POST['remove_banner']) ? true : false;

    // --- Banner upload handling ---
    $bannerPath = $event['banner']; // keep current by default

    // If a new file is uploaded, move it and set new path
    if (!empty($_FILES['banner']['name']) && is_uploaded_file($_FILES['banner']['tmp_name'])) {
        $dir = __DIR__ . '/../uploads/events';
        if (!is_dir($dir)) { mkdir($dir, 0775, true); }

        $ext = strtolower(pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION));
        // Basic whitelist
        $allowed = ['jpg','jpeg','png','webp','gif'];
        if (!in_array($ext, $allowed)) {
            $error = 'Banner must be an image (jpg, jpeg, png, webp, gif).';
        } else {
            $file = 'ev_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
            $dest = $dir . '/' . $file;
            if (move_uploaded_file($_FILES['banner']['tmp_name'], $dest)) {
                // Delete old file if existed
                if (!empty($event['banner'])) {
                    $oldFs = realpath(__DIR__ . '/..' . $event['banner']);
                    if ($oldFs && is_file($oldFs)) { @unlink($oldFs); }
                }
                $bannerPath = '/uploads/events/' . $file; // URL path stored in DB
            } else {
                $error = 'Failed to upload banner.';
            }
        }
    } elseif ($removeBanner) {
        // Remove existing banner if checkbox ticked
        if (!empty($event['banner'])) {
            $oldFs = realpath(__DIR__ . '/..' . $event['banner']);
            if ($oldFs && is_file($oldFs)) { @unlink($oldFs); }
        }
        $bannerPath = null;
    }

    if (empty($error)) {
        $sql = "UPDATE events SET
                    title = :t,
                    description = :d,
                    location = :loc,
                    venue = :venue,
                    starts_at = :sa,
                    ends_at = :ea,
                    capacity = :cap,
                    price = :price,
                    purchase_option = :opt,
                    banner = :banner,
                    updated_at = NOW()
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id'     => $id,
            ':t'      => $title,
            ':d'      => $desc,
            ':loc'    => $loc,
            ':venue'  => $venue,
            ':sa'     => $starts ?: null,
            ':ea'     => $ends ?: null,
            ':cap'    => $cap,
            ':price'  => $price,
            ':opt'    => in_array($option, ['pay_now','pay_later','both']) ? $option : 'both',
            ':banner' => $bannerPath,
        ]);

        header('Location: /admin/events.php');
        exit;
    }
}

// Helper to prefill datetime-local
function dtval(?string $dt): string {
    return $dt ? str_replace(' ', 'T', substr($dt, 0, 16)) : '';
}
?>
<!doctype html>
<html>
<body>
<h2>Edit Event #<?= (int)$id ?></h2>

<?php if (!empty($error)): ?>
  <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
  <label>Title
    <input name="title" value="<?= htmlspecialchars($event['title'] ?? '') ?>" required>
  </label><br>

  <label>Description<br>
    <textarea name="description" rows="6" cols="60"><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
  </label><br>

  <label>Location
    <input name="location" value="<?= htmlspecialchars($event['location'] ?? '') ?>">
  </label><br>

  <label>Venue
    <input name="venue" value="<?= htmlspecialchars($event['venue'] ?? '') ?>">
  </label><br>

  <label>Starts at
    <input type="datetime-local" name="starts_at" value="<?= dtval($event['starts_at'] ?? null) ?>">
  </label><br>

  <label>Ends at
    <input type="datetime-local" name="ends_at" value="<?= dtval($event['ends_at'] ?? null) ?>">
  </label><br>

  <label>Capacity
    <input type="number" name="capacity" min="0" value="<?= (int)($event['capacity'] ?? 0) ?>">
  </label><br>

  <label>Price
    <input type="number" step="0.01" name="price" min="0" value="<?= htmlspecialchars($event['price'] ?? '0.00') ?>">
  </label><br>

  <label>Purchase option
    <select name="purchase_option">
      <?php
        $opt = $event['purchase_option'] ?? 'both';
        $opts = ['both' => 'Both', 'pay_now' => 'Pay now', 'pay_later' => 'Pay later'];
        foreach ($opts as $val => $label) {
            $sel = $opt === $val ? 'selected' : '';
            echo "<option value=\"$val\" $sel>$label</option>";
        }
      ?>
    </select>
  </label><br>

  <div style="margin:10px 0">
    <strong>Current banner:</strong><br>
    <?php if (!empty($event['banner'])): ?>
      <img src="<?= htmlspecialchars($event['banner']) ?>" alt="banner" style="max-width:320px;border-radius:8px"><br>
      <label><input type="checkbox" name="remove_banner" value="1"> Remove current banner</label><br>
    <?php else: ?>
      <em>No banner uploaded</em><br>
    <?php endif; ?>
  </div>

  <label>Replace banner
    <input type="file" name="banner" accept="image/*">
  </label><br><br>

  <button type="submit">Update</button>
  <a href="/admin/events.php" style="margin-left:10px">Cancel</a>
</form>

</body>
</html>
