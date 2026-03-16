<div class="profileForm">
  <!--Form pa editar el nombre-->
  <form method="post" action="index.php?page=profile">
    <h1>Edit Profile</h1><br>

    <?php if (!empty($message)): ?>
      <div class="msg ok"><p><?= htmlspecialchars($message) ?></p></div>
    <?php endif; ?>

    <?php if (!empty($messageErr)): ?>
      <div class="msg bad"><p><?= htmlspecialchars($messageErr) ?></p></div>
    <?php endif; ?>

    <p class="profileMeta">
      Current user: <strong><?= htmlspecialchars($currentUser) ?></strong>
    </p>

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

    <label>
      New username
      <input type="text" name="new_user" value="<?= htmlspecialchars($currentUser) ?>" required>
    </label><br><br>

    <div class="hint">Allowed: letters, numbers, and "_". 3 to 20 characters.</div><br><br>

    <div class="buttons">
      <button type="submit" class="save" name="update_profile">Save</button>

      <a href="index.php?page=objectes">
        <button class="return" type="button">Return</button>
      </a>
    </div>
  </form>

  <hr style="margin: 28px 0;">

  <!--Form pa cambiar contraseña-->
  <form method="post" action="index.php?page=profile">
    <h2 style="margin-top: 0;">Change password</h2><br>

    <?php if (!empty($passMessage)): ?>
      <div class="msg ok"><p><?= htmlspecialchars($passMessage) ?></p></div>
    <?php endif; ?>

    <?php if (!empty($passMessageErr)): ?>
      <div class="msg bad"><p><?= htmlspecialchars($passMessageErr) ?></p></div>
    <?php endif; ?>

    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

    <label>
      Current password
      <input type="password" name="current_password" required>
    </label><br><br>

    <label>
      New password
      <input type="password" name="new_password" required>
    </label><br><br>

    <label>
      Repeat new password
      <input type="password" name="confirm_password" required>
    </label><br><br>

    <div class="hint">Tip: use at least 8 characters.</div><br><br>

    <div class="buttons">
      <button type="submit" class="save" name="change_password">Update password</button>
    </div>
  </form>

</div>