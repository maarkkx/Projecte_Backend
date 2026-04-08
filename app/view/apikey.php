<div class="apiKeyPage">
    <?php if (!empty($message)): ?>
        <div class="msg ok"><p><?= htmlspecialchars($message) ?></p></div>
    <?php endif; ?>

    <?php if (!empty($messageErr)): ?>
        <div class="msg bad"><p><?= htmlspecialchars($messageErr) ?></p></div>
    <?php endif; ?>

    <form method="post" action="index.php?page=apikey" class="apiKeyForm">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
        <button type="submit" name="generate_api_key" class="generateApiKeyBtn">
            Generate API Key
        </button>
    </form>

    <?php if (!empty($_SESSION['generated_api_key_once'])): ?>
        <div class="apiKeyResult">
            <p><strong>Your API key</strong></p>
            <input type="text" readonly value="<?= htmlspecialchars($_SESSION['generated_api_key_once']) ?>">
            <p class="hint">Cópiala ahora. Solo se muestra una vez.</p>
        </div>
        <?php unset($_SESSION['generated_api_key_once']); ?>
    <?php endif; ?>
</div>