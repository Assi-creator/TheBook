<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Входы в аккаунт</title>

    <link rel="stylesheet" href="/assets/css/main.css">
    <link href="/assets/css/header.css" rel="stylesheet">
    <link rel="shortcut icon" href="/assets/images/the-book-icon.ico" type="image/x-i con">

    <script src="/assets/js/header.js" defer></script>
    <script src="/assets/js/profile.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.js"></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<main class="main-body page-content">
    <section class="header">
        <div class="header-context profile-context">
            <div class="header-container">
                <ul class="nav context">
                    <li class="standard">
                        <a href="/views/reader/">←</a>
                    </li>
                    <li class="standard">
                        <a href="/views/account/editprofile">Профиль</a>
                    </li>
                    <li class="active" style="position: relative;">
                        <div id="div-profileedit-account-dropdown" class="div-context-more ll-toggle-hide"
                             style="margin-top: 65px; left: 0px; margin-left: 0px; display: none">
                            <div class="div-context-shadow" onclick="hideAccountDetails()"></div>
                            <ul id="ul-context-more" class="share-menu share-menu-ul oneline">
                                <li class="personal"><a href="/views/account/editemail">Добавить email</a></li>
                                <li class="personal"><a href="/views/account/editpassword/">Установить пароль</a></li>
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
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>