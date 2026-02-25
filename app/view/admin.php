<div class="admin-container">
    <div class="admin-header">
        <h2>Admin dashboard</h2>
    </div>

    <p class="small-note">
        Logged as: <strong><?= htmlspecialchars($currentUser) ?></strong>
    </p>

    <?php if (!empty($message)): ?>
        <div class="msg ok"><p><?= htmlspecialchars($message) ?></p></div>
    <?php endif; ?>

    <?php if (!empty($messageErr)): ?>
        <div class="msg bad"><p><?= htmlspecialchars($messageErr) ?></p></div>
    <?php endif; ?>

    <table class="users-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $u): ?>
                <?php
                    $isAdmin = ($u['admin'] === '1');
                    $isSelf  = ($u['user'] === $currentUser);
                    $disabled = ($isAdmin || $isSelf);
                ?>
                <tr>
                    <td><?= htmlspecialchars($u['user']) ?></td>
                    <td><?= htmlspecialchars($u['nombre']) ?></td>
                    <td><?= htmlspecialchars($u['apellido']) ?></td>
                    <td><?= htmlspecialchars($u['correo']) ?></td>
                    <td>
                        <?php if ($isAdmin): ?>
                            <span class="role-admin">ADMIN</span>
                        <?php else: ?>
                            <span class="role-user">USER</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="post"
                              action="index.php?page=admin"
                              onsubmit="return confirm('Delete user <?= htmlspecialchars($u['user']) ?>?');">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                            <input type="hidden" name="delete_user" value="<?= htmlspecialchars($u['user']) ?>">
                            <button class="deleteBtn" type="submit" <?= $disabled ? 'disabled' : '' ?>>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>