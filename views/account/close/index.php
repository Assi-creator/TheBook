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

    <title>Закрыть аккаунт</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/profile.js" defer></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<main class="main-body page-content">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/editheader.php"; ?>

    <form action="/account/close" method="post" enctype="multipart/form-data">
        <div class="wrapper-ugc" style="max-width: 816px; margin-top: 15px;">
            <div class="block-border card-block">
                <h2 class="group-title">Закрыть аккаунт</h2>
                <div class="with-pad form-new">
                    <div class="form-row">
                        <p>После того как аккаунт будет закрыт Вы сможете самостоятельно восстановить аккаунт в течение
                            месяца <a href="/account/restore" title="Восстановление аккаунта">по ссылке</a></p>
                    </div>
                </div>

                <div class="with-mpad block-bottom block-border-t" id="user-posts-more">
                    <input type="submit" name="btn_close" class="btn-fill btn-darkgreen" value="Закрыть аккаунт"
                           onclick="if (!confirm('Вы уверены, что хотите закрыть свой профиль?')) return false;">
                    <input type="button" class="btn-fill btn-wh right" value="Отмена"
                           onclick="location.href='/views/reader/';">
                </div>

            </div>
        </div>
    </form>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>

