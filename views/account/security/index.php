<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Настройки безопасности</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/header.js" defer></script>
    <script src="/assets/js/profile.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.js"></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<main class="main-body page-content">
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/editheader.php"; ?>

    <div class="wrapper-ugc" style="max-width: 816px; margin-top: 15px;">
        <div class="block-border card-block">
            <h2 class="group-title">Настройки безопасности</h2>
            <div class="with-pad form-new">
                <div class="form-row">
                    <div class="tb-column-2">
                        <label class="label-form" for="email-backup">Резервный адрес электронной почты</label>
                        <div class="form-input" style="margin-right: 0;">
                            <input type="text" id="email-backup" name="security-email_backup"
                                   style="box-sizing: border-box;" value="">
                        </div>
                    </div>
                    <div class="tb-column-sep"></div>
                    <div class="tb-column-2"></div>
                    <input type="button" class="btn-fill btn-darkgreen event-spad change-reserv-email" value="Сохранить" style="margin-top: 10px;">
                </div>

            </div>
        </div>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>