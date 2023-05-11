<?php session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Мои книги</title>

    <link rel="stylesheet" href="/assets/css/main.css">
    <link href="/assets/css/template.css" rel="stylesheet">
    <link rel="shortcut icon" href="/assets/images/root/icons/the-book-icon.ico" type="image/x-i con">

    <script src="/assets/js/header.js" defer></script>
    <script src="/assets/js/profile.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.js"></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<br>
<main class="main-body page-content">
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/profileheader.php"; ?>

    <div id="bodywrapper" style="margin-top: 25px">
        <div id="innerwrapper">
            <div id="contentwrapper">
                <div style="margin: 0 auto">
                    <div id="main-container" class="container container-main" style="min-height: 0px">
                        <h1>Мои книги</h1>
                        <div id="es-top-wrapper" class="block-border card-block es-top-wrapper for-books">
                            <div class="with-pads">
                                <div class="es-img">
                                    <img src="/assets/images/root/icons/wish.svg">
                                </div>
                                <div class="es-data">
                                    Ваш список пока пуст!
                                    <br>
                                    <br>
                                    Выберите свой любимый <a href="/views/genres/">Жанр</a>, там Вы гарантированно найдете интересные книги.
                                </div>
                                <div class="separator"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>
