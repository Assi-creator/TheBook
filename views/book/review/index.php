<?php session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/book/book.php';

$api = new TheBook\controller\Book;
$book = $api->getSingleBookById($_GET['book']);
$action = $api->getActionForSession($book['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах" name="description">

    <title>Отзывы о книге <?=$book['title']?> </title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script defer src="/assets/js/book.js"></script>

</head>
<body>

<?php
require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/template/actionpopup.php"; ?>

<br>
<br>
<?php $allReview = $api->getAllReviewForSingleBook($_GET['book']); ?>

<main class="main-body page-content book-card bc-new">
    <section class="bc-header">
        <div class="bc-header__bg-wrap">
            <img class="bc-header__bg" src="<?=$book['image'] ?>" style="width: 100%; height: auto;">
        </div>
        <div class="bc-header__wrap">
            <h1 class="bc__book-title"><?=$book['title']?></h1>
            <h2 class="bc-author"><?= $book['author']?></h2>
            <ul class="bc-header__list">
                <li>
                    <a class="bc-header__link bc-detailing-about" href="/views/book/?book=<?php echo $book['id']; ?>">
                        Описание
                    </a>
                </li>
                <li>
                    <a class="bc-header__link bc-detailing-review bc-header__link--active" href="/views/book/review?book=<?php echo $book['id']; ?>">
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
                    <?php if (!empty($_SESSION['user'])):
                        if (!empty($action)): ?>
                            <span class="bc-menu__status-wrapper">
                            <a class="bc-menu__status bc-menu__status-lists" href="/views/reader/<?=$action['href'] ?>/"><?=$action['action']?></a>
                        </span>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="bc-menu__image-wrapper">
                        <img class="bc-menu__image" title="<?=$book['title']?>" src="<?=$book['image']?>" style="cursor: pointer;" width="100%" height="100%" alt="">
                    </div>
                    <?php
                        $action = $api->getActionForSession($book['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                        $review = $api->getExistReview($book['id'], $_SESSION['user']['id_profile']);
                        $reviewId = $api->getReviewId($book['id'], $_SESSION['user']['id_profile']);
                        $rating = $api->getBookRating($book['id']); ?>
                    <div class="userbook-container-<?=$book['id']?>"
                         data-book-id="<?=$book['id']?>"
                         data-book-name="<?=$book['title']?>"
                         data-action="<?=$action['id']?>"
                         data-profile="<?=$_SESSION['user']['id_profile']?>"
                         data-review = "<?=$reviewId?>"
                         data-exist-review="<?=$review?>"
                         data-exist-action="<?php if (!empty($action)){echo 1;}else{echo 0;} ?>">
                        <a class="btn-add-plus <?php if (!empty($action)){echo 'btn-add-plus--add';}?>"></a>
                    </div>
                    <?php if (!empty($review)){$exist=1;}else{$exist=0;}
                    if($exist == 1): ?>
                        <a class="bc-menu__btn" style="font-size: 12px; text-align: center;" href="/views/review/edit?review=<?=$reviewId?>">Редактировать рецензию</a>
                    <?php else: ?>
                        <a class="bc-menu__btn" href="/views/review/create?book=<?=$book['id']?>">Написать рецензию</a>
                    <?php endif; ?>
                </div>
            </div>

            <article class="bc">
                <div id="content-loaded">
                    <article class="bc-review">
                            <div class="bc-detailing__inner">
                                <a class="bc-detailing__show-all">Всего <?php echo count($allReview); ?></a>
                            </div>

                        <?php $reviewapi = new \TheBook\controller\review();
                        $ratingCount = $reviewapi->getRatingReviewCount($book['id']); ?>
                            <div class="bc-detailing__sorting">
                                <details class="ll-details-closed">
                                    <summary>
                                        Все виды
                                    </summary>
                                    <div>
                                        <a class="filter" href="/views/book/review/filter?book=<?=$book['id']?>&rating=all-rating">Все виды</a>
                                        <?php if ($ratingCount['plus'][0] !== '0'): ?>
                                            <a class="filter" href="/views/book/review/filter?book=<?=$book['id']?>&rating=plus">Положительные <?=$ratingCount['plus'][0] ?></a>
                                        <?php endif; ?>
                                        <?php if ($ratingCount['zero'][0] !== '0'): ?>
                                            <a class="filter" href="/views/book/review/filter?book=<?=$book['id']?>&rating=zero">Нейтральные <?=$ratingCount['zero'][0] ?></a>
                                        <?php endif; ?>
                                        <?php if ($ratingCount['minus'][0] !== '0'): ?>
                                            <a class="filter" href="/views/book/review/filter?book=<?=$book['id']?>&rating=minus">Отрицательные <?=$ratingCount['minus'][0] ?></a>
                                        <?php endif; ?>
                                    </div>
                                </details>
                                <details class="ll-details-closed">
                                    <summary>
                                        По релевантности
                                    </summary>
                                    <div>
                                        <a href="/views/book/review/filter?book=<?=$book['id']?>&order=all-order">По релевантности</a>
                                        <a href="/views/book/review/filter?book=<?=$book['id']?>&order=rating">По рейтингу</a>
                                        <a href="/views/book/review/filter?book=<?=$book['id']?>&order=date">По дате добавления</a>
                                    </div>
                                </details>
                            </div>

                        <div id="book-reviews">
                            <?php foreach ($allReview as $review): ?>
                                <div class="lenta__item">
                                    <div class="header-card">
                                        <a class="header-card-user">
                                            <img class="header-card-user__avatar" src="<?=$review['avatar_path'] ?>" alt="" width="100%" height="100%">
                                        </a>
                                        <div class="header-card__wrapper">
                                            <div class="heade-card__row1">
                                                <a class="header-card-user__name">
                                                    <span><?=$review['login'] ?></span>
                                                </a>
                                                <a class="header-card__category"><?php if ($review['gender'] == 'ж') {echo ' написала';} else {echo ' написал';} ?> рецензию</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="lenta-card lenta-review" style="margin: 0 8px;">
                                        <div class="lenta-card__details">
                                            <p class="lenta-card__date"><?=formatDate($review['date']); ?></p>
                                        </div>
                                        <h3 class="lenta-card__title" style="font-size: 26px;">
                                            <span class="lenta-card__mymark" style="font-size: 26px;"><?=$review['rating'] ?></span>
                                            <a href="/views/review/single?review=<?=$review['id_review']?>"><?=$review['title']; ?></a>
                                        </h3>
                                        <div class="lenta-card__text">
                                            <div id="lenta-card__text-review-escaped" style="font-size: 18px; max-height: 220px;">
                                                <p><?=$review['text']?></p>
                                            </div>
                                            <div id="lenta-card__text-review-fulltext" style="font-size: 18px;" class="hidden">
                                                <p><?=$review['text']?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </article>
                </div>
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

