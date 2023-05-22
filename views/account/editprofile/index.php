<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Редактирование профиля</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<main class="main-body page-content">


    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/editheader.php"; ?>

    <div class="wrapper-ugc" style="max-width: 816px; margin-top: 25px;">
        <form class="info-form" enctype="multipart/form-data">
            <div class="block-border card-block">
                <div class="group-title">
                    <h2>Настройки профиля</h2>
                </div>
                <div class="with-pad form-new">
                    <div class="form-row">
                        <div class="tb-column-2">
                            <div style="display:flex; justify-content: space-between;">
                                <label class="label-form" for="account-name">Логин</label>
                                <a title="Ваш логин должен содержать не более 30 символов.">
                                    <img src="/assets/images/root/icons/icon-question.png" style="width: 20px !important; height: 20px !important; object-fit: cover; border-radius: 50%; cursor: help;" alt="">
                                </a>
                            </div>
                            <div class="form-input">
                                <input class="_req" type="text" id="account-name" name="profile-login"
                                       value="<?=$_SESSION['user']['login']?>">
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
                                    id="account-about" name="profile-about" style="color: black !important;"
                                    rows="10"><?=$_SESSION['user']['about']?></textarea>
                                            </div>
                                            <br>
                                            <div class="text-editor-separator"></div>

                                            <div class="separator"></div>
                                        </div>
                                        <div></div>
                                        <div class="ed_preview" id="teaccount-about-preview"
                                             style="display:none"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row" id="image">
                        <label class="label-form" for="account-picture">Аватарка</label>
                        <img alt="<?=$_SESSION['user']['login']?>" title="<?=$_SESSION['user']['login'] ?>"
                             style="min-width:200px; height: 200px; object-fit: cover; background-color: #ffffff;"
                             src="<?=$_SESSION['user']['avatar_path']?>" width="200"><br>


                        <div class="tb-column-2 radiogroup">
                            <a class="campaign-groups-a color-gray ll-toggle-active menu-item active" data-radio="campaign-groups-a" data-id="account_picture_action_current">
                                <span class="ub-check"></span>Сохранить текущую</a>
                            <input id="account_picture_action_current" name="account[picture_action]"
                                   value="current" style="display:none;" type="radio" checked="checked">
                        </div>
                        <div class="tb-column-sep"></div>


                        <div class="tb-column-2 radiogroup">
                            <a class="campaign-groups-a color-gray ll-toggle-active menu-item" data-radio="campaign-groups-a" data-id="account_picture_action_no">
                                <span class="ub-check"></span>Удалить</a>
                            <input id="account_picture_action_no" name="account[picture_action]" value="no"
                                   style="display:none;" type="radio">
                        </div>
                    </div>

                    <div class="form-row">


                        <div class="tb-column-2 radiogroup">
                            <a id="account_picture"
                               class="campaign-groups-a color-gray ll-toggle-active menu-item"
                               data-radio="campaign-groups-a" data-id="account_picture_action_new"><span
                                    class="ub-check"></span>Загрузить с компьютера</a>
                            <input id="account_picture_action_new" name="account[picture_action]" value="new"
                                   style="display:none;" type="radio">
                            <div class="form-file form-bottom-checkgroup">
                                <input type="file" name="profile-file">
                            </div>
                        </div>


                        <div class="tb-column-sep"></div>


                        <div class="tb-column-2 radiogroup">
                            <a id="account_url" class="campaign-groups-a color-gray ll-toggle-active menu-item" data-radio="campaign-groups-a" data-id="account_picture_action_url">
                                <span class="ub-check"></span>Ссылка на внешнюю картинку</a>
                            <input id="account_picture_action_url" name="account[picture_action]" value="url"
                                   style="display:none;" type="radio">
                            <div class="form-input form-bottom-checkgroup">
                                <input placeholder="http://" type="text" name="profile-url" value="">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="with-mpad block-bottom block-border-t" id="user-posts-more">
                    <input id="btn-editprofile-save" type="button" class="btn-fill btn-darkgreen" value="Сохранить">
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