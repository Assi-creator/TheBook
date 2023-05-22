<?php session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/book/book.php';
$search = $_GET['search'];?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title>Результаты поиска: <?=$search?></title>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/template/link.php"; ?>

    <script src="/assets/js/profile.js" defer></script>
</head>
<body>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/header.php";
require $_SERVER['DOCUMENT_ROOT'] . "/template/actionpopup.php";?>

<br>
<main class="page-content-reader page-content main-body">
    <?php $searching = new TheBook\controller\search();
        $api = new \TheBook\controller\book();
        $books = $searching->bookSearch($_GET); ?>
    <div class="wrapper-ugc" style="max-width: 816px; margin: 15px;">
        <h1>Поиск</h1>
        <form id="userbook-form-div">
            <div class="div-form-search card-block form-new" style="padding:20px;">
                <div class="search-wide">
                    <input style="width:100%;" class="search-input-new ll-search-focus" data-btn-search="btn-search-new" id="input-search-book" name="search" type="text" placeholder="Поиск по всему сайту" value="<?=$search?>">
                    <input type="submit" id="btn-search-new" class="btn-search-new" title="Найти" value="">
                </div>
            </div>
        </form>

        <?php if (!empty($books['result']) AND $books['result'] !== null): ?>
            <div class="blist-biglist" id="booklist">
                <?php foreach ($books['result'] as $book): ?>
                    <div class="book-item-manage">
                        <div class="block-border card-block brow">
                            <div class="brow-inner">
                                <div class="brow-cover">
                                    <div class="cover-wrapper">
                                        <a href="/views/book/?book=<?=$book['id_book']?>" title="<?=$book['title']?>">
                                            <img class="cover-rounded" src="<?=$book['image']?>" style="min-width: 140px; background-color: #ffffff;" width="140" alt="<?=$book['title']?>">
                                        </a>
                                    </div>
                                    <?php
                                        $action = $api->getActionForSession($book['id_book'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                        $review = $api->getExistReview($book['id_book'], $_SESSION['user']['id_profile']);
                                        $reviewId = $api->getReviewId($book['id_book'], $_SESSION['user']['id_profile']);
                                        $rating = $api->getBookRating($book['id_book']); ?>
                                    <div class="book-data">
                                        <div class="userbook-container-<?=$book['id_book']?>"
                                             data-book-id="<?=$book['id_book']?>"
                                             data-book-name="<?=$book['title']?>"
                                             data-action="<?=$action['id']?>"
                                             data-profile="<?=$_SESSION['user']['id_profile']?>"
                                             data-review = "<?=$reviewId?>"
                                             data-session="<?=$_SESSION['user']['id_profile']?>"
                                             data-exist-review="<?=$review?>"
                                             data-exist-action="<?php if (!empty($action)){echo 1;}else{echo 0;} ?>">
                                            <a class="btn-add-plus <?php if (!empty($action)){echo 'btn-add-plus--add';}?>"></a>
                                        </div>
                                    </div>
                                    <div class="separator"></div>
                                    <input type="hidden" name="reviewID" class="reviewID" id="reviewID" value="<?=$reviewId?>">
                                </div>
                                <div class="brow-data">
                                    <div>
                                        <a class="brow-book-name with-cycle" href="/views/book/?book=<?=$book['id_book']?>"><?=$book['title']?></a>
                                        <div style="padding-top: 8px;"></div>
                                        <p class="brow-book-author"><?=$book['author']?></p>
                                        <div class="brow-genres">
                                            <?php
                                            $genre = $api->getGenresForSingleBook($book['id_book']);
                                            $stats = $api->getStatForSingleBook($book['id_book']);
                                            for ($i = 0; $i < count($genre); $i++):?>
                                                <a class="label-genre" href="/views/genres/genre?genre=<?=$genre[$i]['id_genre']?>">
                                                    <?=$genre[$i]['name']?>
                                                </a>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="brow-rating" style="font-size: 17px;">
                                            <span>Средняя оценка: <?=$rating?> &#9733;</span>
                                        </div>
                                        <div class="brow-stats">
                                            <a style="cursor: default">
                                                <span class="i-cusers opc-054"></span> <?=$stats['read']; ?>
                                                прочитали
                                            </a>
                                            <a href="/views/book/review?book=<?=$book['id_book']?>">
                                                <span class="i-creviews opc-054"></span> <?php echo $stats['review']; ?>
                                                рецензий
                                            </a>
                                        </div>
                                        <div class="brow-details">
                                            <table class="compact">
                                                <tbody>
                                                <tr>
                                                    <td style="font-weight: bold;padding-right: 6px;">ISBN:</td>
                                                    <td><span itemprop="isbn"><?=$book['ISBN']?></span></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;padding-right: 6px;">Год издания:</td>
                                                    <td><?=$book['year']?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;padding-right: 6px;">Издательство:</td>
                                                    <td><span
                                                            itemprop="publisher"><p><?=$book['publishing']?></p></span>
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
                                            <p><?=$book['annotation']?></p>
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
                <div class="block-border card-block">
                    <div class="with-pad">
                        <span class="not-found-icon"></span>
                        <span class="not-found-text">По вашему запросу ничего не найдено.<br>Попробуйте уточнить или изменить запрос.</span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>


