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

    <title>Хочу прочитать</title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/header.js" defer></script>
    <script src="/assets/js/profile.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.js"></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php"; ?>

<br>
<br>
<main class="page-content-reader page-content main-body">
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/profileheader.php"; ?>

    <?php
    $api = new TheBook\Book;
    $book = $api->getAllProfileBook($_SESSION['user']['id_profile']);

    $wish = $book['wish'];
    ?>
    <div class="wrapper-ugc" style="max-width: 816px; margin: 15px;">
        <h1>Хочу прочитать</h1>
        <?php if (!empty($wish)): ?>

            <div class="blist-biglist" id="booklist">
                <?php foreach ($wish as $reads): ?>
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
                                            $stats = $api->getStatForSingleBook($reads['id']);
                                            for ($i = 0; $i < count($genre); $i++):
                                                ?>
                                                <a class="label-genre">
                                                    <?php echo $genre[$i]; ?>
                                                </a>
                                            <?php endfor; ?>
                                        </div>
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
