<?php session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/api/controller/review/review.php";
include $_SERVER['DOCUMENT_ROOT'] . "/api/controller/book/book.php"; ?>

<?php $api = new \TheBook\controller\book(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Новая книга</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<main class="page-content-reader main-body">
    <div class="wrapper-ugc" style="max-width: 816px; margin: 15px;">
        <form class="reg-form" enctype="multipart/form-data">
            <section class="page-content__section">
                <h1>Новая книга</h1>
                <div class="block-border card-block">
                    <div class="group-title">
                        <h2>Введите данные</h2>
                    </div>
                    <div class="with-pad form-new">
                        <div class="form-row">
                            <div class="tb-column-2">
                                <label class="label-form" for="title-book">Название книги<p style="width: 10px; height: 10px; color: red; display: inline-block;">*</p></label>
                                <div class="form-input">
                                    <input class="title _req" id="title-book" type="text" name="title-book" value="">
                                </div>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2">
                                <label class="label-form" for="book-author">Автор: <p style="width: 10px; height: 10px; color: red; display: inline-block;">*</p></label>
                                <div class="form-input">
                                    <input class="author _req" id="book-author" type="text" name="book-author" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="tb-column-2">
                                <label class="label-form" for="book-genres">Жанры: <p style="width: 10px; height: 10px; color: red; display: inline-block;">*</p></label>
                                <div class="section-form__select">
                                    <details class="ll-details-closed" style="z-index: 1111; border-radius: 0; width: 95%;">
                                        <summary id="rating" style="border-radius: 0;">
                                            Жанры
                                        </summary>
                                        <div>
                                            <?php $genreTitle = $api->getAllSubgenres();
                                                    foreach ($genreTitle as $title):?>
                                                    <details style="position: relative">
                                                        <summary>
                                                            <?=$title['name']?>
                                                        </summary>
                                                        <div>
                                                            <?php $getSubgenres = $api->getAllSubgenre($title['id_title']);
                                                                    foreach ($getSubgenres as $subgenre):?>
                                                                            <input id="subgenre-<?=$title['id_title']?>-<?=$subgenre['id_genre']?>" type="checkbox" value="<?=$subgenre['id_genre']?>"><label for="subgenre-<?=$title['id_title']?>-<?=$subgenre['id_genre']?>"><?=$subgenre['name']?></label>
                                                                    <?php endforeach; ?>
                                                        </div>
                                                    </details>
                                            <?php endforeach; ?>
                                        </div>
                                    </details>
                                    <input id="rating-input" type="hidden" name="subgenre-id" value="">
                                </div>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2">
                                <label class="label-form" for="book-publishing">Издательство: <p style="width: 10px; height: 10px; color: red; display: inline-block;">*</p></label>
                                <div class="form-input">
                                    <input class="publishing _req" id="book-publishing" type="text" name="book-publishing" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="tb-column-2">
                                <label class="label-form" for="book-ISBN">ISBN: <p style="width: 10px; height: 10px; color: red; display: inline-block;">*</p></label>
                                <div class="form-input">
                                    <input class="ISBN _req" id="book-ISBN" type="text" name="book-ISBN" maxlength="30" value="">
                                </div>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2">
                                <label class="label-form" for="book-count">Количество страниц:<p style="width: 10px; height: 10px; color: red; display: inline-block;">*</p></label>
                                <div class="form-input">
                                    <input class="count _req" id="book-count" type="text" name="book-count" maxlength="30" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="tb-column-2">
                                <label class="label-form" for="book-year">Год издания: <p style="width: 10px; height: 10px; color: red; display: inline-block;">*</p></label>
                                <div class="form-input">
                                    <input class="year _req" id="book-year" maxlength="4" type="text" name="book-year" value="" style="width: 100% !important;">
                                </div>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2">
                                <label class="label-form" for="book-age">Возрастное ограничение: <p style="width: 10px; height: 10px; color: red; display: inline-block;">*</p>
                                </label>
                                <div class="form-input">
                                    <input class="age _req" id="book-age" type="text" name="book-age" maxlength="2" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="tb-column-2">
                                <label class="label-form" for="book-series">Серия</label>
                                <div class="form-input">
                                    <input id="profile-email" type="text" name="book-series" value="">
                                </div>
                            </div>
                            <div class="tb-column-sep"></div>
                            <div class="tb-column-2"></div>
                        </div>
                        <div class="form-row">
                            <div class="tb-column">
                                <label class="label-form" for="book-annotation">Описание книги</label>
                                <div class="form-texteditor">
                                    <div id="teaccount-about-container">
                                        <div class="text-editor-container" id="teaccount-about-ed_editor">
                                            <div class="editor-textarea">
                                                <div class="textarea-outer">
                                                    <textarea placeholder="..." class="ed_textarea  llcut" id="book-annotation" name="book-annotation" rows="10" style="height: 213px;"></textarea>
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
                            <label class="label-form" for="account-picture">Обложка книги - рекомендуется выбирать изображения формате 400х600px</label>
                            <img alt="" title="" style="min-width:200px; height: 303px; object-fit: cover; background-color: #ffffff;" src="/assets/images/root/icons/no-book-image.png" width="200"><br>
                            <div class="tb-column-2 radiogroup">
                                <a class="campaign-groups-a color-gray ll-toggle-active menu-item active" data-radio="campaign-groups-a" data-id="account_picture_action_current"><span class="ub-check"></span>Сохранить стандартную</a>
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
                        <input type="button" id="btn_add_book" class="btn-fill btn-darkgreen" value="Сохранить">
                        <input type="button" class="btn-fill btn-wh right" value="Отмена"
                               onclick="location.href='/index.php';">
                    </div>
                </div>
            </section>
        </form>
    </div>
</main>

<script>
    $(document).ready(function() {
        // Находим все чекбоксы внутри элемента .section-form__select
        var $checkboxes = $('.section-form__select input[type="checkbox"]');
        // Обработчик изменения состояния чекбокса
        $checkboxes.change(function() {
            var selectedValues = [];
            // Собираем значения выбранных чекбоксов в массив
            $checkboxes.filter(':checked').each(function() {
                selectedValues.push($(this).val());
            });
            // Записываем значения в скрытое поле в виде строки, разделенной запятыми
            $('#rating-input').val(selectedValues.join(','));
        });
    });
</script>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>
</body>
</html>
