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

    <title><?php if (!empty($_SESSION['user']['email'])) {
            echo 'Изменить email';
        } else {
            echo 'Добавить email';
        } ?></title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/header.js" defer></script>
    <script src="/assets/js/profile.js" defer></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<main class="main-body page-content">
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/editheader.php"; ?>

    <div class="wrapper-ugc" style="max-width: 816px; margin-top: 15px;">
        <form>
            <div class="block-border card-block">
                <?php if ($_SESSION['user']['email'] == null): ?>
                    <h2 class="group-title"><?php echo 'Добавить email'; ?></h2>
                    <div class="with-pad form-new">
                        <table class="form">
                            <tbody>
                            <tr>
                                <td>Email</td>
                                <td><input class="wide" type="text" name="account-new_email" value=""></td>
                            </tr>
                            <tr>
                                <td>Пароль <?php echo $_SESSION['user']['login']; ?></td>
                                <td><input class="wide" type="password" name="account-password" value=""></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>

                    <h2 class="group-title"><?php echo 'Изменить email'; ?></h2>
                    <div class="with-pad form-new">
                        <table class="form">
                            <tbody>
                            <tr>
                                <td>Текущий email</td>
                                <td><?php echo $_SESSION['user']['email']; ?></td>
                            </tr>
                            <tr>
                                <td>Новый email</td>
                                <td><input class="wide" type="text" name="account-new_email" value=""></td>
                            </tr>
                            <tr>
                                <td>Пароль <?php echo $_SESSION['user']['login']; ?></td>
                                <td><input class="wide" type="password" name="account-password" value=""></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="with-mpad block-bottom block-border-t" id="user-posts-more">
                    <input type="button" class="btn-fill btn-darkgreen email-change" value="Сохранить">
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