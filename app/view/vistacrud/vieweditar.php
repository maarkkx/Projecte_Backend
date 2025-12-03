<!--Si hay un error no se ve la vista, se ve el error-->
<?php if (isset($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if (!empty($article)): ?>
    <div class="editForm">
        <form method="post">
            <h1>Edit Article</h1><br>
            <label>
                Title
                <input type="text" name="titol" value="<?= htmlspecialchars($article['titol']) ?>">
            </label><br><br>

            <label>
                Description
                <textarea name="cos" rows="6"><?= htmlspecialchars($article['cos']) ?></textarea>
            </label><br><br>

            <div class="buttons">
                <button type="submit" class="save" name="save">Save</button>
                <button type="submit" class="delete" name="delete" onclick="return confirm('Segur que vols eliminar aquest article?');">Delete</button>
            </div>
        </form>
    </div>
<?php endif; ?>
