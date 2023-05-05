<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах" name="description">

    <title>Библиотека им. Л.Н.Толстого</title>

    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/template.css" rel="stylesheet">
    <link href="assets/images/the-book-icon.ico" rel="shortcut icon" type="image/x-icon">

    <script defer src="/assets/js/header.js"></script>
</head>

<body>

<?php use TheBook\Book;
require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<br>

<main class="main-body page-content">
    <article class="main-block">
        <h2 class="main-block__title">Новинки книг</h2>

        <div class="slide-book selection-slide-top__wrapper">
            <div class="slide-book__limiter">
                <ul class="slide-book__list slick-initialized slick-slider" data-step="6">
                    <button type="button" class="slick-prev slick-show slick-arrow slick-disabled" aria-disabled="true" style="display: inline-block;"></button>
                    <div class="slick-list draggable">
                        <div class="slick-track" style="opacity: 1; width: 3500px; transform: translate3d(0px, 0px, 0px);">

                            <?php
                                include 'api/controller/book/book.php';
                                $result = (new Book)->test();

                                foreach ($result as $book): ?>
                            <li class="slide-book__item slick-slide slick-current slick-active" data-book-id="<?php echo $book['id']; ?>" data-author-id="id" data-slick-index="0">
                                <a class="slide-book__link" href="#" tabindex="0">
                                    <img alt="name" src="<?php echo $book['image'] ?>" width="100%" height="auto">
                                </a>
                                <div class="slide-book__wrapper">
                                    <a class="slide_book__title" href="#" tabindex="0"><?php echo $book['name']; ?></a>
                                    <a class="slide-book__author" href="/author/2060080-kristi-bojs?reclist=noveltiesp_block&amp;rvid=3994758286" tabindex="0"><?php echo $book['year']; ?></a>
                                    <div class="separator"></div>
                                    <div data-view_mode="button" data-userbook_id="0" data-strict_edition_id="0" data-rand_id="100756" data-show_extended="" data-show="" data-edition_id="1007548177" class="userbook-container   ub-edition-1007548177 ub-book-4250797 btn-add-plus__wrapper ub-container" data-dont_add_wish="1" data-design="ll2019" id="xa-main-1007548177-0-100756">
                                        <a onclick="ub_form2020(1007548177, 0, 0, 100756, event);" href="javascript:void(0);" id="span-userbook-1007548177-0" data-dont_add_wish="1" class="span-userbook-1007548177-0 btn-add-plus">
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
    </article>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>