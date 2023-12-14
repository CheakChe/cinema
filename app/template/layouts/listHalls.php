<div class="halls list d-flex">
    <?php foreach ($vars['halls'] as $key => $hall): ?>
        <div class="item m-1">
            <button class="btn btn-outline-dark hall">
                <span>Зал </span>
                <span id="hall-price-<?= $hall['hall'] ?>" class="dataset"  data-price="<?=$hall['price']?>"><?= $hall['hall'] ?></span>
            </button>
        </div>
    <?php endforeach; ?>
</div>