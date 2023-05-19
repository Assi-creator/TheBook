<div class="popup__modal">
    <form class="popup__regForm">
        <div class="popup__wrapper">
            <a class="popup__btn-close"></a>
            <div class="popup__logo">
                <img alt="The Book" src="/assets/images/root/icons/logo-promo.PNG" style="width: 240px !important; height: 70px !important;">
            </div>
            <hr>
            <div class="popup__title">
                <h1>Войти</h1>
                <a>Забыли пароль?</a>
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
            <div class="popup__space">
                <p class="popup__reg-error"></p>
            </div>
            <button class="popup__btn-login" name="log">Войти</button>
            <p class="popup__new-p">Новая учетная запись</p>
            <a class="popup__btn-newAccount" onclick="document.location='../../views/registration/'">Создать учетную запись</a>
            <p class="popup__submit">Продолжая, вы соглашаетесь с <a href="#">политикой обработки персональных
                    данных</a></p>
        </div>
    </form>

    <form class="popup__forgotPass">
        <div class="popup__wrapper">
            <a class="popup__btn-back"></a>
            <div class="popup__logo">
                <img alt="The Book" src="/assets/images/root/icons/logo-promo.PNG" style="width: 240px !important; height: 70px !important;">
            </div>
            <hr>
            <div class="popup__title-forgot">
                <h1>Сбросить пароль</h1>
                <p class="popup__forgot">Если вы забыли пароль, вы можете поменять его.</p>
            </div>
            <div class="popup__input">
                    <input maxlength="12" class="popup__login" style="margin-top: 5px" name="forgot-user" placeholder="Введите логин или номер карточки" type="text">
                    <input class="popup__email" style="margin-top: 10px;" name="forgot" placeholder="Введите зарегистрированный e-mail" type="text">
            </div>
            <div class="popup__space">
                <p class="popup__reg-email-error"></p>
            </div>
            <button class="popup__send-code" name="forgot">Отправить</button>
        </div>
    </form>
</div>
