<?php session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/book/book.php';
$api = new TheBook\controller\Book;
$genre = $api->getBookByGenreTop($_GET['genre']);
$title = $api->getGenreTitle($_GET['genre']); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title><?php echo $title['name']; ?></title>

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
                    <a href="/views/genres/genre?genre=<?=$_GET['genre'] ?>"><?=$title['name'];?></a>
                </li>
                <li>
                    <a href="/views/genres/genre/new?genre=<?=$_GET['genre'] ?>">Новинки</a>
                </li>
                <li>
                    <a href="/views/genres/genre/best?genre=<?=$_GET['genre'] ?>">Лучшие книги</a>
                </li>
                <li class="active">
                    <a href="/views/genres/genre/top?genre=<?=$_GET['genre'] ?>">Топ-100</a>
                </li>
                <li>
                    <a href="/views/genres/genre/reviews?genre=<?=$_GET['genre'] ?>">Рецензии</a>
                </li>
            </ul>
        </div>
    </div>
</section>
<main class="page-content-reader page-content main-body">
    <div class="wrapper-ugc" style="max-width: 816px; margin: 15px;">
        <h1><?=$title['name']; ?> - топ-100</h1>

        <div class="blist-biglist" id="booklist">
            <?php foreach ($genre as $genreBook): ?>
                <div class="book-item-manage">
                    <div class="block-border card-block brow">
                        <div class="brow-inner">
                            <div class="brow-cover">
                                <div class="cover-wrapper">
                                    <a href="/views/book/?book=<?=$genreBook['id']; ?>" title="<?=$genreBook['title']; ?>">
                                        <img class="cover-rounded" src="<?=$genreBook['image']; ?>" alt="<?=$genreBook['title']?>" style="min-width: 140px; background-color: #ffffff;" width="140">
                                    </a>
                                </div>
                                <?php $mymark = $api->getMyMark($genreBook['id'], $_SESSION['user']['id_profile']);
                                $action = $api->getActionForSession($genreBook['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                $review = $api->getExistReview($genreBook['id'], $_SESSION['user']['id_profile']);
                                $reviewId = $api->getReviewId($genreBook['id'], $_SESSION['user']['id_profile']);
                                $rating = $api->getBookRating($genreBook['id']); ?>
                                <div class="brow-rating"></div>
                                <div class="book-data">
                                    <div class="userbook-container-<?=$genreBook['id']?>"
                                         data-book-id="<?=$genreBook['id']?>"
                                         data-book-name="<?=$genreBook['title']?>"
                                         data-action="<?=$action['id']?>"
                                         data-profile="<?=$_SESSION['user']['id_profile']?>"
                                         data-review = "<?=$reviewId?>"
                                         data-mark="<?=$mymark[0]['rating']?>"
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
                                    <a class="brow-book-name with-cycle" href="/views/book/?book=<?=$genreBook['id']?>"><?=$genreBook['title']?></a>
                                    <div style="padding-top: 8px;"></div>
                                    <p class="brow-book-author"><?=$genreBook['author']; ?></p>
                                    <div class="brow-genres">
                                        <?php $genre = $api->getGenresForSingleBook($genreBook['id']);
                                        $stats = $api->getStatForSingleBook($genreBook['id']);
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
                                            <span class="i-cusers opc-054"></span> <?=$stats['read']?>
                                            прочитали
                                        </a>
                                        <a href="/views/book/review?book=<?=$genreBook['id']?>">
                                            <span class="i-creviews opc-054"></span> <?=$stats['review']?>
                                            рецензий
                                        </a>
                                    </div>
                                    <div class="brow-details">
                                        <table class="compact">
                                            <tbody>
                                            <tr>
                                                <td style="font-weight: bold;padding-right: 6px;">ISBN:</td>
                                                <td>
                                                    <span itemprop="isbn">
                                                        <?=$genreBook['ISBN']?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;padding-right: 6px;">Год издания:</td>
                                                <td><?=$genreBook['year'] ?></td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold;padding-right: 6px;">Издательство:</td>
                                                <td>
                                                    <span itemprop="publisher">
                                                        <p><?=$genreBook['publishing'] ?></p>
                                                    </span>
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
                                        <p><?=$genreBook['annotation']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="separator"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php require $_SERVER['DOCUMENT_ROOT'] . "/template/footer.php"; ?>

</body>
</html>



