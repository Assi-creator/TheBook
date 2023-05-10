<script src="/assets/libs/jquery-3.6.4.min.js"></script>
<script defer src="/assets/js/header.js"></script>

<header class="page-header">
    <div class="page-header__wrapper">
        <a class="page-header__logo" href="/">
            <img alt="The Book" src="/assets/images/root/icons/logo-promo.PNG" style="width: 200px !important; height: 55px !important;">
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

        <?php if (isset($_SESSION['user'])) : ?>
            <details class="user-nav ll-details-closed">
                <summary class="user-nav__toggle" title="Меню">
                    <img alt="<?php echo $_SESSION['user']['login']; ?>"
                         src="<?php if (isset($_SESSION['user']['avatar_path'])) {
                             echo $_SESSION['user']['avatar_path'];
                         } else {
                             echo '/assets/images/noavatar.svg';
                         } ?>" width="100%" height="100%">
                </summary>
                <ul class="user-nav__list" data-simplebar="init">
                    <div class="simplebar-wrapper" style="margin: -14px 0;">
                        <div class="simplebar-mask">
                            <div class="simplebar-offset" style="right: 0; bottom: 0;">
                                <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden;">
                                    <div class="simplebar-content" style="padding: 14px 0;">
                                        <li class="user-nav__item">
                                            <a class="user-nav__login" href="/views/reader">
                                                <img alt="<?php echo $_SESSION['user']['login']; ?>"
                                                     src="<?php if (isset($_SESSION['user']['avatar_path'])) {
                                                         echo $_SESSION['user']['avatar_path'];
                                                     } else {
                                                         echo '/assets/images/noavatar.svg';
                                                     } ?>" width="100%"
                                                     height="100%">
                                                <p><?php echo $_SESSION['user']['login']; ?></p>
                                            </a>
                                        </li>
                                        <li class="user-nav__item">
                                            <details>
                                                <summary>
                                                    <a href="/../views/reader/mybook/">Мои книги</a>
                                                </summary>
                                                <div>
                                                    <a href="/../views/reader/wish/">Хочу прочитать</a>
                                                    <a href="/../views/reader/reading/">Читаю сейчас</a>
                                                    <a href="/../views/reader/read/">Прочитала</a>
                                                </div>
                                            </details>
                                        </li>
                                        <li class="user-nav__item"><a href="/api/controller/user/user.php">Выйти</a>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </ul>
            </details>
        <?php else: ?>
            <button class="page-header__login">Войти</button>
        <?php endif; ?>
    </div>

    <div class="page-header__wrapper-mob">
        <div class="page-header__mob">
            <a class="page-header__logo-mob" href="/">
                <img alt="The Book" src="/assets/images/root/icons/logo-promo.PNG" style="width: 200px !important; height: 55px !important;">
            </a>
            <?php if (isset($_SESSION['user'])) : ?>
                <details class="user-nav ll-details-closed">
                    <summary class="user-nav__toggle" title="Меню">
                        <img alt="<?php echo $_SESSION['user']['login']; ?>"
                             src="<?php if (isset($_SESSION['user']['avatar_path'])) {
                                 echo $_SESSION['user']['avatar_path'];
                             } else {
                                 echo '/assets/images/noavatar.svg';
                             } ?>" width="100%" height="100%">
                    </summary>
                    <ul class="user-nav__list" data-simplebar="init">
                        <div class="simplebar-wrapper" style="margin: -14px 0;">
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0; bottom: 0;">
                                    <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden;">
                                        <div class="simplebar-content" style="padding: 14px 0;">
                                            <li class="user-nav__item">
                                                <a class="user-nav__login"
                                                   href="/views/reader">
                                                    <img alt="<?php echo $_SESSION['user']['login']; ?>"
                                                         src="<?php echo $_SESSION['user']['avatar_path']; ?>"
                                                         width="100%" height="100%">
                                                    <p><?php echo $_SESSION['user']['login']; ?></p>
                                                </a>
                                            </li>
                                            <li class="user-nav__item">
                                                <details>
                                                    <summary>
                                                        <a href="/../views/reader/mybook/">Мои книги</a>
                                                    </summary>
                                                    <div>
                                                        <a href="/../views/reader/wish/">Хочу прочитать</a>
                                                        <a href="/../views/reader/reading/">Читаю сейчас</a>
                                                        <a href="/../views/reader/read/">Прочитала</a>
                                                    </div>
                                                </details>
                                            </li>
                                            <li class="user-nav__item"><a href="/api/controller/session/session.php">Выйти</a>
                                            </li>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>
                </details>
            <?php else: ?>
                <button class="page-header__login">Войти</button>
            <?php endif; ?>
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
            <li><a href="/">Главная</a></li>
            <li><a href="/../views/genres/">Жанры</a></li>
            <li><a href="/">Авторы</a></li>
        </ul>
    </nav>
</header>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/headerpopup.php"; ?>
