<?php session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
}
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/book/book.php';
$api = new TheBook\controller\Book;
$book = $api->getSingleBookById($_GET['book']);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Рецензия на <?=$book['title'];?> </title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/profile.js" defer></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<main class="page-content-reader page-content main-body">
    <div class="wrapper-ugc" style="max-width: 816px; margin: 15px;">
        <form class="review-create-form">
            <div class="block-border card-block">
                <div class="group-title">
                    <h2>Новая рецензия</h2>
                </div>
                <div class="with-pad backgr-block review" style="margin-top: 0; flex-direction:row;">
                    <a href="/views/book/?book=<?=$book['id']?>">
                        <img src="<?=$book['image']?>" style="min-width: 100px; background-color: white; float: left;" width="100">
                    </a>
                    <div class="book-block-data" style="margin-left: 35px; width: 500px">
                        <a class="post-scifi-title" href="/views/book/?book=<?=$book['id']?>"><?=$book['title'];?></a>
                        <br>
                        <a style="cursor:default; color: black;"><?=$book['author']; ?></a>
                        <br>
                        <div style="margin-top: 5px; display: flex;flex-wrap: wrap; width: 500px;">
                            <?php $genre = $api->getGenresForSingleBook($book['id']); for ($i = 0; $i < count($genre); $i++):?>
                                <a class="label-genre" href="/views/genres/genre?genre=<?=$genre[$i]['id_genre'];?>">
                                    <?=$genre[$i]['name']; ?>
                                </a>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="separator"></div>
                </div>
                <div class="with-pad">
                    <table class="form-new" style="100%">
                        <tbody>
                        <tr>
                            <tb>
                                <div class="tb-column-2">
                                    <label class="label-form">Ваша оценка книги</label>
                                    <div class="bc-menu__rating">
                                        <div class="review-menu__stars bc-rating--full">
                                            <input id="review-radio-rating-5" class="review-radio rating-radio" type="radio" value="5"
                                                   name="bc_rating">
                                            <label for="review-radio-rating-5"></label>
                                            <input id="review-radio-rating-4" class="review-radio rating-radio" type="radio" value="4"
                                                   name="bc_rating">
                                            <label for="review-radio-rating-4"></label>
                                            <input id="review-radio-rating-3" class="review-radio rating-radio" type="radio" value="3"
                                                   name="bc_rating">
                                            <label for="review-radio-rating-3"></label>
                                            <input id="review-radio-rating-2" class="review-radio rating-radio" type="radio" value="2"
                                                   name="bc_rating">
                                            <label for="review-radio-rating-2"></label>
                                            <input id="review-radio-rating-1" class="review-radio rating-radio" type="radio" value="1"
                                                   name="bc_rating">
                                            <label for="review-radio-rating-1"></label>
                                        </div>
                                        <span class="popup-book-mark hidden"></span>
                                    </div>
                                    <div style="padding-top: 7px;">

                                    </div>
                                </div>
                                <div class="tb-column-sep"></div>
                                <div class="tb-column-2"></div>
                            </tb>
                        </tr>
                        <tr>
                            <td>
                                <label class="label-form" for="review[title]">Заголовок рецензии</label>
                                <div class="form-input">
                                    <input id="title" type="text" maxlength="500" name="review[title]" value="">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="label-form" for="review[review]">Текст вашей рецензии</label>
                                <div class="form-texteditor hide-preview icons-button">
                                    <div id="tereview-container">
                                        <div class="text-editor-container" id="tereview-ed_editor">
                                            <div class="editor-textarea">
                                                <div class="textarea-outer">
                                                    <textarea class="ed_textarea  llcut" id="review" name="review[review]" rows="10" placeholder="Расскажите подробнее, чем вам понравилась книга, стараясь не раскрывать сюжет (не спойлерите)"></textarea>
                                                </div>
                                                <br>
                                                <div class="text-editor-separator"></div>
                                                <div class="separator"></div>
                                            </div>
                                            <div></div>
                                            <div class="ed_preview" id="tereview-preview" style="display:none"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="with-mpad block-bottom block-border-t" id="user-posts-more">
                    <input type="button" class="btn-fill btn-wh right" id="create-review" value="Опубликовать">
                    <input type="button" class="btn-fill btn-wh right" value="Отмена" onclick="location.href='/views/reader/';">
                </div>
            </div>
            <input type="hidden" name="data-editor" value="<?=$_SESSION['user']['id_profile'];?>">
            <input type="hidden" name="data-book" value="<?=$book['id'];?>">
        </form>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>
