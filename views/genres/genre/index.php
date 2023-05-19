<?php session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/api/controller/book/book.php';
$api = new TheBook\Book;
$genre = $api->getBookByGenre($_GET['genre']); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Читайте, изучайте интересные подборки книг, делитесь впечатлениями о книгах">

    <title><?php echo $genre[0]['genre']; ?></title>

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
                <li class="active">
                    <a href="/views/genres/genre/"><?php echo $genre[0]['genre']; ?></a>
                </li>
                <li>
                    <a href="/views/genres/genre/new?genre=<?php echo $_GET['genre'] ?>">Новинки</a>
                </li>
                <li>
                    <a href="/views/genres/genre/best?genre=<?php echo $_GET['genre'] ?>">Лучшие книги</a>
                </li>
                <li>
                    <a href="/views/genres/genre/top?genre=<?php echo $_GET['genre'] ?>">Топ-100</a>
                </li>
                <li>
                    <a href="/views/genres/genre/reviews?genre=<?php echo $_GET['genre'] ?>">Рецензии</a>
                </li>
            </ul>
        </div>
    </div>
</section>
<main class="page-content-reader page-content main-body">
    <div class="wrapper-ugc" style="max-width: 816px; margin: 15px;">
        <h1><?php echo $genre[0]['genre']; ?> - популярные книги</h1>

            <div class="blist-biglist" id="booklist">
                <?php foreach ($genre as $genreBook): ?>
                    <div class="book-item-manage">
                        <div class="block-border card-block brow">
                            <div class="brow-inner">
                                <div class="brow-cover">
                                    <div class="cover-wrapper">
                                        <a href="/views/book/?book=<?php echo $genreBook['id']; ?>" title="<?php echo $genreBook['title']; ?>">
                                            <img class="cover-rounded" src="<?php echo $genreBook['image']; ?>" alt="<?php echo $genreBook['title']; ?>" style="min-width: 140px; background-color: #ffffff;" width="140">
                                        </a>
                                    </div>
                                    <?php $action = $api->getActionForSession($genreBook['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                    $review = $api->getExistReview($genreBook['id'], $_SESSION['user']['id_profile']);
                                    $reviewId = $api->getReviewId($genreBook['id'], $_SESSION['user']['id_profile']);
                                    $rating = $api->getBookRaiting($genreBook['id']); ?>
                                    <div class="brow-rating"></div>
                                    <div class="book-data">

                                        <?php  $mymark = $api->getMyMark($genreBook['id'], $_SESSION['user']['id_profile']);
                                        $action = $api->getActionForSession($genreBook['id'], $_SESSION['user']['id_profile'], $_SESSION['user']['gender']);
                                        $review = $api->getExistReview($genreBook['id'], $_SESSION['user']['id_profile']);
                                        $reviewId = $api->getReviewId($genreBook['id'], $_SESSION['user']['id_profile']);
                                        $rating = $api->getBookRaiting($genreBook['id']); ?>
                                        <div class="userbook-container-<?php echo $genreBook['id'];?>" data-book-id="<?php echo $genreBook['id'];?>"
                                             data-book-name="<?php echo $genreBook['title']; ?>"
                                             data-action="<?php echo $action['id']; ?>"
                                             data-profile="<?php echo $_SESSION['user']['id_profile']; ?>"
                                             data-review = "<?php echo $reviewId;?>"
                                             data-mark="<?php echo $mymark[0]['rating']; ?>"
                                             data-session="<?php echo $_SESSION['user']['id_profile']; ?>"
                                             data-exist-review="<?php echo $review;?>"
                                             data-exist-action="<?php if (!empty($action)){echo 1;}else{echo 0;} ?>">
                                            <a class="btn-add-plus <?php if (!empty($action)){echo 'btn-add-plus--add';}?>"></a>
                                        </div>

                                    </div>
                                    <div class="separator"></div>
                                    <input type="hidden" name="reviewID" class="reviewID" id="reviewID" value="<?php echo $reviewId;?>">
                                </div>


                                <div class="brow-data">
                                    <div>
                                        <a class="brow-book-name with-cycle" href="/views/book/?book=<?php echo $genreBook['id']; ?>"><?php echo $genreBook['title']; ?></a>
                                        <div style="padding-top: 8px;"></div>
                                        <p class="brow-book-author"><?php echo $genreBook['author']; ?></p>
                                        <div class="brow-genres">
                                            <?php
                                            $genre = $api->getGenresForSingleBook($genreBook['id']);
                                            $stats = $api->getStatForSingleBook($genreBook['id']);
                                            for ($i = 0; $i < count($genre); $i++):?>
                                                <a class="label-genre" href="/views/genres/genre?genre=<?php echo $genre[$i]['id_genre'];?>">
                                                    <?php echo $genre[$i]['name']; ?>
                                                </a>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="brow-rating" style="font-size: 17px;">
                                            <span>Средняя оценка: <?php echo $rating?> &#9733;</span>
                                        </div>
                                        <div class="brow-stats">
                                            <a style="cursor: default">
                                                <span class="i-cusers opc-054"></span> <?php echo $stats['read']; ?>
                                                прочитали
                                            </a>
                                            <a href="/views/book/review?book=<?php echo $genreBook['id']; ?>">
                                                <span class="i-creviews opc-054"></span> <?php echo $stats['review']; ?>
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
                                                            <?php echo $genreBook['ISBN'] ?>
                                                        </span></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;padding-right: 6px;">Год издания:</td>
                                                    <td><?php echo $genreBook['year'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: bold;padding-right: 6px;">Издательство:</td>
                                                    <td>
                                                        <span itemprop="publisher">
                                                            <p><?php echo $genreBook['publishing'] ?></p>
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
                                            <p><?php echo $genreBook['annotation']; ?></p>
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


