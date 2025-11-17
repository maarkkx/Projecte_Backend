<?php
require_once __DIR__ . '/../controller/ControllerObj.php';
session_start();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Objectes</title>
    <link rel="stylesheet" href="../../resources/css/style.css"/>
</head>
<body>
    <nav class="navObj">
        <div class="navContainer">
            <ul class="navUl">
                <li><a class="first" href="../../index.php">Inici</a></li>
                <li><a href="objectes.php">Objectes</a></li>
            </ul>
            
            <ul class="navUl">
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="user-menu">
                        <span class="user-menu-name">
                            <?= htmlspecialchars($_SESSION['user']) ?>
                        </span>
                        <ul class="user-dropdown">
                            <li><a href="app/view/logout.php">Log Out</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a class="last" href="app/view/login.php">Log In</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Igual que login: caja blanca centrada -->
    <main class="mainObj">
        <div class="articles-container">
            <form method="get" action="" class="articles-filter">
                <label for="per_page">Articles per pàgina:</label>
                <select name="per_page" id="per_page" onchange="this.form.submit()">
                    <option value="1"  <?= $perPage==1?'selected':'' ?>>1</option>
                    <option value="5"  <?= $perPage==5?'selected':'' ?>>5</option>
                    <option value="10" <?= $perPage==10?'selected':'' ?>>10</option>
                    <option value="15" <?= $perPage==15?'selected':'' ?>>15</option>
                    <option value="20" <?= $perPage==20?'selected':'' ?>>20</option>
                </select>
                <input type="hidden" name="page" value="1">
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
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        <!-- Paginació -->
        <div class="pagination">
            <!-- Primera / Anterior -->
            <?php if ($page > 1): ?>
                <a class="page-btn" href="?page=1&per_page=<?= $perPage ?>">Primera</a>
                <a class="page-btn" href="?page=<?= $page - 1 ?>&per_page=<?= $perPage ?>">Anterior</a>
            <?php else: ?>
                <span class="page-btn disabled">Primera</span>
                <span class="page-btn disabled">Anterior</span>
            <?php endif; ?>

            <?php
                // Máximo de números visibles
                $maxNumbers = 3;

                if ($totalPages <= 10) {
                    // Pocas páginas: las mostramos todas
                    $start = 1;
                    $end   = $totalPages;
                } else {
                    // Muchas páginas: ventana alrededor de la actual
                    $start = max(1, $page - 1);
                    $end   = min($totalPages, $page + 1);

                    if ($start == 1) {
                        $end = min($start + $maxNumbers - 1, $totalPages);
                    }
                    if ($end == $totalPages) {
                        $start = max(1, $end - $maxNumbers + 1);
                    }
                }

                for ($i = $start; $i <= $end; $i++):
            ?>
                <?php if ($i == $page): ?>
                    <!-- Página actual -->
                    <span class="page-btn current-page"><?= $i ?></span>
                <?php else: ?>
                    <a class="page-btn" href="?page=<?= $i ?>&per_page=<?= $perPage ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <!-- Següent / Última -->
            <?php if ($page < $totalPages): ?>
                <a class="page-btn" href="?page=<?= $page + 1 ?>&per_page=<?= $perPage ?>">Següent</a>
                <a class="page-btn" href="?page=<?= $totalPages ?>&per_page=<?= $perPage ?>">Última</a>
            <?php else: ?>
                <span class="page-btn disabled">Següent</span>
                <span class="page-btn disabled">Última</span>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>