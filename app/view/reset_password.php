<div class="form-container">
    <h2>Restablir Contrasenya</h2>
    <p>Escriu la teva nova contrasenya a continuació.</p>

    <?php if (!empty($message)): ?>
        <p style="color: #28a745; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
        <p><a href="index.php?page=login" class="btn-submit" style="text-decoration:none;">Anar al Login</a></p>
    <?php endif; ?>
    
    <?php if (!empty($messageErr)): ?>
        <p style="color: #dc3545; font-weight: bold;"><?= htmlspecialchars($messageErr) ?></p>
    <?php endif; ?>

    <?php if (empty($message)): ?>
    <form action="index.php?page=reset_password&token=<?= htmlspecialchars($_GET['token'] ?? '') ?>" method="POST">
        
        <div class="input-group">
            <label for="new_password">Nova contrasenya</label>
            <input type="password" id="new_password" name="new_password" placeholder="nova contrasenya" required>
        </div>

        <div class="input-group">
            <label for="repeat_password">Repeteix la contrasenya</label>
            <input type="password" id="repeat_password" name="repeat_password" placeholder="Repeteix la contrasenya" required>
        </div>
        
        <div class="button-group">
            <button type="submit" name="submitReset" class="btn-submit">Guardar Contrasenya</button>
        </div>

    </form>
    <?php endif; ?>
</div>