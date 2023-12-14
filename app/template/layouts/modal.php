<div class="modal form">
    <form name="Phone" method="POST" onsubmit="return false;">
        <p></p>
        <div class="modal__second-name">
            <label for="second-name">Фамилия</label>
            <input type="text" required name="second-name" minlength="3" id="second-name" placeholder="Фамилия">
        </div>
        <div class="modal__phone-number">
            <label for="phone-number">Номер телефона</label>
            <input type="text" required name="phone-number" id="phone-number" minlength="12"
                   placeholder="Номер телефона">
        </div>
        <input type="hidden" name="id" id="id">
        <button type="submit">Сохранить</button>
        <button type="button" class="modal__close"><img src="/app/public/img/svg/close.svg" alt="close"></button>
    </form>
</div>
<div class="modal message">
    <div>
        <p></p>
        <button class="modal__close">Принять</button>
    </div>
</div>