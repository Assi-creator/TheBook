<?php session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/book/book.php';
$api = new TheBook\controller\book();
$genreReview = $api->getGenreReview($_GET['genre']);
$title = $api->getGenreTitle($_GET['genre']); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title><?=$title['name']?></title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/profile.js" defer></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/template/actionpopup.php";?>

<section class="header">
    <div class="header-context profile-context">
        <div class="header-container" style="width: 100%">
            <ul class="nav context">
                <li>
                    <a href="/views/genres/genre?genre=<?=$_GET['genre'] ?>"><?=$title['name'] ?></a>
                </li>
                <li >
                    <a href="/views/genres/genre/new?genre=<?=$_GET['genre'] ?>">Новинки</a>
                </li>
                <li>
                    <a href="/views/genres/genre/best?genre=<?=$_GET['genre'] ?>">Лучшие книги</a>
                </li>
                <li>
                    <a href="/views/genres/genre/top?genre=<?=$_GET['genre'] ?>">Топ-100</a>
                </li>
                <li class="active">
                    <a href="/views/genres/genre/reviews?genre=<?=$_GET['genre'] ?>">Рецензии</a>
                </li>
            </ul>
        </div>
    </div>
</section>
<main class="page-content-reader page-content main-body">
    <div class="wrapper-ugc" style="max-width: 816px; margin: 15px;">
        <h1><?=$title['name']?> - рецензии</h1>

<!--    TODO: добавить тут две кнопки фильтр по дате фильтр по рейтингу возможно поиск?-->

        <div class="blist-biglist" id="booklist">
            <?php foreach ($genreReview as $review): ?>
            <div class="block-border card-block brow">
                <div class="brow-inner">
                <section class="lenta__list" style="min-height: auto; margin: 0 auto;">
                    <div id="objects-container">
                        <div id="review-page-list">
                                <article class="review-card lenta__item" style="margin-bottom: 50px;">
                                    <div class="header-card">
                                        <a class="header-card-user">
                                            <img class="header-card-user__avatar" src="<?=$review['avatar_path']?>" alt="" width="100%" height="100%">
                                        </a>
                                        <a class="header-card-user__name"><span><?=$review['login']?></span></a>
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
                                            <img class="lenta-card-book__bg" src="<?=$review['image']; ?>" alt="<?=$review['book']; ?>" width="100%" height="auto">
                                            <a class="lenta-card-book__link" href="/views/book/?book=<?=$review['id_book']?>">
                                                <img class="lenta-card-book__img" src="<?=$review['image']; ?>" width="100%" height="100%">
                                            </a>
                                            <div class="lenta-card-book__wrapper">
                                                <a class="lenta-card__book-title" href="/views/book/?book=<?=$review['id_book']?>"><?=$review['book']; ?></a>
                                                <p class="lenta-card__author-wrap">
                                                    <a class="lenta-card__author"><?=$review['author']; ?></a>
                                                </p>
                                                <?php
                                                $middle = $api->getBookRating($review['id_book']);
                                                $mymark = $api->getMyMark($review['id_book'], $_SESSION['user']['id_profile']);
                                                $action = $api->getActionForSession($review['id_book'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']); ?>
                                                <div class="lenta-card__rating">
                                                    <span style="font-size: 22px;"><?=$middle; ?></span>
                                                </div>
                                                <div class="userbook-container-<?=$review['id_book'];?>"
                                                     data-book-id="<?=$review['id_book'];?>"
                                                     data-book-name="<?=$review['book']; ?>"
                                                     data-action="<?=$action['id']; ?>"
                                                     data-profile="<?=$_SESSION['user']['id_profile']; ?>"
                                                     data-review = "<?=$review['id_review']?>"
                                                     data-mark = "<?=$mymark['rating']; ?>"
                                                     data-exist-review="1"
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
                                            <a href="/views/review/single?review=<?=$review['id_review']?>"><?=$review['title']; ?></a>
                                        </h3>
                                        <div class="lenta-card__text">
                                            <div id="lenta-card__text-review-escaped" style="max-height: 220px;">
                                                <p><?=$review['text']; ?></p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="reviewID" class="reviewID" id="reviewID" value="<?=$review['id_review'];?>">
                                    </div>
                                </article>
                        </div>
                    </div>
                </section>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
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


