<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Рецензия на книгу</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/profile.js" defer></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>

//Голая страница и надо все тут делать очевидно добавить везде ссылок в артикли и прочая лабуда
<br>
<main class="page-content-reader page-content main-body">

    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/template/actionpopup.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/api/controller/book/book.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/api/controller/user/user.php";
    $book = new TheBook\controller\Book;

    $reviews = $book->getAllReview();

    ?>

    <form id="userbook-form-div" class="section-form" action="" method="POST">
        <div class="section-form__wrap">
            <h1 class="section-form__title">Рецензии</h1>
            <div class="section-form__search">
                <input id="section-form-search" type="search" name="filter-search" placeholder="Искать" autofocus=""
                       value="">
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
                            <a data-value="<?php echo $genre['id_genre'][$i]; ?>"><?php echo $genre[$i]['name']; ?></a>
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
                        <a data-value="-1">Все</a>
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
                                <?php $middle = $book->getBookRating($review['id_book']); ?>
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
                            <div id="lenta-card__text-review-escaped">
                                <p><?php echo $review['text']; ?></p>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>
