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

    <title>Мой профиль</title>

    <link rel="stylesheet" href="/assets/css/main.css">
    <link href="/assets/css/template.css" rel="stylesheet">
    <link rel="shortcut icon" href="/assets/images/root/icons/the-book-icon.ico" type="image/x-i con">
    <link href="/assets/libs/node_modules/cropperjs/dist/cropper.css" rel="stylesheet">

    <script src="/assets/libs/node_modules/cropperjs/dist/cropper.js"></script>
    <script src="/assets/js/header.js" defer></script>
    <script src="/assets/js/profile.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.js"></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<br>
<main class="page-content-reader main-body">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/profileheader.php"; ?>

    <!--Начинка страницы-->
    <div class="wrapper-ugc" style="max-width: 816px; margin-top: 25px;">
        <section class="page-content__section">
            <h1>Мой профиль</h1>
            <div class="block-border card-block">
                <div class="group-title">
                    <h2>Информация</h2>
                </div>
                <div class="with-pad">
                    <div class="profile-into-column">
                        <span class="group-row-title">
                            <b>Фамилия:</b>
                             <?php echo $_SESSION['user']['surname']; ?>
                        </span>
                        <span class="group-row-title">
                            <b>Имя:</b>
                             <?php echo $_SESSION['user']['name']; ?>
                        </span>
                        <span class="group-row-title">
                            <b>Отчество:</b>
                            <?php echo $_SESSION['user']['patronymic']; ?>
                        </span>
                        <span class="group-row-title">
                            <b>Пол:</b>
                             <?php if ($_SESSION['user']['gender'] == 'ж') {
                                echo 'женский';
                            } else {
                                echo 'мужской';
                            }; ?>
                        </span>
                        <span class="group-row-title">
                            <b>Дата рождения:</b>
                            <?php echo (formatDate($_SESSION['user']['birthday'])); ?>
                        </span>
                        <span class="group-row-title">
                            <b>Номер читательской карточки:</b>
                            <?php echo $_SESSION['user']['card']; ?>
                        </span>
                        <span class="group-row-title">
                            <b>Email:</b>
                            <?php if (($_SESSION['user']['email']) != ''){
                                echo $_SESSION['user']['email'];
                            } else {
                                echo 'Не указан';
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="block-border card-block">
                <div class="group-title">
                    <a class="right" href="../account/editprofile/">
                        <span class="i-group-edit" style="margin-right: 0;"></span>
                    </a>
                    <h2>О себе</h2>
                </div>
                <div class="with-pad">
                    <div id="user-about">
                        <?php if($_SESSION['user']['about'] == '' || $_SESSION['user']['about'] == null){
                            echo 'Информация отсутствует';
                        }else{
                            echo $_SESSION['user']['about'];
                        } ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>

<?php function formatDate($date) {
    $months = array(
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря'
    );
    $dateParts = explode('-', $date);
    $day = (int)$dateParts[2];
    $month = $months[(int)$dateParts[1]-1];
    $year = (int)$dateParts[0];
    return $day.' '.$month.' '.$year.' г.';
}
?>