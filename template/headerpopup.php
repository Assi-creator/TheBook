<div class="popup__modal">
    <form class="popup__regForm" method="POST" action="/api/controller/user/user.php">
        <div class="popup__wrapper">
            <a class="popup__btn-close" onclick="closeRegForm()"></a>
            <div class="popup__logo">
                <img alt="The Book" src="/assets/images/logo-promo.PNG" style="width: 240px !important; height: 70px !important;">
            </div>
            <hr>
            <div class="popup__title">
                <h1>Войти</h1>
                <a onclick="showForgotPassForm()">Забыли пароль?</a>
            </div>
            <div class="popup__input">
                <label>
                    <input class="popup__login" name="login" placeholder="Введите логин" type="text">
                </label>
                <div class="popup__password-form">
                    <label for="popup__password-id"></label><input class="popup__password" id="popup__password-id"
                                                                   name="password" placeholder="Введите пароль"
                                                                   type="password">
                    <a class="popup__showHideButton" href="#" onclick="return showHidePassword(this);"></a>
                </div>
            </div>
            <span class="popup__reg-error"></span>
            <div class="popup__space"></div>
            <button class="popup__btn-login" name="log">Войти</button>
            <p class="popup__new-p">Новая учетная запись</p>
            <button class="popup__btn-newAccount">Создать учетную запись</button>
            <p class="popup__submit">Продолжая, вы соглашаетесь с <a href="#">политикой обработки персональных
                    данных</a></p>
        </div>
    </form>

    <form class="popup__forgotPass" method="POST" action="/api/controller/user/user.php">
        <div class="popup__wrapper">
            <a class="popup__btn-back" onclick="backToForm()"></a>
            <div class="popup__logo">
                <img alt="The Book" src="/assets/images/logo-promo.PNG" style="width: 240px !important; height: 70px !important;">
            </div>
            <hr>
            <div class="popup__title-forgot">
                <h1>Сбросить пароль</h1>
                <p class="popup__forgot">Если вы забыли пароль, вы можете поменять его.</p>
            </div>
            <div class="popup__input">
                <label>
                    <input class="popup__email" placeholder="Введите e-mail" type="text">
                </label>
            </div>
            <div class="popup__space"></div>
            <button class="popup__send-code" name="forgot">Отправить</button>
        </div>
    </form>
</div>
