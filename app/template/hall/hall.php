<div class="halls">
    <div class="halls__content halls__content_margin position">
        <? foreach ($var['halls'] as $key => $hall): ?>
            <div class="hall" data-hall="<?= $hall['id'] ?>">
                <p class="message_<?= $hall['id'] ?>"></p>
                <p>Зал №<?= $hall['id'] ?></p>
                <? if ($var['place_available'][$key] != '0'): ?>
                    <p class="count-place_<?= $hall['id'] ?>">Количество свободных мест:</p><p
                            class="available_<?= $hall['id'] ?>"><?= $var['place_available'][$key] ?></p>
                <? else: ?>
                    <p>Свободных мест нет!</p>
                <? endif; ?>
                <div class="hall__places">
                    <? for ($i = 0; $i < $hall['count_place']; $i++): ?>
                        <img class="hall__place" src="app/public/img/svg/chair_<?= $hall['hall'][$i]['status'] ?>.svg"

                             alt="<?= $i ?>" data-id="<?= $hall['id'] ?>"
                             data-status="<?= $hall['hall'][$i]['status'] ?>">
                    <? endfor; ?>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>