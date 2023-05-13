<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: /index.php');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Регистрация</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<main class="page-content-reader main-body">
    <div class="wrapper-ugc" style="max-width: 816px; margin: 15px;">
        <form class="reg-form" enctype="multipart/form-data">
            <section class="page-content__section">
                <h1>Регистраниция</h1>
                <div class="block-border card-block">
                    <div class="group-title">
                        <h2>Введите данные</h2>
                    </div>
                    <div class="with-pad form-new">
                        <div class="form-row">
                            <div class="tb-column-2">
                                <label class="label-form" for="card-index">Номер читательской карточки <p
                                        style="width: 10px; height: 10px; color: red; display: inline-block;">*</p>
                                </label>
                                <div class="form-input">
                                    <input class="index _req" id="card-index" maxlength="11" type="text" placeholder="00000000000" name="card-index" value="">
                                </div>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2"></div>
                        </div>
                        <div class="form-row">
                            <div class="tb-column-2">
                                <label class="label-form" for="name-reader">ФИО читателя: <p
                                        style="width: 10px; height: 10px; color: red; display: inline-block;">*</p>
                                </label>
                                <div class="form-input">
                                    <input class="reader _req" id="name-reader" type="text" placeholder="Иванов Иван Иванович" name="name-reader" value="">
                                </div>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2"></div>
                        </div>
                        <div class="form-row">
                            <div class="tb-column-2">
                                <label class="label-form" for="profile-login">Логин <p
                                        style="width: 10px; height: 10px; color: red; display: inline-block;">*</p>
                                </label>
                                <div class="form-input">
                                    <input class="login _req" id="profile-login" type="text" name="profile-login" maxlength="30" value="">
                                </div>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2"></div>
                        </div>
                        <div class="form-row">
                            <div class="tb-column-2">
                                <label class="label-form" for="profile-password">Пароль <p
                                        style="width: 10px; height: 10px; color: red; display: inline-block;">*</p>
                                </label>
                                <div class="form-input">
                                    <input class="password _req" id="profile-password" maxlength="30" type="password" name="profile-password" value=""
                                           style="width: 100% !important;">
                                </div>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2"></div>
                        </div>
                        <div class="form-row">
                            <div class="tb-column-2">
                                <label class="label-form" for="profile-email">Ваш email</label>
                                <div class="form-input">
                                    <input id="profile-email" type="text" name="profile-email" value="">
                                </div>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2"></div>
                        </div>
                        <div class="form-row">
                            <div class="tb-column">
                                <label class="label-form" for="account-web">Расскажите о себе</label>
                                <div class="form-texteditor">
                                    <div id="teaccount-about-container">
                                        <div class="text-editor-container" id="teaccount-about-ed_editor">
                                            <div class="editor-textarea">
                                                <div class="textarea-outer">
                                                    <textarea placeholder="..." class="ed_textarea  llcut"
                                                              id="profile-about" name="profile-about" rows="10"
                                                              style="height: 213px;"></textarea>
                                                </div>
                                                <br>
                                                <div class="text-editor-separator"></div>
                                                <div class="separator"></div>
                                            </div>
                                            <div></div>
                                            <div class="ed_preview" id="teaccount-about-preview" style="display:none"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <label class="label-form" for="account-picture">Аватарка</label>
                            <img alt="" title=""
                                 style="min-width:200px; height: 200px; object-fit: cover; background-color: #ffffff;"
                                 src="/assets/images/root/icons/noavatar.svg" width="200"><br>
                            <div class="tb-column-2 radiogroup">
                                <a class="campaign-groups-a color-gray ll-toggle-active menu-item active" data-radio="campaign-groups-a" data-id="account_picture_action_current"><span class="ub-check"></span>Сохранить текущую</a>
                                <input id="account_picture_action_current" name="account[picture_action]" value="current" style="display:none;" type="radio" checked="checked">
                            </div>

                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2 radiogroup"></div>
                        </div>
                        <div class="form-row">
                            <div class="tb-column-2 radiogroup">
                                <a id="account_picture" class="campaign-groups-a color-gray ll-toggle-active menu-item" data-radio="campaign-groups-a" data-id="account_picture_action_new"><span class="ub-check"></span>Загрузить с компьютера</a>
                                <input id="account_picture_action_new" name="account[picture_action]" value="new" style="display:none;" type="radio" checked="checked">
                                <div class="form-file form-bottom-checkgroup">
                                    <input type="file" name="profile-file">
                                </div>
                            </div>

                            <div class="tb-column-sep"></div>

                            <div class="tb-column-2 radiogroup">
                                <a id="account_url" class="campaign-groups-a color-gray ll-toggle-active menu-item" data-radio="campaign-groups-a" data-id="account_picture_action_url"><span class="ub-check"></span>Ссылка на внешнюю картинку</a>
                                <input id="account_picture_action_url" name="account[picture_action]" value="url" style="display:none;" type="radio" checked="checked">
                                <div class="form-input form-bottom-checkgroup">
                                    <input placeholder="http://" type="text" name="profile-url" value=""">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="with-mpad block-bottom block-border-t" id="user-posts-more">
                        <input type="button" id="btn_reg" class="btn-fill btn-darkgreen" value="Зарегистрироваться">
                        <input type="button" class="btn-fill btn-wh right" value="Отмена"
                               onclick="location.href='/index.php';">
                    </div>
                </div>
            </section>
        </form>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>
</body>
</html>