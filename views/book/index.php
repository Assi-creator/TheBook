<?php session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/book/book.php';
$api = new TheBook\Book;
$book = $api->getSingleBookById($_GET['book']);
$action = $api->getActionForSession($book['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
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

//разобраться с оценкой, в карусели внизу подправить вывод средней оценки и сделать страницу со всеми рецензиями для этой книги также выводить только 5 крутых рецензий и сворачивать их до определенного слова написать рецензцию изменить на изменить рецензию если она уже есть... модальное окно....
<br>
<br>


<main class="main-body page-content book-card bc-new">
    <section class="bc-header">
        <div class="bc-header__bg-wrap">
            <img class="bc-header__bg" src="<?php echo $book['image'] ?>" style="width: 100%; height: auto;">
        </div>
        <div class="bc-header__wrap">
            <h1 class="bc__book-title"><?php echo $book['title']; ?></h1>
            <h2 class="bc-author"><?php echo $book['author']; ?></h2>
            <ul class="bc-header__list">
                <li>
                    <a class="bc-header__link bc-detailing-about bc-header__link--active">
                        Описание
                    </a>
                </li>
                <li>
                    <a class="bc-header__link bc-detailing-review" href="/views/book/review?book=<?php echo $book['id']; ?>">
                        Рецензии
                    </a>
                </li>
            </ul>
        </div>
    </section>
    <section class="bc__content">
        <div class="bc__wrapper">
            <div class="bc-menu">
                <div class="bc-menu__wrap">
                    <?php
                    if (!empty($_SESSION['user'])):
                        if (!empty($action)): ?>
                            <span class="bc-menu__status-wrapper">
                            <a class="bc-menu__status bc-menu__status-lists" href="/views/reader/<?php echo $action['href'] ?>/"><?php echo $action['action']; ?></a>
                        </span>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="bc-menu__image-wrapper">
                        <img class="bc-menu__image" title="<?php echo $book['title']; ?>" src="<?php echo $book['image']; ?>"
                             style="cursor: pointer;" width="100%" height="100%" alt="">
                    </div>
                    <?php $action = $api->getActionForSession($book['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                    $review = $api->getExistReview($book['id'], $_SESSION['user']['id_profile']);
                    $reviewId = $api->getReviewId($book['id'], $_SESSION['user']['id_profile']);
                    $rating = $api->getBookRaiting($book['id']); ?>
                    <div class="userbook-container" data-book-id="<?php echo $book['id'];?>"
                         data-book-name="<?php echo $book['title']; ?>"
                         data-action="<?php echo $action['id']; ?>"
                         data-profile="<?php echo $_SESSION['user']['id_profile']; ?>"
                         data-review = "<?php echo $reviewId;?>"
                         data-exist-review="<?php echo $review;?>"
                         data-exist-action="<?php if (!empty($action)){echo 1;}else{echo 0;} ?>">
                        <a class="btn-add-plus <?php if (!empty($action)){echo 'btn-add-plus--add';}?>"></a>
                    </div>
                    <?php
                    if (!empty($review)){$exist=1;}else{$exist=0;}
                    if($exist == 1): ?>
                    <a class="bc-menu__btn" style="font-size: 12px; text-align: center;" href="/views/review/edit?review=<?php echo $reviewId;?>">Редактировать рецензию</a>
                    <?php else: ?>
                    <a class="bc-menu__btn" href="/views/review/create?book=<?php echo $book['id']?>">Написать рецензию</a>
                    <?php endif; ?>
                </div>
            </div>
            <article class="bc">
                <article class="bc-about">
                    <div class="bc-rating">
                        <a class="bc-rating-medium">
                            <?php
                            $mymark = $api->getMyMark($book['id'], $_SESSION['user']['id_profile']);
                            $rating = $api->getBookRaiting($_GET['book']); ?>
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
                            <input type="hidden" value="<?php echo $mymark[0]['rating'];?>">
                            <p>Моя оценка</p>
                            <span class="popup-book-mark" style=""><?php echo $mymark[0]['rating'];?></span>
                        </div>
                    </div>
                    <div class="bc-stat">
                        <?php $stat = $api->getStatForSingleBook($_GET['book']); ?>
                        <a class="popup-load-data bc-stat__link" style="cursor: default">
                            <b><?php echo $stat['read']; ?></b>
                            Прочитали
                        </a>
                        <a class="popup-load-data bc-stat__link" style="cursor: default">
                            <b><?php echo $stat['wish']; ?></b>
                            Планируют
                        </a>
                        <a class="popup-load-data bc-stat__link" href="/views/book/review?book=<?php echo $book['id']; ?>">
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


                    <?php $allReview = $api->getTopReviewsForSingleBook($_GET['book']);
                    if (count($allReview) > 0) :?>
                        <div class="bc-about__wrapper">
                            <h2 class="bc-about__title">Рецензии</h2>
                            <a href="/views/book/review?book=<?php echo $book['id']; ?>">Всего <?php echo count($allReview); ?></a>

                            <?php foreach ($allReview as $review): ?>
                                <div class="book-review" style="margin-bottom: 25px; width: 100%;">
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
                                    <div class="lenta-card lenta-review" style="margin: 0 8px;">
                                        <div class="lenta-card__details">
                                            <p class="lenta-card__date"><?php echo formatDate($review['date']); ?></p>
                                        </div>
                                        <h3 class="lenta-card__title">
                                            <span class="lenta-card__mymark"><?php echo $review['rating'] ?></span>
                                            <a href="/views/review/single?review=<?php echo $review['id_review']?>"><?php echo $review['title']; ?></a>
                                        </h3>
                                        <div class="lenta-card__text">
                                            <div id="lenta-card__text-review-escaped" style="max-height: 220px;">
                                                <p><?php echo $review['text']; ?></p>
                                            </div>
                                            <div id="lenta-card__text-review-fulltext" class="hidden">
                                                <p><?php echo $review['text']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    $simples = $api->getSimpleBook($book['id'], $book['title'], $book['id_author']);
                    if (count($simples) > 0): ?>
                        <div class="bc-about__wrapper">
                            <h2 class="bc-about__title">Издания и произведения</h2>
                            <div class="slide-book-carousel">
                                <div class="carousel-book swiper-container swiper-container-horizontal swiper-init">
                                    <ul class="swiper-wrapper" data-count="10"
                                        style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                                        <?php foreach ($simples as $simple): ?>
                                            <li class="swiper-slide carousel-book__item">
                                                <?php
                                                if (!empty($_SESSION['user'])):
                                                    $action = $api->getActionForSession($simple['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                                    if (!empty($action)): ?>
                                                        <span class="bc-menu__status-wrapper">
                                                            <a class="bc-menu__status bc-menu__status-lists" href="/views/reader/<?php echo $action['href'] ?>/"><?php echo $action['action']; ?></a>
                                                        </span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <a class="carousel-img__link"
                                                   href="/views/book/?book=<?php echo $simple['id'] ?>">
                                                    <img src="<?php echo $simple['image'] ?>" width="100%" height="auto"
                                                         alt="">
                                                </a>
                                                <div class="carousel-book__wrapper">
                                                    <a class="carousel-book__title"
                                                       href="/views/book/?book=<?php echo $simple['id'] ?>"><?php echo $simple['book'] ?></a>
                                                    <a class="carousel-book__author"><?php echo $simple['author'] ?></a>
                                                    <div class="carousel-book__rating">
                                                        <?php $rating = $api->getBookRaiting($simple['id']); ?>
                                                        <span><?php echo $rating; ?></span>
                                                    </div>
                                                    <?php $mymark = $api->getMyMark($simple['id'], $_SESSION['user']['id_profile']);
                                                    if (!empty($mymark)):?>
                                                        <div class="lists__mymark"><?php echo $mymark[0]['rating']; ?></div>
                                                    <?php endif; ?>
                                                    <div class="separator"></div>
                                                    <?php
                                                        $action = $api->getActionForSession($simple['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                                        $rating = $api->getMyMark($simple['id'], $_SESSION['user']['id_profile']);
                                                        $review = $api->getExistReview($simple['id'], $_SESSION['user']['id_profile']);
                                                        $reviewId = $api->getReviewId($simple['id'], $_SESSION['user']['id_profile']);?>
                                                    <div class="userbook-container" data-book-id="<?php echo $simple['id']?>"
                                                         data-book-name="<?php echo $simple['book']; ?>"
                                                         data-action="<?php echo $action['id']; ?>"
                                                         data-profile="<?php echo $_SESSION['user']['id_profile']; ?>"
                                                         data-review = "<?php echo $reviewId;?>"
                                                         data-exist-review="<?php echo $review; ?>"
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
                            <a class="bc-menu__status bc-menu__status-lists" href="/views/reader/<?php echo $action['href'] ?>/"><?php echo $action['action']; ?></a>
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
                                                    <?php $mymark = $api->getMyMark($other['id'], $_SESSION['user']['id_profile']);
                                                    if (!empty($mymark)):?>
                                                    <div class="lists__mymark"><?php echo $mymark[0]['rating']; ?></div>
                                                    <?php endif; ?>
                                                    <div class="separator"></div>
                                                    <?php
                                                    $action = $api->getActionForSession($other['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                                    $rating = $api->getMyMark($other['id'], $_SESSION['user']['id_profile']);
                                                    $review = $api->getExistReview($other['id'], $_SESSION['user']['id_profile']);
                                                    $reviewId = $api->getReviewId($other['id'], $_SESSION['user']['id_profile']);?>
                                                    <div class="userbook-container" data-book-id="<?php echo $other['id']?>"
                                                         data-book-name="<?php echo $other['book']; ?>"
                                                         data-action="<?php echo $action['id']; ?>"
                                                         data-profile="<?php echo $_SESSION['user']['id_profile']; ?>"
                                                         data-review = "<?php echo $reviewId;?>"
                                                         data-exist-review="<?php echo $review; ?>"
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
                                                <?php $mymark = $api->getMyMark($new['id'], $_SESSION['user']['id_profile']);
                                                if (!empty($mymark)):?>
                                                    <div class="lists__mymark"><?php echo $mymark[0]['rating']; ?></div>
                                                <?php endif; ?>
                                                <div class="separator"></div>
                                                <?php
                                                $action = $api->getActionForSession($new['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                                $rating = $api->getMyMark($new['id'], $_SESSION['user']['id_profile']);
                                                $review = $api->getExistReview($new['id'], $_SESSION['user']['id_profile']);
                                                $reviewId = $api->getReviewId($new['id'], $_SESSION['user']['id_profile']);?>
                                                <div class="userbook-container" data-book-id="<?php echo $new['id']?>"
                                                     data-book-name="<?php echo $new['book']; ?>"
                                                     data-action="<?php echo $action['id']; ?>"
                                                     data-profile="<?php echo $_SESSION['user']['id_profile']; ?>"
                                                     data-review = "<?php echo $reviewId;?>"
                                                     data-exist-review="<?php echo $review; ?>"
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
                </article>
            </article>
        </div>
    </section>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>

<?php
function formatDate($date) {
    $months = array(
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря'
    );
    $parts = explode(' ', $date);
    $dateParts = explode('-', $parts[0]);
    $timeParts = explode(':', $parts[1]);
    $day = (int)$dateParts[2];
    $month = $months[(int)$dateParts[1]-1];
    $year = (int)$dateParts[0];
    $hour = $timeParts[0];
    $minutes = $timeParts[1];
    return "$day $month $year г. $hour:$minutes";
}?>
