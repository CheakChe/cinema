<div class="hall-places container-fluid">
    <div class="row">
        <p class="m-auto">
            <span>Количество оставшихся  мест: </span>
            <span id="count-place" class="dataset" data-count-place="<?=$vars['count_free']?>"><?=$vars['count_free']?></span>
        </p>
    </div>
    <div class="row places m-auto  justify-content-center">
        <?php foreach ($vars['hall'] as $key => $item): ?>
            <?php if (isset($item['select'])): ?>
                <button class="place dataset" data-status="1" data-number="<?=$key?>"><img width="20" src="/app/public/img/svg/chair_busy.svg" alt="chair busy"></button>
            <?php else: ?>
                <button class="place dataset" data-status="0" data-number="<?=$key?>"><img width="20" src="/app/public/img/svg/chair_free.svg" alt="chair free"></button>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
