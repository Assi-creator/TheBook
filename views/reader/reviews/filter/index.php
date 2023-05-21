<?php session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
}
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/user/user.php';
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/book/book.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Мои рецензии</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/profile.js" defer></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/template/actionpopup.php";?>

<br>
<br>
<main class="page-content-reader page-content main-body">
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/template/profileheader.php";
    $api = new TheBook\controller\User;
    $book = new TheBook\controller\Book;

    $reviews = $api->getAllProfileReviewsByRating($_SESSION['user']['id_profile']);

    ?>
    <h1 style="margin: 15px;">Мои рецензии</h1>
    <section class="ugs-sotring">
        <h3 class="ugs-sorting__title">Сортировка</h3>
        <ul class="ugs-sotring__list">
            <li class="ugs-sotring__item ">
                <a href="/views/reader/reviews">По дате добавления</a>
            </li>
            <li class="ugs-sotring__item ugs-sotring__item--active">
                <a href="/views/reader/reviews/filter">По рейтингу книги</a>
            </li>
        </ul>
    </section>
    <section class="lenta__list">
        <div id="objects-container">
            <div id="review-page-list">
                <?php foreach ($reviews as $review): ?>
                    <article class="review-card lenta__item" style="margin-bottom: 50px;">
                        <div class="header-card">
                            <a class="header-card-user">
                                <img class="header-card-user__avatar" src="<?php echo $_SESSION['user']['avatar_path']; ?>" alt="" width="100%" height="100%">
                            </a>
                            <a class="header-card-user__name"><span><?php echo $_SESSION['user']['login']; ?></span></a>
                            <a class="header-card__category"><?php if ($_SESSION['user']['gender'] == 'ж') {echo 'написала';} else {echo 'написал';} ?> рецензию</a>
                            <div class="header-card__menu">
                                <div class="header-card__menu-block">
                                    <a href="/views/review/edit?review=<?php echo $review['id_review']; ?>" title="Редактировать рецензию">Редактировать</a>
                                </div>
                            </div>
                        </div>
                        <div class="lenta-card">
                            <div class="lenta-card-book">
                                <img class="lenta-card-book__bg" src="<?php echo $review['image']; ?>" alt="<?php echo $review['book']; ?>" width="100%" height="auto">
                                <a class="lenta-card-book__link" href="/views/book/?book=<?php echo $review['id_book']?>">
                                    <img class="lenta-card-book__img" src="<?php echo $review['image']; ?>" width="100%" height="100%">
                                </a>
                                <div class="lenta-card-book__wrapper">
                                    <a class="lenta-card__book-title" href="/views/book/?book=<?php echo $review['id_book']?>"><?php echo $review['book']; ?></a>
                                    <p class="lenta-card__author-wrap">
                                        <a class="lenta-card__author"><?php echo $review['author']; ?></a>
                                    </p>
                                    <?php
                                    $middle = $book->getBookRating($review['id_book']);
                                    $mymark = $book->getMyMark($review['id_book'], $_SESSION['user']['id_profile']);
                                    $action = $book->getActionForSession($review['id_book'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']); ?>
                                    <div class="lenta-card__rating">
                                        <span style="font-size: 22px;"><?php echo $middle; ?></span>
                                    </div>
                                    <div class="userbook-container-<?php echo $review['id_book'];?>"
                                         data-book-id="<?php echo $review['id_book'];?>"
                                         data-book-name="<?php echo $review['book']; ?>"
                                         data-action="<?php echo $action['id']; ?>"
                                         data-profile="<?php echo $_SESSION['user']['id_profile']; ?>"
                                         data-review = "<?php echo $review['id_review']?>"
                                         data-mark = "<?php echo $mymark['rating']; ?>"
                                         data-exist-review="1"
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
                                <a  href="/views/review/single?review=<?php echo $review['id_review']?>"><?php echo $review['title']; ?></a>
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
        </div>
    </section>
    <div class="left-column" style="background: transparent;">
        <div class="column-right-fixed"><div style="opacity: 1;"><div class="prm-block prm-block-1" id="prm-block-1" style="display:none;"></div></div>
            <div class="content-side" style="display: none;">
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
