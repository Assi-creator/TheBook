<?php session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title><?php if ($_SESSION['user']['gender'] == 'ж') {echo 'Прочитала';} else {echo 'Прочитал';} ?></title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/header.js" defer></script>
    <script src="/assets/js/profile.js" defer></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>

//едино для всех ссылки позапихивать и кнопку подправить пагинацию я подумаю

<br>
<main class="page-content-reader page-content main-body">
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/profileheader.php"; ?>

    <?php
    $api = new TheBook\Book;
    $book = $api->getAllProfileBook($_SESSION['user']['id_profile']);

    $read = $book['read'];
    ?>
    <div class="wrapper-ugc" style="max-width: 816px; margin: 15px;">
        <h1><?php if ($_SESSION['user']['gender'] == 'ж') {echo 'Прочитала';} else {echo 'Прочитал';} ?></h1>
        <?php if (!empty($read)): ?>

            <div class="blist-biglist" id="booklist">
                <?php foreach ($read as $reads): ?>
                    <div class="book-item-manage">
                        <div class="block-border card-block brow">
                            <div class="brow-inner">

                                <div class="brow-cover">
                                    <div class="cover-wrapper">
                                        <a href="/views/book/?book=<?php echo $reads['id']; ?>" title="">
                                            <img class="cover-rounded" src="<?php echo $reads['image']; ?>"
                                                 style="min-width: 140px; background-color: #ffffff;" width="140">
                                        </a>
                                    </div>
                                    <div class="brow-rating"></div>
                                    <div class="book-data">
                                        <div class="userbook-container" style="text-align: left;">
                                            <div class="ub-container" style="display: flex; justify-content: center;">
                                    <span class="ub-container-btn">
                                        <a class="btn-fill btn-wh right">Добавить</a>
                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator"></div>
                                </div>


                                <div class="brow-data">
                                    <div>
                                        <a class="brow-book-name with-cycle" href="/views/book/?book=<?php echo $reads['id']; ?>"><?php echo $reads['title']; ?></a>
                                        <div style="padding-top: 8px;"></div>
                                        <p class="brow-book-author"><?php echo $reads['author']; ?></p>
                                        <div class="brow-genres">
                                            <?php
                                            $genre = $api->getGenresForSingleBook($reads['id']);
                                            $mark = $api->getMyMark($reads['id'], $_SESSION['user']['id_profile']);
                                            $stats = $api->getStatForSingleBook($reads['id']);
                                            for ($i = 0; $i < count($genre); $i++):
                                                ?>
                                                <a class="label-genre">
                                                    <?php echo $genre[$i]; ?>
                                                </a>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="brow-rating">Ваша оценка: <span><?php if (!empty($mark)) {
                                                    echo $mark[0]['rating'];
                                                } else {
                                                    echo 0;
                                                } ?></span></div>
                                        <div class="brow-stats">
                                            <a style="cursor: default">
                                                <span class="i-cusers opc-054"></span> <?php echo $stats['read']; ?>
                                                прочитали
                                            </a>
                                            <a>
                                                <span class="i-creviews opc-054"></span> <?php echo $stats['review']; ?>
                                                рецензий
                                            </a>
                                        </div>
                                        <div class="brow-details">
                                            <table class="compact">
                                                <tbody>
                                                <tr>
                                                    <td style="font-weight: bold;padding-right: 6px;">ISBN:</td>
                                                    <td><span itemprop="isbn"><?php echo $reads['ISBN'] ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;padding-right: 6px;">Год издания:</td>
                                                    <td><?php echo $reads['year'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;padding-right: 6px;">Издательство:</td>
                                                    <td><span
                                                            itemprop="publisher"><p><?php echo $reads['publishing'] ?></p></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;padding-right: 6px;">Язык:</td>
                                                    <td>Русский</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="brow-marg">
                                            <p><?php echo $reads['annotation']; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="separator"></div>
                            </div>
                            <?php
                            $review = $api->getProfileReviewForSingleBook($reads['id'], $_SESSION['user']['id_profile']);
                            if (!empty($review)):
                                ?>
                                <div class="brow-review">
                                    <div class="group-review review-inner">
                                        <div class="with-pad event-header uerow">
                                            <div class="rel">
                                                <div class="group-user-date"
                                                     style="margin-bottom: 0; line-height: 20px;">
                                                    <div class="group-login-date dont-author">
                                            <span class="date-topright">
                                                <a title="Рецензия на книгу " href="">
                                                    <span class="date"><?php echo $review['date']; ?></span>
                                                </a>
                                            </span>
                                                        <a class="a-login-black" href="">Моя рецензия на книгу</a>
                                                        <br>
                                                        <a href="/views/book/?book=<?php echo $reads['id']; ?>"
                                                           title="Название книги"><?php echo $reads['title']; ?></a>
                                                        автора
                                                        <a title="Автор"
                                                           style="color: black; cursor: default;"><?php echo $reads['author']; ?></a>
                                                    </div>
                                                    <div class="separator"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="backgr-block review">
                                            <div class="card-block-text with-pad" style="min-height: 0;">
                                                <a class="post-scifi-title" href=""><?php echo $review['title']; ?></a>
                                                <div>
                                                    <div class="description">
                                                        <div id="review-text-full"></div>
                                                        <div id="review-text-brief">
                                                            <p><?php echo $review['text']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div id="es-top-wrapper" class="block-border card-block es-top-wrapper for-books">
                <div class="with-pads">
                    <div class="es-img">
                        <img src="/assets/images/root/icons/wish.svg">
                    </div>
                    <div class="es-data">
                        Ваш список пока пуст!
                        <br>
                        <br>
                        Выберите свой любимый <a href="/views/genres/">Жанр</a>, там Вы гарантированно найдете
                        интересные
                        книги.
                    </div>
                    <div class="separator"></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>
