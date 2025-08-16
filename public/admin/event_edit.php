<?php
require __DIR__.'/_config.php';  // DB + admin session helpers
require_admin();                 // 🔒 only logged-in admins can access

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: /admin/events.php'); exit; }

// Load existing event
$st = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$st->execute([$id]);
$event = $st->fetch();
if (!$event) { header('Location: /admin/events.php'); exit; }

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If you want CSRF on admin forms, uncomment this:
    // csrf_check();

    $title   = trim($_POST['title'] ?? '');
    $desc    = $_POST['description'] ?? null;
    $loc     = $_POST['location'] ?? null;
    $venue   = $_POST['venue'] ?? null;
    $starts  = $_POST['starts_at'] ?? null;
    $ends    = $_POST['ends_at'] ?? null;
    $cap     = (int)($_POST['capacity'] ?? 0);
    $price   = (float)($_POST['price'] ?? 0);
    $option  = $_POST['purchase_option'] ?? 'both';
    $removeBanner = isset($_POST['remove_banner']);

    // Keep current banner by default
    $bannerPath = $event['banner'];

    // --- Banner upload handling ---
    if (!empty($_FILES['banner']['name']) && is_uploaded_file($_FILES['banner']['tmp_name'])) {
        $dir = __DIR__ . '/../uploads/events';
        if (!is_dir($dir)) { mkdir($dir, 0775, true); }

        $ext = strtolower(pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION));
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

    if (empty($title)) {
        $error = 'Title is required.';
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

        header('Location: /admin/events.php'); exit;
    }
}

// Helper to prefill datetime-local
function dtval(?string $dt): string {
    return $dt ? str_replace(' ', 'T', substr($dt, 0, 16)) : '';
}

$pageTitle = "Edit Event #$id";
require __DIR__.'/_layout_top.php';
?>

<div class="grid">
  <div class="col-12">
    <div class="card">
      <h2>Edit Event #<?= (int)$id ?></h2>

      <?php if (!empty($error)): ?>
        <div class="card" style="background:#fee2e2;border:1px solid #fecaca;margin-top:14px">
          <strong style="color:#b91c1c">Error:</strong> <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data" style="margin-top:10px">
        <?php csrf_field(); ?>

        <label>Title
          <input name="title" value="<?= htmlspecialchars($event['title'] ?? '') ?>" required class="input">
        </label>

        <label>Description
          <textarea name="description" rows="6" class="input"><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
        </label>

        <div class="form-row">
          <label>Location
            <input name="location" value="<?= htmlspecialchars($event['location'] ?? '') ?>" class="input">
          </label>
          <label>Venue
            <input name="venue" value="<?= htmlspecialchars($event['venue'] ?? '') ?>" class="input">
          </label>
        </div>

        <div class="form-row">
          <label>Starts at
            <input type="datetime-local" name="starts_at" value="<?= dtval($event['starts_at'] ?? null) ?>" class="input">
          </label>
          <label>Ends at
            <input type="datetime-local" name="ends_at" value="<?= dtval($event['ends_at'] ?? null) ?>" class="input">
          </label>
        </div>

        <div class="form-row">
          <label>Capacity
            <input type="number" name="capacity" min="0" value="<?= (int)($event['capacity'] ?? 0) ?>" class="input">
          </label>
          <label>Price
            <input type="number" step="0.01" name="price" min="0" value="<?= htmlspecialchars($event['price'] ?? '0.00') ?>" class="input">
          </label>
        </div>

        <label>Purchase option
          <select name="purchase_option" class="input">
            <?php
              $opt = $event['purchase_option'] ?? 'both';
              $opts = ['both' => 'Both', 'pay_now' => 'Pay now', 'pay_later' => 'Pay later'];
              foreach ($opts as $val => $label) {
                  $sel = $opt === $val ? 'selected' : '';
                  echo "<option value=\"$val\" $sel>$label</option>";
              }
            ?>
          </select>
        </label>

        <div style="margin:10px 0">
          <strong>Current banner:</strong><br>
          <?php if (!empty($event['banner'])): ?>
            <img src="<?= htmlspecialchars($event['banner']) ?>" alt="banner" class="preview"><br>
            <label style="display:inline-flex; gap:8px; align-items:center; margin-top:8px">
              <input type="checkbox" name="remove_banner" value="1"> Remove current banner
            </label>
          <?php else: ?>
            <em class="help">No banner uploaded</em><br>
          <?php endif; ?>
        </div>

        <label>Replace banner
          <input type="file" name="banner" accept="image/*" class="input">
        </label>

        <div style="display:flex; gap:10px; flex-wrap:wrap">
          <button type="submit" class="btn btn-primary">Update</button>
          <a href="/admin/events.php" class="btn btn-ghost">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__.'/_layout_bottom.php'; ?>
