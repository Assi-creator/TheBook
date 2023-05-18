<section class="header">
<div class="header-context profile-context">
    <div class="header-container">
        <?php
            $url =  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $url = explode('/', $url);
        ?>
        <ul class="nav context">
            <li>
                <a href="/views/reader/">←</a>
            </li>
            <li <?php if ($url[3] == 'editprofile') {
                echo 'class="active"';
            } ?>>
                <a href="/views/account/editprofile/">Профиль</a>
            </li>
            <li <?php if ($url[3] == 'editemail' or $url[3] == 'editpassword' or $url[3] == 'lastvisits' or $url[3] == 'close') {
                echo 'class="active"';
            } ?> style="position: relative;">
                <div id="div-profileedit-account-dropdown" class="div-context-more ll-toggle-hide"
                     style="margin-top: 65px; left: 0; margin-left: 0; display: none">
                    <div class="div-context-shadow" onclick="hideAccountDetails()"></div>
                    <ul id="ul-context-more" class="share-menu share-menu-ul oneline">
                        <li class="personal"><a href="/views/account/editemail">
                                <?php if(!empty($_SESSION['user']['email'])){
                                    echo 'Изменить email';
                                } else {
                                    echo 'Добавить email';
                                } ?>
                            </a></li>
                        <li class="personal"><a href="/views/account/editpassword/">Изменить пароль</a></li>
                        <li class="personal"><a href="/views/account/lastvisits/">Входы в аккаунт</a></li>
                        <li class="personal"><a href="/views/account/close/">Закрыть аккаунт</a></li>
                    </ul>
                </div>
                <a onclick="showAccountDetails()">Аккаунт</a>
            </li>
            <li <?php if ($url[3] == 'security') {
                echo 'class="active"';
            } ?>>
                <a href="/views/account/security/" style="color:#FA385D">Настройки безопасности</a>
            </li>
        </ul>
    </div>
</div>
</section>
