<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: /');
}

if ($_GET['key'] != $_SESSION['change_key']) {
    header('Location: /');
} ?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Восстановление пароля</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<main class="page-content-reader main-body">
    <input type="hidden" value="<?php echo $_GET['key']; ?>">
    <div class="wrapper-ugc" style="max-width: 816px; margin-top: 15px;">
        <form>
            <div class="block-border card-block">
                <h2 class="group-title">Новый пароль</h2>
                <div class="with-pad form-new">
                    <table class="form">
                        <tbody>
                        <tr>
                            <td>Новый пароль</td>
                            <td><input class="wide" type="password" name="forgot-new_password" value=""></td>
                        </tr>
                        <tr>
                            <td>Повторить пароль</td>
                            <td><input class="wide" type="password" name="forgot-repeat_password" value=""></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="with-mpad block-bottom block-border-t" id="user-posts-more">
                    <input type="button" name="btn-forgot-password__form_save" class="btn-fill btn-darkgreen btn-forgot-password__form_save" value="Сохранить">
                </div>
            </div>
        </form>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>
</body>
</html>
