<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cinema</title>
    <link rel="stylesheet" href="assets/css/reset.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="halls">
    <div class="halls__content halls__content_margin position">
        <? foreach ($halls as $key => $hall): ?>
            <div class="hall" data-hall="<?= $hall['id'] ?>">
                <p class="message_<?= $hall['id'] ?>"></p>
                <p>Зал №<?= $hall['id'] ?></p>
                <? if ($place_available[$key] != '0'): ?>
                    <p class="count-place_<?= $hall['id'] ?>">Количество свободных мест:</p><p
                            class="available_<?= $hall['id'] ?>"><?= $place_available[$key] ?></p>
                <? else: ?>
                    <p>Свободных мест нет!</p>
                <? endif; ?>
                <div class="hall__places">
                    <? for ($i = 0; $i < $hall['count_place']; $i++): ?>
                        <img class="hall__place" src="assets/img/svg/chair_<?= $hall['hall'][$i]['status'] ?>.svg"

                             alt="<?= $i ?>" data-id="<?= $hall['id'] ?>" data-status="<?= $hall['hall'][$i]['status'] ?>">
                    <? endfor; ?>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>
<script src="assets/js/main.js"></script>
</body>
</html>