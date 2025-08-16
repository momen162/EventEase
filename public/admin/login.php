<?php require __DIR__.'/_auth.php'; ?>
<?php $pageTitle = 'Login'; require __DIR__.'/_layout_top.php'; ?>

<div class="grid">
  <div class="col-12">
    <div class="card" style="max-width:520px;margin:40px auto;">
      <h2>Admin Login</h2>
      <p class="help">Use your admin credentials to access the dashboard.</p>

      <?php if(!empty($error)): ?>
        <div class="card" style="background:#fee2e2;border:1px solid #fecaca;margin-top:14px">
          <strong style="color:#b91c1c">Error:</strong> <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="post" style="margin-top:14px">
        <?php csrf_field(); ?>
        <label>Email
          <input type="email" name="email" required value="test@example.com" class="input" autocomplete="username">
        </label>
        <label>Password
          <input type="password" name="password" required class="input" autocomplete="current-password">
        </label>
        <div style="display:flex; gap:10px; align-items:center; margin-top:6px">
          <button type="submit" class="btn btn-primary">Sign in</button>
          <span class="help">Tip: press <span style="border:1px solid #ddd;padding:0 6px;border-radius:6px">Enter</span></span>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__.'/_layout_bottom.php'; ?>
