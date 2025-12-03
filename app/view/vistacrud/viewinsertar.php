<div>
    <form method="POST" action="index.php?page=crear">
        <h1 class="h1Create">Create Object</h1><br>
        <label>
            Title <br>
            <input placeholder="Object Name" type="text" class="inputs" id="titol" name="titol"><br><br>
        </label>

        <label>
            Description <br>
            <textarea name="cos" id="cos" class="cos" placeholder="Item Description"></textarea><br><br>
        </label>

        <input type="submit" class="create" name="create" id="create" value="Create">
        <button class="return" onclick="window.location.href='index.php'">Return</button>

        <?php if (!empty($msgObj)): ?>
            <div class="msg"><br><p><?= $msgObj ?></p></div>
        <?php endif; ?>
    </form>
</div>