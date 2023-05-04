<section class="header">
<div class="header-context profile-context">
    <div class="header-container">
        <ul class="nav context">
            <li class="standard">
                <a href="/views/reader/">←</a>
            </li>
            <li class="active">
                <a href="/views/account/editprofile/">Профиль</a>
            </li>
            <li class="standard" style="position: relative;">
                <div id="div-profileedit-account-dropdown" class="div-context-more ll-toggle-hide"
                     style="margin-top: 65px; left: 0; margin-left: 0; display: none">
                    <div class="div-context-shadow" onclick="hideAccountDetails()"></div>
                    <ul id="ul-context-more" class="share-menu share-menu-ul oneline">
                        <li class="personal"><a href="/views/account/editemail">
                                <?php if(isset($_SESSION['user']['email'])){
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
            <li class="standard">
                <a href="/views/account/security/" style="color:#FA385D">Настройки безопасности</a>
            </li>
        </ul>
    </div>
</div>
</section>
