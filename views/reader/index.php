<?php session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
}
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/user/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/book/book.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Мой профиль</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/profile.js" defer></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<br>
<main class="page-content-reader page-content main-body">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/profileheader.php"; ?>

    <div id="user-pic-edit" class="userpic hidden">
        <div id="profilepic-edit-popup">
            <div class="popup-back" onclick="" style="display:block;z-index:1000;overflow: auto;">
                <div style="position:absolute;width:100%;height:100%;">
                    <div style="width:100%;height:100%;display:table;">
                        <div style="text-align:center;vertical-align:middle;display: table-cell;">
                            <div class="block-border card-block"
                                 style="z-index:1001;width:908px;text-align:left;margin:0 auto;">
                                <div class="group-title">
                                    <a title="Закрыть" class="right userpic-popup-close">
                                        <span style="margin-right:-2px;" class="i-cardclose"></span>
                                    </a>
                                    <h2>Изменение обложки</h2>
                                </div>
                                <div class="with-pad">
                                    <p>Выберите способ загрузки изображения.</p>
                                    <div class="margs-top" style="position:relative;">
                                        <div>
                                            <div id="userpic-crop-image" class="marg-right" style="float:left;">
                                                <div id="imgouter" style="width: 860px;">
                                                    <div id="imgsource" class="user-profile"  style="background: url(<?php echo $_SESSION['user']['cover_path']; ?>) <?php if($_SESSION['user']['cover_path'] === '/assets/images/root/icons/back-profile.png'){echo 'center center repeat-x #dbe0e6; background-size: contain !important;';} else{echo 'center center no-repeat; background-size: cover !important;';} ?> ;"></div>
                                                </div>
                                            </div>


                                            <div class="form-new picture-form-bottom">
                                                <div id="picture-default"></div>

                                                <div id="picture-new">
                                                    <a id="userpic-file-load" class="btn-fill marg-right">Загрузить с компьютера</a>
                                                    <span class="picture-size">Формат: png, jpg.<br>Размер от 1196x148 пикселей.</span>
                                                    <input id="picture-new-file" type="file" name="file" style="display:none;">
                                                    <div class="separator"></div>
                                                    <div class="marg-top picture-new">
                                                        <input type="text"id="picture-url-new" class="marg-right" style="width: 191px;" placeholder="Ссылка на картинку">
                                                        <a class="btn-fill opc-038" id="userpic-url-load">Загрузить</a>
                                                    </div>
                                                    <div class="separator"></div>
                                                </div>
                                            </div>
                                            <div class="separator"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="with-mpad block-bottom block-border-t" style="display: block;">
                                    <a class="btn-fill-empty btn-wh userpic-popup-close">Отмена</a>
                                    <a class="btn-fill-empty btn-darkred marg-left btn-wh">Удалить изображение</a>
                                    <a class="btn-fill btn-darkblue right" id="userpic-save-btn">Сохранить изображение</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="wrapper-ugc" style="max-width: 816px; margin: 15px;">
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