
<header class="page-header">
    <div class="page-header__wrapper">
        <a class="page-header__logo" href="/index.php">
            <img alt="The Book" height="55" src="/assets/images/logo-promo.PNG" width="200">
        </a>
        <div class="page-header__search">
          <span style="display: inline-block; width: 100%" tabindex="1">
            <form autocomplete="off" method="POST">
              <div class="page-header__search-form">
                <input class="page-header__search-input" placeholder="Поиск книги" type="text" value="">
                <button class="page-header__search-button" type="submit">Найти</button>
              </div>
            </form>
          </span>
        </div>
        <button class="page-header__login" onclick="showRegForm()">Войти</button>
    </div>

    <div class="page-header__wrapper-mob">
        <div class="page-header__mob">
            <a class="page-header__logo-mob" href="#">
                <img alt="The Book" height="55" src="/assets/images/logo-promo.PNG" width="200">
            </a>
            <button class="page-header__login-mob" onclick="showRegForm()">Войти</button>
        </div>
        <div class="page-header__search-mob">
          <span style="display: inline-block; width: 100%" tabindex="1">
            <form autocomplete="off" method="POST">
              <div class="page-header__search-form">
                <input class="page-header__search-input" placeholder="Поиск книги" type="text" value="">
                <button class="page-header__search-button" type="submit">Найти</button>
              </div>
            </form>
          </span>
        </div>
    </div>

    <nav>
        <ul class="main-menu">
            <li><a href="/index.php">Главная</a></li>
            <li><a href="./views/reader/">Жанры</a></li>
            <li><a href="#">Авторы</a></li>
        </ul>
    </nav>
</header>

<div class="popup__modal">
    <form class="popup__regForm" method="POST" action="/api/controller/user/user.php">
        <div class="popup__wrapper">
            <a class="popup__btn-close" onclick="closeRegForm()"></a>
            <div class="popup__logo">
                <img alt="The Book" height="70" src="/assets/images/logo-promo.PNG" width="240">
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
                <img alt="The Book" height="70" src="/assets/images/logo-promo.PNG" width="240">
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
