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
        <p class="message"></p>
        <? foreach ($halls as $key => $hall): ?>
            <p>Зал №<?= $hall['id'] ?></p>
            <p>Количество свободных мест:</p><p class="available"><?= $place_available[$key] ?></p>
            <div class="hall">
                <? for ($i = 1; $i < $hall['count_place']; $i++): ?>
                    <img class="hall__place" src="assets/img/svg/chair_<?= $hall['hall'][$i]['status'] ?>.svg"

                         alt="<?= $i ?>" data-id="<?= $hall['id'] ?>" data-status="<?= $hall['hall'][$i]['status'] ?>">
                <? endfor; ?>
            </div>
        <? endforeach; ?>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>