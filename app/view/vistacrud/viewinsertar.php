<div>
    <form method="POST" action="index.php?page=crear">
        <h1>Create Object</h1><br>
        <input placeholder="Object Name" type="text" class="inputs" id="titol" name="titol"><br><br>
        <textarea name="cos" id="cos" class="cos" placeholder="Item Description"></textarea><br><br>

        <input type="submit" class="create" name="create" id="create" value="Create">
        <button class="return" onclick="window.location.href='index.php'">Return</button>

        <?php if (!empty($msgObj)): ?>
            <div class="msg"><br><p><?= $msgObj ?></p></div>
        <?php endif; ?>
    </form>
</div>