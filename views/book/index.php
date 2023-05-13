<?php session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/book/book.php';
$api = new TheBook\Book;
$book = $api->getSingleBookById($_GET['book']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах" name="description">

    <title><?php echo $book['title'] . " - " . $book['author']; ?> </title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script defer src="/assets/js/header.js"></script>
    <script src="/assets/libs/swiper/swiper.min.js"></script>
    <script defer src="/assets/js/book.js"></script>

</head>

<body>

<?php
require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/template/actionpopup.php";
?>

<br>
<br>


<main class="main-body page-content book-card bc-new">
    <section class="bc-header">
        <div class="bc-header__bg-wrap">
            <img class="bc-header__bg" alt="" src="<?php echo $book['image'] ?>" style="width: 100%; height: auto;">
        </div>
        <div class="bc-header__wrap">
            <h1 class="bc__book-title"><?php echo $book['title']; ?></h1>
            <h2 class="bc-author"><?php echo $book['author']; ?></h2>
        </div>
    </section>
    <section class="bc__content">
        <div class="bc__wrapper">
            <div class="bc-menu">
                <div class="bc-menu__wrap">
                    <?php
                    if (!empty($_SESSION['user'])):
                        $action = $api->getActionForSession($book['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                        if (!empty($action)): ?>
                            <span class="bc-menu__status-wrapper">
                            <a class="bc-menu__status bc-menu__status-lists"><?php echo $action; ?></a>
                        </span>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="bc-menu__image-wrapper">
                        <img class="bc-menu__image" src="<?php echo $book['image']; ?>"
                             style="cursor: pointer;" width="100%" height="100%" alt="">
                    </div>
                    <div class="userbook-container" data-book-id="<?php echo $book['id']?>" data-book-name="<?php echo $book['title']; ?>">
                        <a class="btn-add-plus"></a>
                    </div>
                    <a class="bc-menu__btn" href="/views/review/create?book=<?php echo $book['id']?>">Написать рецензию</a>
                </div>
            </div>
            <article class="bc">
                <article class="bc-about">
                    <div class="bc-rating">
                        <a class="bc-rating-medium">
                            <?php $rating = $api->getBookRaiting($_GET['book']); ?>
                            <span><?php echo $rating; ?></span>
                        </a>
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
                            <input type="hidden">
                            <p>Моя оценка</p>
                            <span class="popup-book-mark" style=""><?php ?></span>
                        </div>
                    </div>
                    <div class="bc-stat">
                        <?php $stat = $api->getStatForSingleBook($_GET['book']); ?>
                        <a class="popup-load-data bc-stat__link">
                            <b><?php echo $stat['read']; ?></b>
                            Прочитали
                        </a>
                        <a class="popup-load-data bc-stat__link">
                            <b><?php echo $stat['wish']; ?></b>
                            Планируют
                        </a>
                        <a class="popup-load-data bc-stat__link">
                            <b><?php echo $stat['review']; ?></b>
                            Рецензий
                        </a>
                    </div>
                    <div class="bc-genre">
                        <ul class="bc-genre__list">
                            <?php for ($i = 0; $i < count($book['genres']); $i++): ?>
                                <li>
                                    <a href="/views/genres/"><?php echo $book['genres'][$i]; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                    <div class="bc-annotation">
                        <div class="escape-text"><?php echo $book['annotation']; ?></div>
                    </div>
                    <table class="bc-edition">
                        <tbody>
                        <?php if ($book['series'] != null): ?>
                            <tr>
                                <td class="bc-edition__header">Серия:</td>
                                <td class="bc-edition__link"><?php echo $book['series']; ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="bc-edition__header">Издательство:</td>
                            <td class="bc-edition__link"><?php echo $book['publishing']; ?></td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="bc-info">
                        <div class="bc-info__wrapper">
                            <label>Дополнительная информация</label>
                            <div>
                                <p>ISBN: <?php echo $book['ISBN']; ?></p>
                                <p>Год издания: <?php echo $book['year']; ?> г.</p>
                                <p>Страниц: <?php echo $book['pages']; ?> стр.</p>
                                <p>Язык: Русский</p>
                                <p>Возрастное ограничение: <?php echo $book['age']; ?>+</p>
                            </div>
                        </div>
                        <div class="bc-info__wrapper">
                            <label>Жанры</label>
                            <div>
                                <p>Жанры: <?php echo(implode(', ', $book['genres'])) ?></p>
                            </div>
                        </div>
                    </div>
                    <?php $allReview = $api->getAllReviewForSingleBook($_GET['book']);
                    if (count($allReview) > 0) :?>
                        <div class="bc-about__wrapper">
                            <h2 class="bc-about__title">Рецензии</h2>
                            <a>Всего <?php echo count($allReview); ?></a>

                            <?php foreach ($allReview as $review): ?>
                                <div class="review-card" style="margin-bottom: 25px; width: 100%;">
                                    <div class="header-card">
                                        <a class="header-card-user">
                                            <img class="header-card-user__avatar"
                                                 src="<?php echo $review['avatar_path'] ?>" alt="" width="100%"
                                                 height="100%">
                                        </a>
                                        <div class="header-card__wrapper">
                                            <div class="heade-card__row1">
                                                <a class="header-card-user__name">
                                                    <span><?php echo $review['login'] ?></span>
                                                </a>
                                                <a class="header-card__category"><?php if ($_SESSION['user']['gender'] == 'ж') {echo ' написала';} else {echo ' написал';} ?> рецензию</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lenta-card">
                                        <div class="lenta-card__details">
                                            <p class="lenta-card__date"><?php echo $review['date']; ?></p>
                                        </div>
                                        <h3 class="lenta-card__title">
                                            <span class="lenta-card__mymark"><?php echo $review['rating'] ?></span>
                                            <a><?php echo $review['title']; ?></a>
                                        </h3>
                                        <div class="lenta-card__text">
                                            <p><?php echo $review['text']; ?></p>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    $others = $api->getOtherAuthorBook($_GET['book'], $book['id_author']);
                    if (count($others) > 0):
                        ?>
                        <div class="bc-about__wrapper">
                            <h2 class="bc-about__title">Тот же автор</h2>
                            <div class="slide-book-carousel">
                                <div class="carousel-book swiper-container swiper-container-horizontal swiper-init">
                                    <ul class="swiper-wrapper" data-count="10"
                                        style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                                        <?php foreach ($others as $other): ?>
                                            <li class="swiper-slide carousel-book__item">
                                                <?php
                                                if (!empty($_SESSION['user'])):
                                                    $action = $api->getActionForSession($other['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                                    if (!empty($action)): ?>
                                                        <span class="bc-menu__status-wrapper">
                            <a class="bc-menu__status bc-menu__status-lists"><?php echo $action; ?></a>
                        </span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <a class="carousel-img__link"
                                                   href="/views/book/?book=<?php echo $other['id'] ?>">
                                                    <img src="<?php echo $other['image'] ?>" width="100%" height="auto"
                                                         alt="">
                                                </a>
                                                <div class="carousel-book__wrapper">
                                                    <a class="carousel-book__title"
                                                       href="/views/book/?book=<?php echo $other['id'] ?>"><?php echo $other['book'] ?></a>
                                                    <a class="carousel-book__author"><?php echo $other['name'] ?></a>
                                                    <div class="carousel-book__rating">
                                                        <?php $rating = $api->getBookRaiting($other['id']); ?>
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
                        </div>
                    <?php endif; ?>

                    <div class="bc-about__wrapper">
                        <h2 class="bc-about__title">Новинки книг</h2>
                        <?php $news = $api->getNewBook(); ?>
                        <div class="slide-book-carousel">
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
                            <a class="bc-menu__status bc-menu__status-lists"><?php echo $action; ?></a>
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
                    </div>
                </article>
            </article>
        </div>
    </section>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>
