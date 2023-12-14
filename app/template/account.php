<div class="account container-fluid">
    <div class="row container mt-5">
        <h2 class="font-weight-bold">Личный кабинет пользователя <?= $vars['account']['login'] ?></h2>
    </div>
    <hr>
    <div class="history">
        <h3>История покупок</h3>
        <table class="container-fluid p-0">
            <th>Фильм</th>
            <th>Изображение</th>
            <th>Время</th>
            <th>Зал</th>
            <th>Места</th>
            <th>Дата</th>
            <th>Цена</th>
            <?php foreach ($vars['history'] as $key => $item): ?>
                <tr>
                    <td>
                        <a href="/product/<?= $item['url'] ?>"><?= $item['name'] ?></a>
                    </td>
                    <td>
                        <a href="/product/<?= $item['url'] ?>">
                            <img width="100" src="/app/public/img/films/<?= $item['img'] ?>"
                                 alt="film <?= $item['name'] ?>">
                        </a>
                    </td>
                    <td><?= $item['time'] ?></td>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['place'] ?></td>
                    <td><?= $item['date'] ?></td>
                    <td><?= $item['price'] ?> грн.</td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<script src="/app/public/js/account.js"></script>