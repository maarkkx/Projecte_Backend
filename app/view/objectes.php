<div class="articles-container">
    <form method="get" action="index.php" class="articles-filter">
        <label for="per_page">Articles per pàgina:</label>
        <select name="per_page" id="per_page" onchange="this.form.submit()">
            <?php foreach ([1, 5, 10, 15, 20] as $val): ?>
                <option value="<?= $val ?>" <?= $perPage == $val ? 'selected' : '' ?>><?= $val ?></option>
            <?php endforeach; ?>
        </select>

        <label for="sort">Ordenar:</label>
        <select name="sort" id="sort" onchange="this.form.submit()">
            <option value="date_desc"  <?= $sortOpt === 'date_desc'  ? 'selected' : '' ?>>Més nous primer (data)</option>
            <option value="date_asc"   <?= $sortOpt === 'date_asc'   ? 'selected' : '' ?>>Més antics primer (data)</option>
            <option value="title_asc"  <?= $sortOpt === 'title_asc'  ? 'selected' : '' ?>>Títol A → Z</option>
            <option value="title_desc" <?= $sortOpt === 'title_desc' ? 'selected' : '' ?>>Títol Z → A</option>
        </select>

        <input type="hidden" name="page" value="objectes">
        <input type="hidden" name="num" value="1">

        <a class="crbtn" href="index.php?page=crear">
            <button class="createBtn" type="button">Create Object</button>
        </a>
    </form>

    <input type="text" id="searchInput" placeholder="Buscar objecte..." style="border-radius: 5px; width: 200px; height: 30px;">
    <script src="resources/js/objectes.js"></script>
    <h3>Llista d'articles:</h3>

    <?php if (!empty($articles)): ?>
        <ul class="articles-list">
            <?php foreach ($articles as $art): 
                $objName = strtolower(str_replace(' ', '-', htmlspecialchars($art['titol'])));
                $imgUrl  = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/{$objName}.png";
            ?>
            <li>
                <strong><?= htmlspecialchars($art['titol']) ?></strong><br>
                <span class="article-user">Usuari: <?= htmlspecialchars($art['user']) ?></span><br>
                <span class="article-body"><?= htmlspecialchars($art['cos']) ?></span>
                
                <?php if (!empty($art['created_at'])): ?>
                    <span class="article-date">
                        <br>Data: <?= date('d/m/Y H:i', strtotime($art['created_at'])) ?>
                    </span><br>
                <?php endif; ?>

                <img class="objImg" src="<?= $imgUrl ?>" alt="<?= $objName ?>">

                <?php if ($isLogged): ?>
                    <a class="btn-edit" href="index.php?page=editar&id=<?= $art['id'] ?>">
                        <img class="edit" src="resources/images/edit.png" alt="Edit Image">
                    </a>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No s'han trobat articles.</p>
    <?php endif; ?>

    <div class="pagination">
        <?php if ($pageNum > 1): ?>
            <a class="page-btn" href="index.php?<?= http_build_query(array_merge($baseParams, ['num' => 1])) ?>">Primera</a>
            <a class="page-btn" href="index.php?<?= http_build_query(array_merge($baseParams, ['num' => $pageNum - 1])) ?>">Anterior</a>
        <?php else: ?>
            <span class="page-btn disabled">Primera</span>
            <span class="page-btn disabled">Anterior</span>
        <?php endif; ?>

        <?php for ($i = $start; $i <= $end; $i++): ?>
            <?php if ($i == $pageNum): ?>
                <span class="page-btn current-page"><?= $i ?></span>
            <?php else: ?>
                <a class="page-btn" href="index.php?<?= http_build_query(array_merge($baseParams, ['num' => $i])) ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($pageNum < $totalPages): ?>
            <a class="page-btn" href="index.php?<?= http_build_query(array_merge($baseParams, ['num' => $pageNum + 1])) ?>">Següent</a>
            <a class="page-btn" href="index.php?<?= http_build_query(array_merge($baseParams, ['num' => $totalPages])) ?>">Última</a>
        <?php else: ?>
            <span class="page-btn disabled">Següent</span>
            <span class="page-btn disabled">Última</span>
        <?php endif; ?>
    </div>
</div>