<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Мой профиль</title>

    <link rel="stylesheet" href="/assets/css/main.css">
    <link href="/assets/css/header.css" rel="stylesheet">
    <link rel="shortcut icon" href="/assets/images/the-book-icon.ico" type="image/x-i con">
    <link href="/assets/libs/node_modules/cropperjs/dist/cropper.css" rel="stylesheet">

    <script src="/assets/libs/node_modules/cropperjs/dist/cropper.js"></script>
    <script src="/assets/js/header.js" defer></script>
    <script src="/assets/js/profile.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.js"></script>
</head>
<body>

<?php
session_start();

require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<br>
<main class="page-content-reader main-body">
    <section class="header">

        <!--Верхнее меню-->
        <div id="profile-bg-wrapper" class="gp-wrapper user-profile"
             style="background: url(<?php echo '../../' . $_SESSION['user']['cover_path']; ?>) center center no-repeat; object-fit: cover; background-size: cover !important; height: 148px; width: 100%;">
            <div class="gp-outer">
                <div class="gp-inner">
                    <table class="gp-table">
                        <tbody>
                        <tr>

                            <td class="gp-avatar">
                                <div id="profile-avatar" class="profile-avatar"
                                     style="background-image: url(<?php echo '../../' . $_SESSION['user']['avatar_path']; ?>)">
                                    <div id="userpic-edit" class="userpic-edit">
                                        <div class="userpic-edit-back"></div>
                                        <a class="userpic-edit-a" onclick="showImagePopup()">
                                            <span class="i-tag-add" style="margin-left: -3px"></span>Добавить
                                        </a>
                                    </div>
                                </div>
                            </td>


                            <td class="gp-details">
                                <div class="gp-more">
                                    <div class="btn-inline ll-select ll-select-more"
                                         style="margin-left: 13px; vertical-align: top">
                                        <a class="btn-icon-empty btn-wh ll-click-toggle" onclick="showMoreDetails()">
                                            <span class="group-more-menu"></span>
                                        </a>

                                        <div id="div-profile-menu-more" class="ll-toggle-hide"
                                             style="visibility: visible; display: none;">
                                            <div class="div-context-shadow" onclick="hideMoreDetails()"></div>
                                            <div id="profile-menu-more" class="ll-select-holder"
                                                 style="top: 36px; z-index: 10002;">
                                                <a class="ll-select-row" onclick="showImagePopup()">Добавить
                                                    аватарку</a>
                                                <a class="ll-select-row">Добавить обложку</a>
                                                <a class="ll-select-row">Редактировать профиль</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span id="header-profile-login"
                                      class="header-profile-login"><?php echo $_SESSION['user']['login']; ?></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <!--Окно с добавлением аватара-->
                    <div id="user-pic-edit" style="display: none">
                        <div id="userpic-edit-popup">
                            <div class="popup-back"
                                 style="display: block; z-index: 1000; overflow: auto; background: rgba(57, 66, 76, 0.5);">
                                <div style="position: absolute; width: 100%; height: 100%">
                                    <div style="width: 100%; height: 100%; display: table">
                                        <div style="text-align: center; vertical-align: middle; display:table-cell;">
                                            <div class="block-border card-block"
                                                 style="z-index: 1001; width: 908px; text-align: left; margin: 0 auto">
                                                <div class="group-title">
                                                    <a class="right uderpic-popup-close" onclick="hideImagePopup()"
                                                       title="Закрыть">
                                                        <span class="i-cardclose" style="margin-right: -2px;"></span>
                                                    </a>
                                                    <h2>Изменение аватарки</h2>
                                                </div>
                                                <div class="with-pad">
                                                    <p>С помощью ползунков выберите квадратное изображение, которое
                                                        будет использоваться в профиле и списках.</p>
                                                    <div class="margs-top" style="position: relative;">
                                                        <div>
                                                            <div id="userpic-crop-image" class="marg-right"
                                                                 style="float: left;">
                                                                <div id="imgouter" style="width: 200px;">
                                                                    <img id="imgsource" style="width: 200px;"
                                                                         src="/assets/images/noavatar.svg"
                                                                         class="cropper-hidden">
                                                                    <div class="cropper-container cropper-bg"
                                                                         touch-action="none"
                                                                         style="width: 202px; height: 204px;">
                                                                        <div class="cropper-wrap-box">
                                                                            <div class="cropper-canvas"
                                                                                 style="width: 208px; height: 208px; transform: translateX(-3px);">
                                                                                <img src="/assets/images/noavatar.svg"
                                                                                     alt="The image to crop"
                                                                                     class="cropper-hide"
                                                                                     style="width: 208px; height: 208px; transform: none;">
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="cropper-drag-box cropper-crop cropper-modal"
                                                                            data-cropper-action="crop"></div>
                                                                        <div class="cropper-crop-box"
                                                                             style="width: 161.6px; height: 163.2px; transform: translateX(16.4px);">
                                                                            <span class="cropper-view-box">
                                                                                <img src="/assets/images/noavatar.svg"
                                                                                     alt="The image to preview"
                                                                                     style="width: 208px; height: 208px; transform: translateX(-19.4px);">
                                                                            </span>
                                                                            <span
                                                                                class="cropper-dashed dashed-h"></span>
                                                                            <span
                                                                                class="cropper-dashed dashed-v"></span>
                                                                            <span class="cropper-center"></span>
                                                                            <span class="cropper-face cropper-move"
                                                                                  data-cropper-action="all"></span>
                                                                            <span class="cropper-line line-e"
                                                                                  data-cropper-action="e"></span>
                                                                            <span class="cropper-line line-n"
                                                                                  data-cropper-action="n"></span>
                                                                            <span class="cropper-line line-w"
                                                                                  data-cropper-action="w"></span>
                                                                            <span class="cropper-line line-s"
                                                                                  data-cropper-action="s"></span>
                                                                            <span class="cropper-point point-e"
                                                                                  data-cropper-action="e"></span>
                                                                            <span class="cropper-point point-n"
                                                                                  data-cropper-action="n"></span>
                                                                            <span class="cropper-point point-w"
                                                                                  data-cropper-action="w"></span>
                                                                            <span class="cropper-point point-s"
                                                                                  data-cropper-action="s"></span>
                                                                            <span class="cropper-point point-ne"
                                                                                  data-cropper-action="ne"></span>
                                                                            <span class="cropper-point point-nw"
                                                                                  data-cropper-action="nw"></span>
                                                                            <span class="cropper-point point-sw"
                                                                                  data-cropper-action="sw"></span>
                                                                            <span class="cropper-point point-se"
                                                                                  data-cropper-action="se"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-new picture-form-right">
                                                                <div id="picture-new">
                                                                    <a id="userpic-file-load"
                                                                       class="btn-fill marg-right"
                                                                       style="width: 220px;">Загрузить с компьютера</a>
                                                                    <span class="picture-size">
                                                                        Формат: png, jpg.
                                                                        <br>
                                                                        Размер от 200x200 пикселей.
                                                                    </span>
                                                                    <div class="marg-top picture-new">
                                                                        <input id="picture-url-new" class="marg-right"
                                                                               type="text" style="width: 220px;"
                                                                               placeholder="Ссылка на картинку">
                                                                        <a id="userpic-url-load" class="btn-fill">Загрузить</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="with-mpad block-bottom block-border-t">
                                                    <a class="btn-fill-empty btn-wh userpic-popup-close"
                                                       onclick="hideImagePopup()">Отмена</a>
                                                    <a id="userpic-save-btn" class="btn-fill btn-darkblue">Сохранить
                                                        изображение</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Нижнее меню-->
        <div class="header-context profile-context under-block">
            <div class="header-container">
                <div id="menu-inner" class="menu-group" style="overflow: hidden; height: 60px;">
                    <ul id="menu-container" class="nav context">
                        <li class="active" data-width="65">
                            <a href="/reader/NastyaMastyugina">Профиль</a>
                        </li>
                        <li class="personal" data-width="65">
                            <a href="/reader/NastyaMastyugina">Мои книги</a>
                        </li>
                        <li class="personal" data-width="65">
                            <a href="/reader/NastyaMastyugina">Прочитала</a>
                        </li>
                        <li class="personal" data-width="65">
                            <a href="/reader/NastyaMastyugina">Хочу прочитать</a>
                        </li>
                        <li class="personal" data-width="65">
                            <a href="/reader/NastyaMastyugina">Читаю сейчас</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


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
                            <b>Фамилия</b>
                            : <?php echo $_SESSION['user']['surname']; ?>
                        </span>
                        <span class="group-row-title">
                            <b>Имя</b>
                            : <?php echo $_SESSION['user']['name']; ?>
                        </span>
                        <span class="group-row-title">
                            <b>Отчество</b>
                            : <?php echo $_SESSION['user']['patronymic']; ?>
                        </span>
                        <span class="group-row-title">
                            <b>Пол</b>
                            : <?php if ($_SESSION['user']['gender'] == 'ж') {
                                echo 'женский';
                            } else {
                                echo 'мужской';
                            }; ?>
                        </span>
                        <span class="group-row-title">
                            <b>Дата рождения</b>
                            : <?php echo $_SESSION['user']['birthday']; ?>
                        </span>
                        <span class="group-row-title">
                            <b>Я не придумала что ту еще может быть</b>
                        </span>
                        <span class="group-row-title">
                            <b>C</b>
                        </span>
                        <span class="group-row-title">
                            <b>I</b>
                        </span>
                        <span class="group-row-title">
                            <b>R</b>
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
                        <?php echo $_SESSION['user']['about']; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>