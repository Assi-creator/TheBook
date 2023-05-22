<?php session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/api/controller/book/book.php";
include $_SERVER['DOCUMENT_ROOT'] . "/api/controller/user/user.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Рецензии на книгу</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/profile.js" defer></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<br>
<main class="page-content-reader page-content main-body">

    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/template/actionpopup.php";

    $book = new TheBook\controller\Book;
    $reviews = $book->getAllReview(); ?>

    <form id="userbook-form-div" class="section-form">
        <div class="section-form__wrap">
            <h1 class="section-form__title">Рецензии</h1>
            <div class="section-form__search">
                <input id="section-form-search" type="search" name="filter-search" placeholder="Искать" autofocus="" value="">
                <a class="section-form__search-btn"></a>
            </div>
        </div>
        <input type="checkbox" class="section-form__toggle" id="section-form__toggle" checked="checked">
        <label for="section-form__toggle"></label>
        <div class="section-form__inner">
            <div class="section-form__select">
                <details class="ll-details-closed" style="z-index: 111111;">
                    <summary>
                        Жанр
                    </summary>
                    <div>
                        <a data-value="0">Все</a>
                        <?php $genre = $book->getAllSubgenres();
                        for ($i = 0; $i < count($genre); $i++):?>
                            <a data-value="<?php echo $genre[$i]['id_title']; ?>"><?php echo $genre[$i]['name']; ?></a>
                        <?php endfor; ?>
                    </div>
                </details>
                <input id="genre-input" type="hidden" name="filter-genre-id" value="">
            </div>
            <div class="section-form__select">
                <details class="ll-details-closed" style="z-index: 1111;">
                    <summary>
                        Оценка
                    </summary>
                    <div>
                        <a data-value="all-rating">Все</a>
                        <a data-value="plus">Нравится</a>
                        <a data-value="zero">Нормально</a>
                        <a data-value="minus">Не нравится</a>
                    </div>
                </details>
                <input id="rating-input" type="hidden" name="filter-rating" value="">
            </div>
            <div class="section-form__select">
                <details class="ll-details-closed" style="z-index: 111;">
                    <summary>
                        Дата
                    </summary>
                    <div>
                        <a data-value="0">Все</a>
                        <a data-value="1">Месяц</a>
                        <a data-value="3">3 месяца</a>
                        <a data-value="6">Полгода</a>
                        <a data-value="12">Год</a>
                        <a data-value="24">Позднее</a>
                    </div>
                </details>
                <input id="month-input" type="hidden" name="filter-month" value="">
            </div>
            <div class="section-form__select">
                <details class="ll-details-closed" style="z-index: 111;">
                    <summary>
                        По дате добавления
                    </summary>
                    <div>
                        <a data-value="date">По дате добавления</a>
                        <a data-value="rating">По рейтингу книги</a>
                    </div>
                </details>
                <input id="order-input" type="hidden" name="filter-order" value="">
            </div>
        </div>
    </form>

    <section class="lenta-content" style="margin: 0 auto;">
        <div class="lenta__list" id="book-reviews">
            <?php foreach ($reviews as $review): ?>
                <article class="review-card lenta__item" style="padding-bottom: 35px;">
                    <div class="header-card">
                        <a class="header-card-user">
                            <img class="header-card-user__avatar" src="<?php echo $review['avatar_path']; ?>" alt="" width="100%" height="100%">
                        </a>
                        <a class="header-card-user__name"><span><?php echo $review['login']; ?></span></a>
                        <a class="header-card__category"><?php if ($review['gender'] == 'ж') {echo ' написала';} else {echo ' написал';} ?> рецензию</a>
                        <?php if($_SESSION['user']['id_profile'] == $review['id_profile']): ?>
                            <div class="header-card__menu">
                                <div class="header-card__menu-block">
                                    <a href="/views/review/edit?review=<?php echo $review['id_review']; ?>" title="Редактировать рецензию">Редактировать</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="lenta-card">
                        <div class="lenta-card-book">
                            <img class="lenta-card-book__bg" src="<?php echo $review['image']; ?>"
                                 alt="<?php echo $review['book']; ?>" width="100%" height="auto">
                            <a class="lenta-card-book__link" href="/views/book/?book=<?php echo $review['id_book'] ?>">
                                <img class="lenta-card-book__img" src="<?php echo $review['image']; ?>" width="100%" height="100%">
                            </a>
                            <div class="lenta-card-book__wrapper">
                                <a class="lenta-card__book-title"
                                   href="/views/book/?book=<?php echo $review['id_book'] ?>"><?php echo $review['book']; ?></a>
                                <p class="lenta-card__author-wrap">
                                    <a class="lenta-card__author"><?php echo $review['author']; ?></a>
                                </p>
                                <?php
                                $reviewId = $book->getReviewId($review['id_book'], $_SESSION['user']['id_profile']);
                                $middle = $book->getBookRating($review['id_book']);
                                $action = $book->getActionForSession($review['id_book'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                $reviewa = $book->getExistReview($review['id_book'], $_SESSION['user']['id_profile']);
                                $reviewId = $book->getReviewId($review['id_book'], $_SESSION['user']['id_profile']);
                                $rating = $book->getBookRating($review['id_book']); ?>
                                <?php $middle = $book->getBookRating($review['id_book']); ?>
                                <div class="lenta-card__rating">
                                    <span style="font-size: 22px;"><?php echo $middle; ?></span>
                                </div>

                                <div class="userbook-container-<?php echo $review['id_book'];?>" data-book-id="<?php echo $review['id_book'];?>"
                                     data-book-name="<?php echo $review['book']; ?>"
                                     data-action="<?php echo $action['id']; ?>"
                                     data-profile="<?php echo $_SESSION['user']['id_profile']; ?>"
                                     data-review = "<?php echo $reviewId;?>"
                                     data-mark = "<?php echo $review['rating'];?>"
                                     data-exist-review="<?php echo $reviewa;?>"
                                     data-session="<?php echo $_SESSION['user']['id_profile']; ?>"
                                     data-exist-action="<?php if (!empty($action)){echo 1;}else{echo 0;} ?>">
                                    <a class="btn-add-plus <?php if (!empty($action)){echo 'btn-add-plus--add';}?>"></a>
                                </div>
                            </div>
                        </div>
                        <div class="lenta-card__details">
                            <p class="lenta-card__date">
                                <?php echo formatDate($review['date']); ?>
                            </p>
                        </div>
                        <h3 class="lenta-card__title">
                            <span class="lenta-card__mymark"><?php echo $review['rating']; ?></span>
                            <a href=""><?php echo $review['title']; ?></a>
                        </h3>
                        <div class="lenta-card__text">
                            <div id="lenta-card__text-review-escaped" style="max-height: 220px;">
                                <p><?php echo $review['text']; ?></p>
                            </div>
                        </div>
                        <input type="hidden" name="reviewID" class="reviewID" id="reviewID" value="<?php echo $review['id_review'];?>">
                    </div>
                </article>
            <?php endforeach; ?>
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