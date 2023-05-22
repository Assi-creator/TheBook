<?php session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
}
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/book/book.php';?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Читаю сейчас</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/profile.js" defer></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/template/actionpopup.php";?>

<br>
<br>
<main class="page-content-reader page-content main-body">
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/profileheader.php"; ?>
    <?php $api = new TheBook\controller\Book;
    $book = $api->getAllProfileBook($_SESSION['user']['id_profile']);
    $reading = $book['reading']; ?>
    <div class="wrapper-ugc" style="max-width: 816px; margin: 15px;">
        <h1>Читаю сейчас</h1>
        <?php if (!empty($reading)): ?>
            <div class="blist-biglist" id="booklist">
                <?php foreach ($reading as $reads): ?>
                    <div class="book-item-manage">
                        <div class="block-border card-block brow">
                            <div class="brow-inner">
                                <div class="brow-cover">
                                    <div class="cover-wrapper">
                                        <a href="/views/book/?book=<?=$reads['id']?>" title="<?=$reads['title']?>">
                                            <img class="cover-rounded" src="<?=$reads['image']?>" style="min-width: 140px; background-color: #ffffff;" width="140" alt="<?=$reads['title']?>">
                                        </a>
                                    </div>
                                    <?php
                                    $action = $api->getActionForSession($reads['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                    $review = $api->getExistReview($reads['id'], $_SESSION['user']['id_profile']);
                                    $reviewId = $api->getReviewId($reads['id'], $_SESSION['user']['id_profile']);
                                    $rating = $api->getBookRating($reads['id']); ?>
                                    <div class="book-data">
                                        <div class="userbook-container-<?=$reads['id']?>"
                                             data-book-id="<?=$reads['id']?>"
                                             data-book-name="<?=$reads['title']?>"
                                             data-action="<?=$action['id']?>"
                                             data-profile="<?=$_SESSION['user']['id_profile']?>"
                                             data-review = "<?=$reviewId?>"
                                             data-session="<?=$_SESSION['user']['id_profile']?>"
                                             data-exist-review="<?=$review?>"
                                             data-exist-action="<?php if (!empty($action)){echo 1;}else{echo 0;} ?>">
                                            <a class="btn-add-plus <?php if (!empty($action)){echo 'btn-add-plus--add';}?>"></a>
                                        </div>
                                    </div>
                                    <div class="separator"></div>
                                    <input type="hidden" name="reviewID" class="reviewID" id="reviewID" value="<?=$reviewId?>">
                                </div>
                                <div class="brow-data">
                                    <div>
                                        <a class="brow-book-name with-cycle" href="/views/book/?book=<?=$reads['id']?>"><?=$reads['title']?></a>
                                        <div style="padding-top: 8px;"></div>
                                        <p class="brow-book-author"><?=$reads['author']?></p>
                                        <div class="brow-genres">
                                            <?php $genre = $api->getGenresForSingleBook($reads['id']);
                                            $stats = $api->getStatForSingleBook($reads['id']);
                                            for ($i = 0; $i < count($genre); $i++):?>
                                                <a class="label-genre" href="/views/genres/genre?genre=<?=$genre[$i]['id_genre']?>">
                                                    <?=$genre[$i]['name']?>
                                                </a>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="brow-rating" style="font-size: 17px;">
                                            <span>Средняя оценка: <?=$rating?> &#9733;</span>
                                        </div>
                                        <div class="brow-stats">
                                            <a style="cursor: default">
                                                <span class="i-cusers opc-054"></span> <?=$stats['read']?>
                                                прочитали
                                            </a>
                                            <a href="/views/book/review?book=<?=$reads['id']?>">
                                                <span class="i-creviews opc-054"></span> <?=$stats['review']?>
                                                рецензий
                                            </a>
                                        </div>
                                        <div class="brow-details">
                                            <table class="compact">
                                                <tbody>
                                                <tr>
                                                    <td style="font-weight: bold;padding-right: 6px;">ISBN:</td>
                                                    <td>
                                                        <span itemprop="isbn"><?=$reads['ISBN'] ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;padding-right: 6px;">Год издания:</td>
                                                    <td><?=$reads['year'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;padding-right: 6px;">Издательство:</td>
                                                    <td>
                                                        <span itemprop="publisher"><p><?=$reads['publishing'] ?></p></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;padding-right: 6px;">Язык:</td>
                                                    <td>Русский</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="brow-marg">
                                            <p><?=$reads['annotation']?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="separator"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div id="es-top-wrapper" class="block-border card-block es-top-wrapper for-books">
                <div class="with-pads">
                    <div class="es-img">
                        <img src="/assets/images/root/icons/wish.svg">
                    </div>
                    <div class="es-data">
                        Ваш список пока пуст!
                        <br>
                        <br>
                        Выберите свой любимый <a href="/views/genres/">Жанр</a>, там Вы гарантированно найдете интересные книги.
                    </div>
                    <div class="separator"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>

