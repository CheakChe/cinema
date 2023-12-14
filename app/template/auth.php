<div class="auth font-family">
    <div class="auth__content position">
        <p class="message text-center"></p>
        <div class="auth__enter text-center mt-5">
            <form method="POST" name="Enter">
                <input type="text" required name="login" placeholder="Логин" minlength="3">
                <input type="password" required name="password" placeholder="Пароль" minlength="6">
                <button class="btn btn-dark mb-5" type="submit" name="enter">Войти</button>
            </form>
        </div>
        <div class="auth__down">
            <div class="text-center">
                <button class="btn btn-dark registration">Зарегистрироваться</button>
            </div>
            <div class="auth__registration hidden mt-3">
                <form method="POST" name="Registration">
                    <input type="text" required name="login" placeholder="Логин" minlength="3">
                    <input type="number" required name="phone" placeholder="Номер" minlength="10">
                    <input type="password" required name="password" placeholder="Пароль" minlength="6">
                    <button class="btn btn-dark" type="submit" name="enter">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </div>
</div>