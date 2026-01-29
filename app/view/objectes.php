<div class="articles-container">
    <form method="get" action="index.php" class="articles-filter">
        <label for="per_page">Articles per pàgina:</label>
        <select name="per_page" id="per_page" onchange="this.form.submit()">
            <option value="1"  <?= $perPage==1?'selected':'' ?>>1</option>
            <option value="5"  <?= $perPage==5?'selected':'' ?>>5</option>
            <option value="10" <?= $perPage==10?'selected':'' ?>>10</option>
            <option value="15" <?= $perPage==15?'selected':'' ?>>15</option>
            <option value="20" <?= $perPage==20?'selected':'' ?>>20</option>
        </select>
        <label for="sort">Ordenar:</label>
        <select name="sort" id="sort" onchange="this.form.submit()">
            <option value="date_desc"  <?= ($sortOpt ?? 'date_desc')==='date_desc' ? 'selected' : '' ?>>Més nous primer (data)</option>
            <option value="date_asc"   <?= ($sortOpt ?? 'date_desc')==='date_asc'  ? 'selected' : '' ?>>Més antics primer (data)</option>
            <option value="title_asc"  <?= ($sortOpt ?? 'date_desc')==='title_asc' ? 'selected' : '' ?>>Títol A → Z</option>
            <option value="title_desc" <?= ($sortOpt ?? 'date_desc')==='title_desc'? 'selected' : '' ?>>Títol Z → A</option>
        </select>

        <!-- Para que el router sepa que estamos en la vista objectes -->
        <input type="hidden" name="page" value="objectes">
        <!-- Al cambiar elementos por página, volvemos a la página 1 -->
        <input type="hidden" name="num" value="1">

        <a class="crbtn" href="index.php?page=crear">
            <button class="createBtn" type="button">Create Object</button>
        </a>
    </form>

    <h3>Llista d'articles:</h3>

    <?php if (!empty($articles)): ?>
        <ul class="articles-list">
            <?php foreach ($articles as $art): ?>
            <li>
                <strong><?= htmlspecialchars($art['titol']) ?></strong><br>
                <span class="article-user">
                    Usuari: <?= htmlspecialchars($art['user']) ?>
                </span><br>
                <span class="article-body">
                    <?= htmlspecialchars($art['cos']) ?>
                </span>
                <?php if (!empty($art['created_at'])): ?>
                    <span class="article-date">
                        <br>Data: <?= htmlspecialchars(date('d/m/Y H:i', strtotime($art['created_at']))) ?>
                    </span><br>
                <?php endif; ?>
                <?php
                    $objName1 = strtolower(str_replace(' ', '-', htmlspecialchars($art['titol'])));
                    $link1 = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/" . $objName1 . ".png";  
                ?>
                <img class="objImg" src="<?php echo $link1?>" alt="<?php echo $objName1?>">
                <?php if (isset($_SESSION['user'])): ?>
                    <a class="btn-edit"
                    href="index.php?page=editar&id=<?= $art['id'] ?>">
                        <img class="edit" src="resources/images/edit.png" alt="Edit Image">
                    </a>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    
    <!--para que se mantengan los parametros al cambiar de pagina-->
    <?php
        $baseParams = [
            'page'     => 'objectes',
            'per_page' => $perPage,
            'sort'     => ($sortOpt ?? 'date_desc'),
        ];
    ?>
<!-- Paginació -->
<div class="pagination">
    <!-- Primera / Anterior -->
    <?php if ($pageNum > 1): ?>
        <a class="page-btn"
           href="index.php?<?= http_build_query(array_merge($baseParams, ['num' => 1])) ?>">
            Primera
        </a>

        <a class="page-btn"
           href="index.php?<?= http_build_query(array_merge($baseParams, ['num' => $pageNum - 1])) ?>">
            Anterior
        </a>
    <?php else: ?>
        <span class="page-btn disabled">Primera</span>
        <span class="page-btn disabled">Anterior</span>
    <?php endif; ?>

    <?php
    // Máximo de números visibles
    $maxNumbers = 3;

    if ($totalPages <= 10) {
        $start = 1;
        $end   = $totalPages;
    } else {
        $start = max(1, $pageNum - 1);
        $end   = min($totalPages, $pageNum + 1);

        if ($start == 1) {
            $end = min($start + $maxNumbers - 1, $totalPages);
        }
        if ($end == $totalPages) {
            $start = max(1, $end - $maxNumbers + 1);
        }
    }

    for ($i = $start; $i <= $end; $i++):
    ?>
        <?php if ($i == $pageNum): ?>
            <span class="page-btn current-page"><?= $i ?></span>
        <?php else: ?>
            <a class="page-btn"
               href="index.php?<?= http_build_query(array_merge($baseParams, ['num' => $i])) ?>">
                <?= $i ?>
            </a>
        <?php endif; ?>
    <?php endfor; ?>

    <!-- Següent / Última -->
    <?php if ($pageNum < $totalPages): ?>
        <a class="page-btn"
           href="index.php?<?= http_build_query(array_merge($baseParams, ['num' => $pageNum + 1])) ?>">
            Següent
        </a>

        <a class="page-btn"
           href="index.php?<?= http_build_query(array_merge($baseParams, ['num' => $totalPages])) ?>">
            Última
        </a>
    <?php else: ?>
        <span class="page-btn disabled">Següent</span>
        <span class="page-btn disabled">Última</span>
    <?php endif; ?>
</div>
</div>
