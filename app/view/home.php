<h1 class="titleIndex">Pokémon Objects</h1>

<section class="home-articles">
    <?php if (!empty($featuredArticles)): ?>
        <?php foreach ($featuredArticles as $art): ?>
            <article class="article-card">
                <img class="image" src="<?= $art['url_foto'] ?>" alt="<?= htmlspecialchars($art['titol']) ?>">
                
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
    <a title="Create a Object" href="index.php?page=crear" class="crearObj">Create Object</a>
</div>