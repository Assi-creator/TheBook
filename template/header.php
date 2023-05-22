<script src="/assets/libs/jquery-3.6.4.min.js"></script>
<script src="/assets/libs/swiper/swiper.min.js"></script>
<script defer src="/assets/js/header.js"></script>
<script src="/assets/js/profile.js" defer></script>

<header class="page-header">
    <div class="page-header__wrapper">
        <a class="page-header__logo" href="/">
            <img alt="The Book" src="/assets/images/root/icons/logo-promo.PNG" style="width: 200px !important; height: 55px !important;">
        </a>
        <div class="page-header__search">
          <span style="display: inline-block; width: 100%" tabindex="1">
            <form autocomplete="off" method="POST">
              <div class="page-header__search-form" style="z-index: 10006 !important;">
                <input class="page-header__search-input" name="search" placeholder="Поиск книги или автора" type="text" value="">
                <button class="page-header__search-button" type="submit">Найти</button>
              </div>
            </form>
              <div id="search-res-block" class="ll-block-hide" style="display: none">
                  <div id="search-res">
                      <div class="search-res-objects">
                          <ul class="search-res-object__list">
                          </ul>
                      </div>
                      <div class="search-res__show-all">
                          <a class="see-all">
                              Показать все результаты
                          </a>
                      </div>
                  </div>
              </div>
          </span>
        </div>

        <?php if (isset($_SESSION['user'])) : ?>
            <details class="user-nav ll-details-closed">
                <summary class="user-nav__toggle" title="Меню">
                    <img alt="<?php echo $_SESSION['user']['login']; ?>"
                         src="<?php echo $_SESSION['user']['avatar_path']; ?>" width="100%" height="100%">
                </summary>
                <ul class="user-nav__list">
                    <li class="user-nav__item">
                        <a class="user-nav__login" href="/views/reader">
                            <img alt="<?php echo $_SESSION['user']['login']; ?>"
                                 src="<?php echo $_SESSION['user']['avatar_path']; ?>" width="100%" height="100%">
                            <p><?php echo $_SESSION['user']['login']; ?></p>
                        </a>
                    </li>
                    <li class="user-nav__item">
                        <details open="">
                            <summary>
                                <a href="/views/reader/mybook/">Мои книги</a>
                            </summary>
                            <div>
                                <a href="/views/reader/wish/">Хочу прочитать</a>
                                <a href="/views/reader/reading/">Читаю сейчас</a>
                                <a href="/views/reader/read/"><?php if ($_SESSION['user']['gender'] == 'ж') {echo 'Прочитала';} else {echo 'Прочитал';} ?></a>
                            </div>
                        </details>
                    </li>
                    <li class="user-nav__item"><a href="/views/reader/reviews/">Рецензии</a></li>
                    <li class="user-nav__item"><a class="logout">Выйти</a></li>
                </ul>
            </details>
        <?php else: ?>
            <button class="page-header__login">Войти</button>
        <?php endif; ?>
    </div>

    <div id="tinyalert">
        <?php if(isset($_SESSION['tmp_alert'])){
            echo $_SESSION['tmp_alert'];
            unset($_SESSION['tmp_alert']);
        } ?>
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
                             src="<?php echo $_SESSION['user']['avatar_path']; ?>" width="100%" height="100%">
                    </summary>
                    <ul class="user-nav__list" data-simplebar="init">
                        <li class="user-nav__item">
                            <a class="user-nav__login"
                               href="/views/reader">
                                <img alt="<?php echo $_SESSION['user']['login']; ?>"
                                     src="<?php echo $_SESSION['user']['avatar_path']; ?>" width="100%" height="100%">
                                <p><?php echo $_SESSION['user']['login']; ?></p>
                            </a>
                        </li>
                        <li class="user-nav__item">
                            <details open="">
                                <summary>
                                    <a href="/views/reader/mybook/">Мои книги</a>
                                </summary>
                                <div>
                                    <a href="/views/reader/wish/">Хочу прочитать</a>
                                    <a href="/views/reader/reading/">Читаю сейчас</a>
                                    <a href="/views/reader/read/"><?php if ($_SESSION['user']['gender'] == 'ж') {echo 'Прочитала';} else {echo 'Прочитал';} ?></a>
                                </div>
                            </details>
                        </li>
                        <li class="user-nav__item"><a href="/views/reader/reviews/">Рецензии</a></li>
                        <li class="user-nav__item"><a class="logout">Выйти</a></li>
                    </ul>
                </details>
            <?php else: ?>
                <button class="page-header__login" style="margin: auto 0;">Войти</button>
            <?php endif; ?>
        </div>
        <div class="page-header__search-mob">
          <span style=" display: inline-block; width: 100%" tabindex="1">
            <form autocomplete="off" method="POST">
              <div class="page-header__search-form">
                <input class="page-header__search-input" name="search" placeholder="Поиск книги" type="text" value="">
                <button class="page-header__search-button" type="button">Найти</button>
              </div>
            </form>
              <div id="search-res-block" class="ll-block-hide" style="display: none">
                  <div id="search-res">
                      <div class="search-res-objects">
                          <ul class="search-res-object__list">
                          </ul>
                      </div>
                      <div class="search-res__show-all">
                          <a href="" onclick="location.href='/views/find?Тут текст c инпута'">
                              Показать все результаты
                          </a>
                      </div>
                  </div>
              </div>
          </span>
        </div>
    </div>

    <nav style="height: inherit;
                display: flex;
                align-items: center;
                max-width: 1200px;
                box-sizing: border-box;
                margin: 0 auto;">
        <ul class="main-menu">
            <li><a href="/">Главная</a></li>
            <li><a href="/views/genres/">Жанры</a></li>
            <li><a href="/views/review/">Рецензии</a></li>
        </ul>
    </nav>
</header>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/headerpopup.php"; ?>
