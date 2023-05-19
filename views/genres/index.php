<?php
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/genre/genre.php';
$api = new TheBook\Genre;

session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах" name="description">

    <title>Жанры</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script defer src="/assets/js/header.js"></script>
    <script defer src="/assets/libs/jquery-3.6.4.min.js"></script>
    <script defer src="/assets/js/genre.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
</head>

<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
//на кнопку показать все надо повесить событие
<br>

<main class="main-body page-content">
    <div id="bodywrapper">
        <div id="innerwrapper">
            <div id="contentwrapper">
                <div style="margin: 0 auto;">
                    <div id="main-container" class="container main-container" style="min-height: 0px;">
                        <h1>Все жанры</h1>
                        <?php
                        $result = $api->getAllTitleGenre();

                        foreach ($result as $title): ?>
                            <div class="card-white genre-block" style="width: 930px; overflow: auto;">
                                <div class="separator"></div>

                                <div class="genre-title">
                                    <a id="subgenre-a" class="right">
                                        <span id="genre-arrow-<?php echo $title['id_title'] ?>"
                                              class="arrow-genre-down"></span></a>
                                    <a class="main-genre-title" href=""><?php echo $title['name'] ?></a>
                                </div>
                                <div style="">
                                    <div id="subgenre-carousel" class="carousel-right">
                                        <div
                                            class="carousel-genre-books swiper-container carousel-genre-books-holder swiper-container-horizontal swiper-init">
                                            <ul class="swiper-wrapper" data-count="40"
                                                style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms; width: 2500px !important;">
                                                <?php
                                                $carousel = $api->getRandom44Book($title['id_title']);
                                                foreach ($carousel as $list): ?>
                                                    <li class="swiper-slide swiper-slide-active">
                                                    <a href="/views/book/?book=<?php echo $list['id']?>" onclick="event.stopPropagation()" title="<?php echo $list['name']; ?>">
                                                        <img onclick="event.stopPropagation()" src="<?php echo $list['image']; ?>"
                                                             alt="<?php echo $list['name']; ?>"
                                                             title="<?php echo $list['name']; ?>"
                                                             style="width: 66px; height: 99px;">
                                                    </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <div
                                                class="swiper-pagination paging swiper-pagination-clickable swiper-pagination-bullets"></div>
                                            <a href="javascript:void(0);"
                                               class="prev-carousel swiper-button-disabled"></a>
                                            <a href="javascript:void(0);" class="next-carousel"></a>
                                        </div>
                                    </div>
                                    <div id="subgenre-id" class="subgenre-left">
                                        <div class="subgenre-block">
                                            <?php
                                            $subgenres = $api->getAllSubgenre($title['id_title']);
                                            for ($i = 0; $i < 4; $i++): ?>
                                                <div class="subgenre">
                                                    <a href="/views/genres/genre?genre=<?php echo $subgenres[$i]['id_genre']; ?>"><?php echo $subgenres[$i]['name']; ?></a>
                                                    <?php $count = $api->getCountSubgenreBooks($subgenres[$i]['id_genre']); ?>
                                                    <span><?php echo $count[0]['count'] ?></span>
                                                </div>
                                            <?php endfor; ?>

                                            <?php if (count($subgenres) > 4) : ?>
                                                <div class="subgenre" id="subgenre-more"
                                                     style="font-size: 13px; font-weight: normal; margin-top: 13px; margin-bottom: 0">
                                                    <a>Показать все <?php echo count($subgenres); ?> жанров</a>
                                                    <span class="arrow-down-blue"></span>
                                                </div>

                                                <span id="subgenres-span" style="display: none;">
                                                    <?php for ($i = 4; $i < count($subgenres); $i++): ?>
                                                        <div class="subgenre">
                                                    <a href=""><?php echo $subgenres[$i]['name']; ?></a>
                                                    <?php $count = $api->getCountSubgenreBooks($subgenres[$i]['id_genre']); ?>
                                                    <span><?php echo $count[0]['count'] ?></span>
                                                </div>
                                                    <?php endfor; ?>
                                            </span>
                                            <?php else: ?>
                                            <span> </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>
