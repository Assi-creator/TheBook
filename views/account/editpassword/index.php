<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Изменить пароль</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<main class="main-body page-content">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/editheader.php"; ?>

    <div class="wrapper-ugc" style="max-width: 816px; margin-top: 15px;">
        <form>
            <div class="block-border card-block">
                <h2 class="group-title">Изменить пароль</h2>
                <div class="with-pad form-new">
                    <table class="form">
                        <tbody>
                        <tr>
                            <td>Старый пароль</td>
                            <td><input class="wide" type="password" name="account-old_password" value=""></td>
                        </tr>
                        <tr>
                            <td>Новый пароль</td>
                            <td><input class="wide" type="password" name="account-new_password" value=""></td>
                        </tr>
                        <tr>
                            <td>Повторить пароль</td>
                            <td><input class="wide" type="password" name="account-repeat_password" value=""></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="with-mpad block-bottom block-border-t" id="user-posts-more">
                    <input type="button" name="btn_save" class="btn-fill btn-darkgreen change-password" value="Сохранить">
                    <input type="button" class="btn-fill btn-wh right" value="Отмена"
                           onclick="location.href='/views/reader/';">
                </div>
            </div>
        </form>
    </div>

</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>