<div class="product container-fluid mt-5">
    <h1 class="font-weight-bold"><?= $vars['product']['name'] ?></h1>
    <div class="d-flex">
        <img width="300" style="border-radius: 50px;" src="/app/public/img/films/<?= $vars['product']['img'] ?>"
             alt="<?= $vars['product']['name'] ?>">
        <div class="ml-2">
            <p><strong>Описание: </strong></p>
            <p><?= $vars['product']['description'] ?></p>
            <?php if (isset($_SESSION['user'])): ?>
                <div class="product__schedule mb-2">
                    <p>Выберите время сеанса: </p>
                    <?php foreach ($vars['schedule'] as $key => $time): ?>
                        <button class="btn btn-outline-dark time" style="border-radius: 0"
                                data-id="<?= $time['id'] ?>"><?= $time['time'] ?></button>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-danger">Вы должны автоторизироваться для покупки билета</p>
            <?php endif; ?>
            <button id="filmBuy" type="button" class="btn btn-outline-dark cursor-not-allows" disabled
                    data-films-id="<?= $vars['product']['id'] ?>" data-toggle="modal" data-target="#exampleModal">
                Купить билет
            </button>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <p>К оплате: <span id="total-price" class="dataset">0</span><span> грн</span></p>
                    <button id="button_buy" type="button"
                            class="dataset btn btn-outline-dark cursor-not-allows buyPlace" disabled>Купить
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/app/public/js/product.js"></script>