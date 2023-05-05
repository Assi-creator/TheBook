<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Изменить email</title>

    <link rel="stylesheet" href="/assets/css/main.css">
    <link href="/assets/css/template.css" rel="stylesheet">
    <link rel="shortcut icon" href="/assets/images/the-book-icon.ico" type="image/x-i con">

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
        <form action="/api/controller/user/user.php" method="POST" enctype="multipart/form-data" name="account_info">
            <div class="block-border card-block">
                <?php if ($_SESSION['user']['email'] == null): ?>
                    <h2 class="group-title"><?php echo 'Добавить email'; ?></h2>
                    <div class="with-pad form-new">
                        <table class="form">
                            <tbody>
                            <tr>
                                <td>Email</td>
                                <td><input class="wide" type="password" name="account[new_email]" value=""></td>
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
                                <td><input class="wide" type="password" name="account[new_password]" value=""></td>
                            </tr>
                            <tr>
                                <td>Пароль <?php echo $_SESSION['user']['login']; ?></td>
                                <td><input class="wide" type="password" name="account[email_password]" value=""></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="with-mpad block-bottom block-border-t" id="user-posts-more">
                    <input type="submit" name="btn_save" class="btn-fill btn-darkgreen" value="Сохранить">
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