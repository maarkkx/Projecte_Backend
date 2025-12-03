<h1 class="titleIndex">Pokémon Objects</h1>
<section class="home-articles">
    <?php if (!empty($featuredArticles)): ?>
        <?php foreach ($featuredArticles as $art): ?>
            <?php
                $objName = strtolower(str_replace(' ', '-', htmlspecialchars($art['titol'])));
                $link = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/" . $objName . ".png";  
            ?>
            <article class="article-card">
                <?php?>
                <img class="image" src="<?php echo $link?>" alt="<?php echo $objName?>">
                <h2><?= htmlspecialchars($art['titol']) ?></h2>
                <p>
                    <?= nl2br(htmlspecialchars(mb_strimwidth($art['cos'], 0, 120, '...'))) ?>
                </p>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hi ha articles disponibles encara.</p>
    <?php endif; ?>
</section>

<div class="home-create">
    <a title="Create Object" href="index.php?page=crear" class="crearObj">Create Object</a>
</div>