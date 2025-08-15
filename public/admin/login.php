<?php require __DIR__.'/_auth.php'; ?>

<!doctype html><html><body>
<h2>Admin Login</h2>
<?php if(!empty($error)) echo "<p style='color:red'>".htmlspecialchars($error)."</p>"; ?>
<form method="post">
  <label>Email <input type="email" name="email" required value="test@example.com"></label><br>
  <label>Password <input type="password" name="password" required></label><br>
  <button type="submit">Login</button>
</form>
</body></html>