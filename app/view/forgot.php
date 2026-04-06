<div class="form-container">
    <h2>Recuperar Contrasenya</h2>
    <p>Introdueix el teu correu electrònic i t'enviarem un enllaç per restablir la teva contrasenya.</p>

    <?php if (!empty($message)): ?>
        <p style="color: #28a745; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    
    <?php if (!empty($messageErr)): ?>
        <p style="color: #dc3545; font-weight: bold;"><?= htmlspecialchars($messageErr) ?></p>
    <?php endif; ?>

    <form action="index.php?page=forgot" method="POST">
        
        <div class="input-group">
            <label for="email">Correu electrònic</label>
            <input type="email" id="email" name="email" placeholder="El teu email..." required>
        </div>
        
        <div class="button-group">
            <button type="submit" name="requestReset" class="btn-submit">Enviar</button>
            <a href="index.php?page=login" class="btn-return">Return</a>
        </div>

    </form>
</div>