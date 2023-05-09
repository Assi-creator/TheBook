<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Настройки безопасности</title>

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
                            <input type="text" id="email-backup" name="security[email_backup]"
                                   style="box-sizing: border-box;" value="">
                        </div>
                    </div>
                    <div class="tb-column-sep"></div>
                    <input type="button" class="btn-fill btn-darkgreen event-spad"
                           onclick="save_account_email_backup();" value="Сохранить">
                </div>

                <div class="form-row">
                    <div class="tb-column-2">
                        <label class="label-form">Секретный вопрос</label>
                        <select name="security[question]" id="select-security-question"
                                style="box-sizing: border-box;width:100%;">
                            <option value="0" selected="selected">Выберите секретный вопрос</option>
                            <option value="1">Кличка первого домашнего животного?</option>
                            <option value="2">В каком городе вы родились?</option>
                            <option value="3">Ваше прозвище в детстве?</option>
                            <option value="4">В каком городе встретились ваши родители?</option>
                            <option value="5">Имя вашего двоюродного брата или сестры?</option>
                            <option value="6">Название первой школы, в которую вы ходили?</option>
                        </select>

                        <label class="label-form event-spad" for="security-answer">Секретный ответ</label>
                        <div class="form-input" style="margin-right: 0;">
                            <input type="text" id="security-answer-backup" value="" style="box-sizing: border-box;">
                        </div>
                    </div>
                    <div class="tb-column-sep"></div>
                    <input type="button" class="btn-fill btn-darkgreen event-spad" value="Сохранить">
                </div>
            </div>
        </div>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>