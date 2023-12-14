<div class="catalog font-family">
    <div class="catalog__content position">
        <h2>Скоро на экранах</h2>
        <div class="catalog__items">
            <?php foreach ($vars['catalog'] as $key => $item) : ?>
                <a href="/product/<?= $item['url'] ?>" class="catalog__item">
                    <img src="/app/public/img/films/<?= $item['img'] ?>">
                    <p><?= $item['name'] ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>