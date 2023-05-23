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

        <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/actionpopup.php";
        $book = new TheBook\controller\Book;
        $reviews = $book->getAllReview(); ?>

        <form id="userbook-form-div" class="section-form">
            <div class="section-form__wrap">
                <h1 class="section-form__title">Рецензии</h1>
                <div class="section-form__search">
                    <input id="section-form-search" CLASS="focus" type="search" name="filter-search" placeholder="Искать" autofocus="" value="">
                    <a class="section-form__search-btn"></a>
                </div>
            </div>
            <input type="checkbox" class="section-form__toggle" id="section-form__toggle" checked="checked">
            <label for="section-form__toggle"></label>
            <div class="section-form__inner">
                <div class="section-form__select">
                    <details class="ll-details-closed" style="z-index: 111111;">
                        <summary id="genre">
                            Жанр
                        </summary>
                        <div>
                            <a data-value="0" onclick="$('#genre-input').val($(this).data('value')); $('#genre').text($(this).text())">Все</a>
                            <?php $genre = $book->getAllSubgenres();
                            for ($i = 0; $i < count($genre); $i++):?>
                                <a data-value="<?=$genre[$i]['id_title']; ?>" onclick="$('#genre-input').val($(this).data('value')); $('#genre').text($(this).text())"><?=$genre[$i]['name']; ?></a>
                            <?php endfor; ?>
                        </div>
                    </details>
                    <input id="genre-input" type="hidden" name="filter-genre-id" value="0">
                </div>
                <div class="section-form__select">
                    <details class="ll-details-closed" style="z-index: 1111;">
                        <summary id="rating">
                            Оценка
                        </summary>
                        <div>
                            <a data-value="all-rating" onclick="$('#rating-input').val($(this).data('value')); $('#rating').text($(this).text())">Все</a>
                            <a data-value="plus" onclick="$('#rating-input').val($(this).data('value')); $('#rating').text($(this).text())">Нравится</a>
                            <a data-value="zero" onclick="$('#rating-input').val($(this).data('value')); $('#rating').text($(this).text())">Нормально</a>
                            <a data-value="minus" onclick="$('#rating-input').val($(this).data('value')); $('#rating').text($(this).text())">Не нравится</a>
                        </div>
                    </details>
                    <input id="rating-input" type="hidden" name="filter-rating" value="all-rating">
                </div>
                <div class="section-form__select">
                    <details class="ll-details-closed" style="z-index: 111;">
                        <summary id="date">
                            Дата
                        </summary>
                        <div>
                            <a data-value="999" onclick="$('#month-input').val($(this).data('value')); $('#date').text($(this).text())">Все</a>
                            <a data-value="1" onclick="$('#month-input').val($(this).data('value')); $('#date').text($(this).text())">Месяц</a>
                            <a data-value="3" onclick="$('#month-input').val($(this).data('value')); $('#date').text($(this).text())">3 месяца</a>
                            <a data-value="6" onclick="$('#month-input').val($(this).data('value')); $('#date').text($(this).text())">Полгода</a>
                            <a data-value="12" onclick="$('#month-input').val($(this).data('value')); $('#date').text($(this).text())">Год</a>
                            <a data-value="24" onclick="$('#month-input').val($(this).data('value')); $('#date').text($(this).text())">Позднее</a>
                        </div>
                    </details>
                    <input id="month-input" type="hidden" name="filter-month" value="999">
                </div>
                <div class="section-form__select">
                    <details class="ll-details-closed" style="z-index: 111;">
                        <summary id="order">
                            По дате добавления
                        </summary>
                        <div>
                            <a data-value="date" onclick="$('#order-input').val($(this).data('value')); $('#order').text($(this).text())">По дате добавления</a>
                            <a data-value="rating" onclick="$('#order-input').val($(this).data('value')); $('#order').text($(this).text())">По рейтингу книги</a>
                        </div>
                    </details>
                    <input id="order-input" type="hidden" name="filter-order" value="date">
                </div>
            </div>
        </form>

        <section class="lenta-content" style="margin: 0 auto;">
            <div class="lenta__list" id="book-reviews">
                <?php foreach ($reviews as $review): ?>
                    <article class="review-card lenta__item" style="padding-bottom: 35px;">
                        <div class="header-card">
                            <a class="header-card-user">
                                <img class="header-card-user__avatar" src="<?=$review['avatar_path']; ?>" alt="" width="100%" height="100%">
                            </a>
                            <a class="header-card-user__name"><span><?=$review['login']; ?></span></a>
                            <a class="header-card__category"><?php if ($review['gender'] == 'ж') {echo ' написала';} else {echo ' написал';} ?> рецензию</a>
                            <?php if($_SESSION['user']['id_profile'] == $review['id_profile']): ?>
                                <div class="header-card__menu">
                                    <div class="header-card__menu-block">
                                        <a href="/views/review/edit?review=<?=$review['id_review']; ?>" title="Редактировать рецензию">Редактировать</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="lenta-card">
                            <div class="lenta-card-book">
                                <img class="lenta-card-book__bg" src="<?=$review['image']; ?>"
                                     alt="<?=$review['book']; ?>" width="100%" height="auto">
                                <a class="lenta-card-book__link" href="/views/book/?book=<?=$review['id_book'] ?>">
                                    <img class="lenta-card-book__img" src="<?=$review['image']; ?>" width="100%" height="100%">
                                </a>
                                <div class="lenta-card-book__wrapper">
                                    <a class="lenta-card__book-title"
                                       href="/views/book/?book=<?=$review['id_book'] ?>"><?=$review['book']; ?></a>
                                    <p class="lenta-card__author-wrap">
                                        <a class="lenta-card__author"><?=$review['author']; ?></a>
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
                                        <span style="font-size: 22px;"><?=$middle; ?></span>
                                    </div>

                                    <div class="userbook-container-<?=$review['id_book'];?>" data-book-id="<?=$review['id_book'];?>"
                                         data-book-name="<?=$review['book']; ?>"
                                         data-action="<?=$action['id']; ?>"
                                         data-profile="<?=$_SESSION['user']['id_profile']; ?>"
                                         data-review = "<?=$reviewId;?>"
                                         data-mark = "<?=$review['rating'];?>"
                                         data-exist-review="<?=$reviewa;?>"
                                         data-session="<?=$_SESSION['user']['id_profile']; ?>"
                                         data-exist-action="<?php if (!empty($action)){echo 1;}else{echo 0;} ?>">
                                        <a class="btn-add-plus <?php if (!empty($action)){echo 'btn-add-plus--add';}?>"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="lenta-card__details">
                                <p class="lenta-card__date">
                                    <?=formatDate($review['date']); ?>
                                </p>
                            </div>
                            <h3 class="lenta-card__title">
                                <span class="lenta-card__mymark"><?=$review['rating']; ?></span>
                                <a href=""><?=$review['title']; ?></a>
                            </h3>
                            <div class="lenta-card__text">
                                <div id="lenta-card__text-review-escaped" style="max-height: 220px;">
                                    <p><?=$review['text']; ?></p>
                                </div>
                            </div>
                            <input type="hidden" name="reviewID" class="reviewID" id="reviewID" value="<?=$review['id_review'];?>">
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