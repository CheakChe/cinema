<?= $vars['header'] ?>
<main <?=($_SERVER['REQUEST_URI'] !=='/')?'class="pt"': ''?>>
    <?= $vars['content'] ?>
</main>
<?= $vars['footer'] ?>
