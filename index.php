<?php
include 'api/controller/book/book.php';
session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах" name="description">

    <title>Библиотека им. Л.Н.Толстого</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script defer src="/assets/js/swiper.js"></script>
    <script src="/assets/libs/swiper/swiper.min.js"></script>

</head>

<body>

<?php
$api = new TheBook\Book;
require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<br>

<main class="main-body page-content">
    <article class="main-slider">
        <div class="main-slider__list carousel-banner swiper-container swiper-container-horizontal swiper-init">
            <div class="swiper-wrapper" data-count="15"
                 style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                <div class="swiper-slide" style="width: 100%; height: auto">
                    <img src="assets/images/root/9b6b07735b700af26deca758c2f8b43f-jpeg.webp" style="width:100px; height:100px;">
                </div>
                <div class="swiper-slide" style="width: 100%; height: auto">
                    <img src="assets/images/root/9b6b07735b700af26deca758c2f8b43f-jpeg.webp" style="width:100%; height:auto;">
                </div>
                <div class="swiper-slide" style="width: 100%; height: auto">
                    <img src="assets/images/root/9b6b07735b700af26deca758c2f8b43f-jpeg.webp" style="width:100%; height:auto;">
                </div>
            </div>
        </div>
    </article>


    <article class="main-block">
        <h2 class="main-block__title">Новинки книг</h2>

        <?php $news = $api->getNewBook(); ?>
        <div class="slide-book-carousel" style="margin: 0 0 3px 16px;">
            <div class="carousel-book swiper-container swiper-container-horizontal swiper-init">
                <ul class="swiper-wrapper" data-count="15"
                    style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                    <?php foreach ($news as $new): ?>
                        <li class="swiper-slide carousel-book__item">
                            <?php
                            if (!empty($_SESSION['user'])):
                                $action = $api->getActionForSession($new['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                if (!empty($action)): ?>
                                    <span class="bc-menu__status-wrapper">
                            <a class="bc-menu__status bc-menu__status-lists" href="/views/reader/<?php echo $action['href'] ?>/"><?php echo $action['action']; ?></a>
                        </span>
                                <?php endif; ?>
                            <?php endif; ?>
                            <a class="carousel-img__link"
                               href="/views/book/?book=<?php echo $new['id'] ?>">
                                <img src="<?php echo $new['image'] ?>" width="100%" height="auto"
                                     alt="">
                            </a>
                            <div class="carousel-book__wrapper">
                                <a class="carousel-book__title"
                                   href="/views/book/?book=<?php echo $new['id'] ?>"><?php echo $new['book'] ?></a>
                                <a class="carousel-book__author"><?php echo $new['name'] ?></a>
                                <div class="carousel-book__rating">
                                    <?php $rating = $api->getBookRaiting($new['id']); ?>
                                    <span><?php echo $rating; ?></span>
                                </div>
                                <div class="separator"></div>
                                <div class="userbook-container">
                                    <a class="btn-add-plus"></a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a class="next-carousel"></a>
                <a class="prev-carousel"></a>
            </div>
        </div>
    </article>


    <article class="main-block">
        <h2 class="main-block__title">Что почитать?</h2>

        <?php $news = $api->getNewBook(); ?>
        <div class="slide-book-carousel" style="margin: 0 0 3px 16px;">
            <div class="carousel-book swiper-container swiper-container-horizontal swiper-init">
                <ul class="swiper-wrapper" data-count="15"
                    style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                    <?php foreach ($news as $new): ?>
                        <li class="swiper-slide carousel-book__item">
                            <?php
                            if (!empty($_SESSION['user'])):
                                $action = $api->getActionForSession($new['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                if (!empty($action)): ?>
                                    <span class="bc-menu__status-wrapper">
                            <a class="bc-menu__status bc-menu__status-lists" href="/views/reader/<?php echo $action['href'] ?>/"><?php echo $action['action']; ?></a>
                        </span>
                                <?php endif; ?>
                            <?php endif; ?>
                            <a class="carousel-img__link"
                               href="/views/book/?book=<?php echo $new['id'] ?>">
                                <img src="<?php echo $new['image'] ?>" width="100%" height="auto"
                                     alt="">
                            </a>
                            <div class="carousel-book__wrapper">
                                <a class="carousel-book__title"
                                   href="/views/book/?book=<?php echo $new['id'] ?>"><?php echo $new['book'] ?></a>
                                <a class="carousel-book__author"><?php echo $new['name'] ?></a>
                                <div class="carousel-book__rating">
                                    <?php $rating = $api->getBookRaiting($new['id']); ?>
                                    <span><?php echo $rating; ?></span>
                                </div>
                                <div class="separator"></div>
                                <div class="userbook-container">
                                    <a class="btn-add-plus"></a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a class="next-carousel"></a>
                <a class="prev-carousel"></a>
            </div>
        </div>
    </article>

    <article class="main-block main-br">
        <h2 class="main-block__title">Лучшие рецензии</h2>
        <a href="/reviews/top" class="main-block__show-all">Всего 1.8М</a>
        <?php $reviews = $api->getAllReview(); ?>
        <div class="main-block__wrapper" style="margin: 0 0 3px 16px;">
            <div class="carousel-review  main-block__limiter swiper-container swiper-container-horizontal swiper-init">
                <ul class="main-block__list swiper-wrapper" data-count="20" Style="transform: translate3d(0px, 0px, 0px);transition-duration: 0ms;width: 2500px !important;">
                    <?php foreach ($reviews as $review): ?>
                    <li class="swiper-slide review-card lenta__item main-block__item">
                        <div class="header-card">
                            <a class="header-card-user">
                                <img class="header-card-user__avatar" src="<?php echo $review['avatar_path']; ?>" alt=""
                                     width="100%" height="100%">
                            </a>
                            <a class="header-card-user__name"><span><?php echo $review['login']; ?></span></a>
                            <a class="header-card__category">написал рецензию</a>

                        </div>
                        <div class="lenta-card">
                            <div class="lenta-card-book">
                                <img class="lenta-card-book__bg" src="<?php echo $review['image']; ?>"
                                     alt="<?php echo $review['book']; ?>" width="100%" height="auto">
                                <a class="lenta-card-book__link" href="/views/book/?book=<?php echo $review['id_book'] ?>">
                                    <img class="lenta-card-book__img" src="<?php echo $review['image']; ?>" width="100%"
                                         height="100%">
                                </a>
                                <div class="lenta-card-book__wrapper">
                                    <a class="lenta-card__book-title"
                                       href="/views/book/?book=<?php echo $review['id_book'] ?>"><?php echo $review['book']; ?></a>
                                    <p class="lenta-card__author-wrap">
                                        <a class="lenta-card__author"><?php echo $review['author']; ?></a>
                                    </p>
                                    <?php $middle = $api->getBookRaiting($review['id_book']); ?>
                                    <div class="lenta-card__rating">
                                        <span style="font-size: 22px;"><?php echo $middle; ?></span>
                                    </div>
                                    <div class="userbook-container ub-container">
                                        <a class="btn-add-plus"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="lenta-card__details">
                                <p class="lenta-card__date">
                                    <?php echo $review['date']; ?>
                                </p>
                            </div>
                            <h3 class="lenta-card__title">
                                <span class="lenta-card__mymark"><?php echo $review['rating']; ?></span>
                                <a href=""><?php echo $review['title']; ?></a>
                            </h3>
                            <div class="lenta-card__text">
                                    <p><?php echo $review['text']; ?></p>
                            </div>
                            <a href="/review/3404197-pryazha-penelopy-kler-nort" class="btn__read-more">Читать полностью</a>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a class="next-carousel"></a>
                <a class="prev-carousel"></a>
            </div>
        </div>
    </article>


</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>