<?php session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
}
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/book/book.php';
$api = new TheBook\Book;
$review = $api->getReviewById($_GET['review']);?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Редактирование рецензии</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/header.js" defer></script>
    <script src="/assets/js/profile.js" defer></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>

//ну здесь надо запилить эти звездочки и валидацию и автора забыла с оценкой средней

<main class="page-content-reader page-content main-body">
    <div class="wrapper-ugc" style="max-width: 816px; margin: 15px;">
        <form class="review-create-form">
            <div class="block-border card-block">
                <div class="group-title">
                    <h2>Редактировать рецензию</h2>
                </div>
                <div class="with-pad backgr-block review" style="margin-top: 0; flex-direction:row;">
                    <a href="/views/book/?book=<?php echo $review['id_book']?>">
                        <img src="<?php echo $review['image']?>" style="min-width: 100px; background-color: white; float: left;" width="100">
                    </a>
                    <div class="book-block-data" style="margin-left: 35px;">
                        <a class="post-scifi-title" href="/views/book/?book=<?php echo $review['id_book']?>"><?php echo $review['book'];?></a>
                        <br>
                        <a style="cursor:default; color: black;"><?php echo $review['author']; ?></a>
                        <br>
                        <div style="margin-top: 5px;">
                            <?php $genre = $api->getGenresForSingleBook($review['id_book']); for ($i = 0; $i < count($genre); $i++):?>
                                <a class="label-genre">
                                    <?php echo $genre[$i]; ?>
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
                                        <div class="bc-menu__stars bc-rating--full">
                                            <input id="book-radio-rating-5" class="rating-radio" type="radio" value="5"
                                                   name="bc_rating">
                                            <label for="book-radio-rating-5"></label>
                                            <input id="book-radio-rating-4" class="rating-radio" type="radio" value="4"
                                                   name="bc_rating">
                                            <label for="book-radio-rating-4"></label>
                                            <input id="book-radio-rating-3" class="rating-radio" type="radio" value="3"
                                                   name="bc_rating">
                                            <label for="book-radio-rating-3"></label>
                                            <input id="book-radio-rating-2" class="rating-radio" type="radio" value="2"
                                                   name="bc_rating">
                                            <label for="book-radio-rating-2"></label>
                                            <input id="book-radio-rating-1" class="rating-radio" type="radio" value="1"
                                                   name="bc_rating">
                                            <label for="book-radio-rating-1"></label>
                                        </div>
                                        <input name="mymark" type="hidden" value="<?php echo $review['rating']; ?>">
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
                                    <input id="title" type="text" maxlength="500" name="review[title]" value="<?php echo $review['title']; ?>">
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
                                                    <textarea class="ed_textarea  llcut" id="review" name="review[review]" rows="10" placeholder="Расскажите подробнее, чем вам понравилась книга, стараясь не раскрывать сюжет (не спойлерите)" ><?php echo strip_tags($review['text']); ?></textarea>
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
                        <tr>
                            <td class="block-border-t"></td>
                        </tr>
                        <tr>
                            <td style="padding-bottom:0;">
                                <label style="margin:0;" class="label-form" for="reviewremove"><input
                                        type="checkbox" id="reviewremove" name="review[remove]" value="yes"> Удалить рецензию</label>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="with-mpad block-bottom block-border-t" id="user-posts-more">
                    <input type="button" class="btn-fill btn-wh right" id="update-review" value="Опубликовать">
                    <input type="button" class="btn-fill btn-wh right" value="Отмена" onclick="location.href='/views/reader/';">
                </div>
            </div>
            <input type="hidden" name="data-editor" value="<?php echo $_SESSION['user']['id_profile'];?>">
            <input type="hidden" name="data-book" value="<?php echo $review['id_book'];?>">
            <input type="hidden" name="data-review" value="<?php echo $review['id_review'];?>">
        </form>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>
