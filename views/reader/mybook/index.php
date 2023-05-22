<?php session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
}
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/user/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/book/book.php';?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Мои книги</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="/assets/js/book.js" defer></script>
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

    $read = $book['read'];
    $reading = $book['reading'];
    $wish = $book['wish']; ?>
    <div class="wrapper-ugc" style="max-width: 816px; margin: 15px;">
        <h1>Мои книги</h1>
        <?php if (!isset($read) || !empty($read)): ?>
            <div class="block-border card-block">
                <div class="group-title">
                    <h2>
                        <a href="/views/reader/read/"><?php if ($_SESSION['user']['gender'] == 'ж') {echo 'Прочитала';} else {echo 'Прочитал';} ?></a>
                    </h2>
                </div>
                <div class="with-pad group-review">
                    <div class="slide-book-carousel">
                        <div class="swiper-container carousel-book swiper-carousel-selections swiper-carousel swiper-carousel-books without-pagination without-arrows swiper-container-horizontal swiper-init">
                            <ul class="swiper-wrapper">
                                <?php foreach ($read as $reads): ?>
                                    <li class="swiper-slide carousel-book__item" style="width: 186px; margin-right: 15px; margin-top: 0;">
                                        <a class="carousel-img__link" title="<?=$reads['title']?>" href="/views/book/?book=<?=$reads['id']?>">
                                            <img src="<?=$reads['image']?>" alt="<?=$reads['title']?>" width="100%" height="auto">
                                        </a>
                                        <div class="carousel-book__wrapper">
                                            <a class="carousel-book__title" href="/views/book/?book=<?=$reads['id']?>"><?=$reads['title']?></a>
                                            <a class="carousel-book__author"><?=$reads['author']?></a>
                                            <?php
                                                $mymark = $api->getMyMark($reads['id'], $_SESSION['user']['id_profile']);
                                                $action = $api->getActionForSession($reads['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                                $review = $api->getExistReview($reads['id'], $_SESSION['user']['id_profile']);
                                                $reviewId = $api->getReviewId($reads['id'], $_SESSION['user']['id_profile']);
                                                $rating = $api->getBookRating($reads['id']);?>
                                             <div class="carousel-book__rating">
                                                <span><?php echo $rating?></span>
                                            </div>
                                            <?php if (!empty($mymark)):?>
                                                <div class="lists__mymark"><?=$mymark['rating']?></div>
                                            <?php endif; ?>
                                            <div class="separator"></div>
                                            <div class="userbook-container-<?=$reads['id']?>"
                                                 data-book-id="<?=$reads['id']?>"
                                                 data-book-name="<?=$reads['title']?>"
                                                 data-action="<?=$action['id']?>"
                                                 data-profile="<?=$_SESSION['user']['id_profile']?>"
                                                 data-review = "<?=$reviewId?>"
                                                 data-mark="<?=$mymark['rating']?>"
                                                 data-session="<?=$_SESSION['user']['id_profile']?>"
                                                 data-exist-review="<?=$review?>"
                                                 data-exist-action="<?php if (!empty($action)){echo 1;}else{echo 0;} ?>" >
                                                <a class="btn-add-plus <?php if (!empty($action)){echo 'btn-add-plus--add';}?>"></a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <a class="next-carousel"></a>
                            <a class="prev-carousel"></a>
                        </div>
                    </div>
                </div>
                <?php if (count($read) > 22): ?>
                <div class="with-mpad block-bottom block-border-t" id="user-posts-more">
                    <input type="button" class="btn-fill btn-wh right" value="Показать всё" onclick="location.href='/views/reader/read/';">
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>


        <?php if (!isset($wish) || !empty($wish)): ?>
            <div class="block-border card-block">
                <div class="group-title">
                    <h2>
                        <a href="/views/reader/wish/">Хочу прочитать</a>
                    </h2>
                </div>
                <div class="with-pad group-review">
                    <div class="slide-book-carousel">
                        <div
                            class="swiper-container carousel-book swiper-carousel-selections swiper-carousel swiper-carousel-books without-pagination without-arrows swiper-container-horizontal swiper-init">
                            <ul class="swiper-wrapper">
                                <?php foreach ($wish as $wishs): ?>
                                    <li class="swiper-slide carousel-book__item" style="width: 186px; margin: 0;">
                                        <a class="carousel-img__link" title="<?=$wishs['title']?>" href="/views/book/?book=<?=$wishs['id']?>">
                                            <img src="<?=$wishs['image']?>" alt="<?=$wishs['title']?>" width="100%" height="auto">
                                        </a>
                                        <div class="carousel-book__wrapper">
                                            <a class="carousel-book__title" href="/views/book/?book=<?=$wishs['id']?>"><?=$wishs['title']?></a>
                                            <a class="carousel-book__author"><?=$wishs['author']?></a>
                                            <div class="carousel-book__rating">
                                                <?php $action = $api->getActionForSession($wishs['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                                $review = $api->getExistReview($wishs['id'], $_SESSION['user']['id_profile']);
                                                $reviewId = $api->getReviewId($wishs['id'], $_SESSION['user']['id_profile']);
                                                $rating = $api->getBookRating($wishs['id']); ?>
                                                <span><?php echo $rating; ?></span>
                                            </div>
                                            <div class="separator"></div>
                                            <div class="userbook-container-<?=$reads['id']?>"
                                                 data-book-id="<?php echo $wishs['id']?>"
                                                 data-book-name="<?=$wishs['title']?>"
                                                 data-action="<?=$action['id']?>"
                                                 data-profile="<?=$_SESSION['user']['id_profile']?>"
                                                 data-review = "<?=$reviewId?>"
                                                 data-exist-review="<?=$review?>"
                                                 data-exist-action="<?php if (!empty($action)){echo 1;}else{echo 0;} ?>">
                                                <a class="btn-add-plus <?php if (!empty($action)){echo 'btn-add-plus--add';}?>"></a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <a class="next-carousel"></a>
                            <a class="prev-carousel"></a>
                        </div>
                    </div>
                </div>
                <?php if (count($wish) > 22): ?>
                <div class="with-mpad block-bottom block-border-t" id="user-posts-more">
                    <input type="button" class="btn-fill btn-wh right" value="Показать всё" onclick="location.href='/views/reader/wish/';">
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>


        <?php if (!isset($reading) || !empty($reading)): ?>
            <div class="block-border card-block">
                <div class="group-title">
                    <h2>
                        <a href="/views/reader/reading/">Читаю сейчас</a>
                    </h2>
                </div>
                <div class="with-pad group-review">
                    <div class="slide-book-carousel">
                        <div
                            class="swiper-container carousel-book swiper-carousel-selections swiper-carousel swiper-carousel-books without-pagination without-arrows swiper-container-horizontal swiper-init">
                            <ul class="swiper-wrapper">
                                <?php foreach ($reading as $readings): ?>
                                    <li class="swiper-slide carousel-book__item" style="width: 186px; margin: 0;">
                                        <a class="carousel-img__link" title="<?=$readings['title']?>" href="/views/book/?book=<?=$readings['id']?>">
                                            <img src="<?=$readings['image']; ?>" alt="<?=$readings['title']?>" width="100%" height="auto">
                                        </a>
                                        <div class="carousel-book__wrapper">
                                            <a class="carousel-book__title" href="/views/book/?book=<?=$readings['id']?>"><?=$readings['title']?></a>
                                            <a class="carousel-book__author"><?=$readings['author']?></a>
                                            <div class="carousel-book__rating">
                                                <?php $action = $api->getActionForSession($readings['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                                $review = $api->getExistReview($readings['id'], $_SESSION['user']['id_profile']);
                                                $rating = $api->getBookRating($readings['id']);
                                                $reviewId = $api->getReviewId($readings['id'], $_SESSION['user']['id_profile']);?>
                                                <span><?php echo $rating;?></span>
                                            </div>
                                            <div class="separator"></div>
                                            <div class="userbook-container-<?=$reads['id']?>"
                                                 data-book-id="<?=$readings['id']?>"
                                                 data-book-name="<?=$readings['title']?>"
                                                 data-action="<?=$action['id']?>"
                                                 data-profile="<?=$_SESSION['user']['id_profile']?>"
                                                 data-review = "<?=$reviewId?>"
                                                 data-exist-review="<?=$review?>"
                                                 data-exist-action="<?php if (!empty($action)){echo 1;}else{echo 0;} ?>" >
                                                <a class="btn-add-plus <?php if (!empty($action)){echo 'btn-add-plus--add';}?>"></a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <a class="next-carousel"></a>
                            <a class="prev-carousel"></a>
                        </div>
                    </div>
                </div>
                <?php if (count($reading) > 22): ?>
                <div class="with-mpad block-bottom block-border-t" id="user-posts-more">
                    <input type="button" class="btn-fill btn-wh right" value="Показать всё" onclick="location.href='/views/reader/reading/';">
                </div>
            </div>
            <?php endif; ?>
        <?php endif; ?>


        <?php if (empty($read) && empty($reading) && empty($wish)): ?>
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
