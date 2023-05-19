<?php

namespace TheBook;

require $_SERVER['DOCUMENT_ROOT'] . '/api/vendor/autoload.php';

class Book extends Base
{

    public function test()
    {
        return $this->db->getAll("SELECT * FROM book");
    }

    /**
     * @param $id
     * @return array
     */
    function getSingleBookById($id): array
    {
        $query = $this->db->getAll("SELECT * FROM book WHERE id = " . $id . "");
        $book = $query[0];
        $author = $this->getAuthorForSingleBook($id);
        $publishing = $this->getPublishingForSingleBook($id);
        $genres = $this->getGenresForSingleBook($id);
        $this->getBookRaiting($id);

        $result = array(
            "id" => $book['id'],
            "title" => $book['name'],
            "annotation" => $book['annotation'],
            "ISBN" => $book['ISBN'],
            "year" => $book['year'],
            "age" => $book['age'],
            "series" => $book['series'],
            "pages" => $book['pages'],
            "image" => $book['image'],
            "id_author" => $author[0]['id_author'],
            "author" => $author[0]['name'],
            "publishing" => $publishing[0]['name'],
            "genres" => $genres
        );
        return $result;
    }

    /**
     * @param $id
     * @return array
     */
    function getAuthorForSingleBook($id): array
    {
        return $this->db->getAll("SELECT author.id_author, author.name FROM author JOIN book_author ba on author.id_author = ba.id_author JOIN book b on b.id = ba.id_book Where b.id = " . $id . "");
    }

    /**
     * @param $id
     * @return array
     */
    function getPublishingForSingleBook($id): array
    {
        return $this->db->getAll("SELECT publishing.name FROM publishing JOIN book_publishing bp on publishing.id_publishing = bp.id_publishing JOIN book b on b.id = bp.id_book WHERE b.id = " . $id . "");
    }

    /**
     * @param $id
     * @return array
     */
    function getGenresForSingleBook($id): array
    {
        $query = $this->db->getAll("SELECT genre.id_genre AS `id_genre`, genre.name AS `name` FROM genre JOIN book_genre bg on genre.id_genre = bg.id_genre JOIN book b on b.id = bg.id_book Where b.id = " . $id . "");
        for ($i = 0; $i < count($query); $i++) {
            $result[] = array(
                'name' => $query[$i]['name'],
                'id_genre' => $query[$i]['id_genre']
            );
        }
        return $result;
    }

    /**
     * @param $id
     * @param $profile
     * @param $gender
     * @return string[]|void
     */
    function getActionForSession($id, $profile, $gender)
    {
        $action = $this->db->getAll("SELECT * FROM book_action WHERE id_book = '" . $id . "' AND id_profile = '" . $profile . "'");

        switch ($action[0]['id_action']) {
            case 1:
                return $result = array('id' => '1', 'action' => 'Читаю сейчас', 'href' => 'reading');
            case 2:
                if ($gender == 'ж') {
                    return $result = array('id' => '2', 'action' => 'Прочитала', 'href' => 'read');
                } else {
                    return $result = array('id' => '2', 'action' => 'Прочитал', 'href' => 'read');
                }
            case 3:
                return $result = array('id' => '3', 'action' => 'В планах', 'href' => 'wish');
        }
    }

    /**
     * @param $id
     * @return array
     */
    function getAllReviewForSingleBook($id): array
    {
        return $this->db->getAll("SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile  WHERE id_book = " . $id . "");
    }

    function getTopReviewsForSingleBook($id){
        return $this->db->getAll("SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile  WHERE id_book = " . $id . " ORDER BY id_review DESC LIMIT 5");
    }

    /**
     * @param $id
     * @return array
     */
    function getStatForSingleBook($id): array
    {
        $review = $this->db->getAll("SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile  WHERE id_book = " . $id . "");
        $read = $this->db->getAll("SELECT * FROM book_action WHERE id_book = " . $id . " AND id_action = 2");
        $wish = $this->db->getAll("SELECT * FROM book_action WHERE id_book = " . $id . " AND id_action = 3");

        $result = array(
            'review' => count($review),
            'read' => count($read),
            'wish' => count($wish)
        );
        return $result;
    }

    /**
     * @param $id
     * @return float|int
     */
    function getBookRaiting($id)
    {
        $review = $this->db->getAll("SELECT mark FROM mark JOIN profile p on p.id_profile = mark.id_profile  WHERE id_book = " . $id . "");
        if (count($review) > 0) {
            for ($i = 0; $i < count($review); $i++) {
                $result = $result + (int)($review[$i]['mark']);
            }
            $result = $result / count($review);
            return round($result, 1);
        } else return 0;
    }

    /**
     * @param $id
     * @param $profile
     * @return array
     */
    function getMyMark($id, $profile)
    {
        if ($profile !== null){
            $mark = $this->db->getAll("SELECT mark AS `rating` FROM mark WHERE id_book = " . $id . " AND id_profile = " . $profile . "");
        }
        return $mark;
    }

    /**
     * @param $id
     * @param $author
     * @return array
     */
    function getOtherAuthorBook($id, $author): array
    {
        $other = $this->db->getAll("SELECT book.id, book.name AS `book`, book.image, a.name FROM book JOIN book_author ba on book.id = ba.id_book JOIN author a on a.id_author = ba.id_author WHERE ba.id_author = " . $author . " and book.id != " . $id . " LIMIT 15");
        return $other;
    }

    function getSimpleBook($id, $title, $author) {
        $simple = "SELECT book.id, book.name AS `book`, book.image, a.name AS `author` FROM book JOIN book_author ba on book.id = ba.id_book JOIN author a on a.id_author = ba.id_author WHERE ba.id_author = " . $author . " and book.name LIKE '%".$title."%' AND book.id != " . $id . " LIMIT 15";

        $result = $this->db->getAll($simple);
        return $result;
    }

    /**
     * @return array
     */
    function getNewBook(): array
    {
        $currentYear = date('Y');
        $previousYear = $currentYear - 1;
        return $this->db->getAll("SELECT book.id, book.name AS `book`, book.image, a.name FROM book JOIN book_author ba on book.id = ba.id_book JOIN author a on a.id_author = ba.id_author WHERE book.year = " . $currentYear . " OR book.year = " . $previousYear . " ORDER BY RAND() LIMIT 20 ");
    }

    /**
     * @param $profile
     * @return array
     */
    function getAllProfileBook($profile): array
    {
        $common_select = "SELECT id, book.name AS title, annotation, ISBN, year, image, a.name AS author, p.name AS publishing FROM book 
                                JOIN book_author ba on book.id = ba.id_book 
                                JOIN author a on a.id_author = ba.id_author 
                                JOIN book_publishing bp on book.id = bp.id_book 
                                JOIN publishing p on p.id_publishing = bp.id_publishing 
                                JOIN book_action b on book.id = b.id_book 
                            WHERE b.id_profile = '" . $profile."'";

        $reading = $this->db->getAll($common_select . " AND b.id_action = 1");
        $read = $this->db->getAll($common_select . " AND b.id_action = 2");
        $wish = $this->db->getAll($common_select . " AND b.id_action = 3");

        $result = array(
            'read' => array_reverse($read),
            'reading' => array_reverse($reading),
            'wish' => array_reverse($wish)
        );

        return $result;
    }

    /**
     * @param $book
     * @param $profile
     * @return array
     */
    function getProfileReviewForSingleBook($book, $profile)
    {
        $sql = "SELECT * FROM review WHERE id_book = " . $book . " AND id_profile = " . $profile . "";

        $result = $this->db->getRow($sql);
        return $result;
    }

    /**
     * Функция предназначена для получения всей информации о рецензии по айди
     * @param $review
     * @return array
     */
    function getReviewById($review): array
    {
        $review = $this->db->getRow("SELECT id_review, review.id_book, rating, title, text, b.name AS `book`, image, a.name AS `author` FROM review JOIN book b on b.id = review.id_book JOIN book_author ba on b.id = ba.id_book join author a on a.id_author = ba.id_author WHERE id_review = '" . $review . "'");

        $result = array(
            'id_review' => $review['id_review'],
            'id_book' => $review['id_book'],
            'rating' => $review['rating'],
            'title' => $review['title'],
            'text' => $review['text'],
            'book' => $review['book'],
            'image' => $review['image'],
            'author' => $review['author']
        );

        return $result;
    }

    /**
     * @param $review
     * @return array
     */
    function getSingleReview($review): array
    {
        $sql = "SELECT id_review, review.id_book AS `id_book`, p.id_profile AS `id_profile`, p.login, p.avatar_path, title, rating, text, date, b.name AS `book`, image, a.name AS `author` FROM review
                   JOIN book b on b.id = review.id_book
                   JOIN book_author ba on b.id = ba.id_book
                   JOIN author a on a.id_author = ba.id_author
                   join profile p on p.id_profile = review.id_profile
                WHERE id_review = " . $review . "";
        $result = $this->db->getAll($sql);
        return $result;
    }

    /**
     * @return array
     */
    function getAllReview(): array
    {
        $sql = "SELECT id_review, review.id_book AS `id_book`, p.id_profile, p.login, p.avatar_path, title, rating, text, date, b.name AS `book`, image, a.name AS `author` FROM review
                   JOIN book b on b.id = review.id_book
                   JOIN book_author ba on b.id = ba.id_book
                   JOIN author a on a.id_author = ba.id_author
                   join profile p on p.id_profile = review.id_profile ORDER BY date DESC limit 20";
        $result = $this->db->getAll($sql);
        return $result;
    }

    /**
     * @return array
     */
    function getAllSubgenres(): array
    {
        $sql = "SELECT * FROM genre_title";
        $result = $this->db->getAll($sql);
        return $result;
    }

    function getExistReview($book, $profile){
        if ($profile !== null){
            $sql = "SELECT count(*) AS `count` FROM review WHERE id_book = " . $book . " AND id_profile = " . $profile . "";

            $result = $this->db->getRow($sql);
        }

        if ($result['count'] == 1){
            return 1;
        } else return 0;
    }

    function getReviewId($book, $profile){
        $sql = "SELECT id_review FROM review WHERE id_book = '" . $book . "' AND id_profile = '" . $profile . "'";

        $result = $this->db->getRow($sql);
        if (!empty($result)){
            return $result['id_review'];
        } else return 0;

    }

    function getBookByGenre($genre) {
        $sql = "select id, book.name AS `title`, annotation, ISBN, year, series, image, a.name AS `author`, p.name AS `publishing`, g.name AS `genre` from book
                    JOIN book_genre bg on book.id = bg.id_book
                    JOIN book_author ba on book.id = ba.id_book
                    JOIN author a on a.id_author = ba.id_author
                    JOIN book_publishing bp on book.id = bp.id_book
                    JOIN publishing p on p.id_publishing = bp.id_publishing
                                                                                                                                   join genre g on bg.id_genre = g.id_genre
                WHERE bg.id_genre = '".$genre."'";

        $result = $this->db->getAll($sql);
        return $result;
    }

    function getBookByGenreNew($genre){
        $sql = "select id, book.name AS `title`, annotation, ISBN, year, series, image, a.name AS `author`, p.name AS `publishing`, g.name AS `genre` from book
                    JOIN book_genre bg on book.id = bg.id_book
                    JOIN book_author ba on book.id = ba.id_book
                    JOIN author a on a.id_author = ba.id_author
                    JOIN book_publishing bp on book.id = bp.id_book
                    JOIN publishing p on p.id_publishing = bp.id_publishing
                    join genre g on bg.id_genre = g.id_genre
                WHERE bg.id_genre = '".$genre."' ORDER BY id desc";

        $result = $this->db->getAll($sql);
        return $result;
    }

    function getBookByGenreTop($genre) {
        $sql = "SELECT id, book.name AS `title`, annotation, ISBN, year, series, image, a.name AS `author`, p.name AS `publishing`, COUNT(book_action.id_action) AS action_count
                    FROM book
                             INNER JOIN book_action ON book.id = book_action.id_book
                             JOIN book_genre bg on book.id = bg.id_book
                             JOIN book_author ba on book.id = ba.id_book
                             JOIN author a on a.id_author = ba.id_author
                             JOIN book_publishing bp on book.id = bp.id_book
                             JOIN publishing p on p.id_publishing = bp.id_publishing
                    WHERE book_action.id_action = 2 AND bg.id_genre = '".$genre."'
                    GROUP BY book.id, book.name
                    ORDER BY action_count DESC ";

        $result = $this->db->getAll($sql);

        return $result;
    }

    function getBookByGenreBest($genre){
        $sql = "select DISTINCT id, book.name AS `title`, annotation, ISBN, year, series, image, a.name AS `author`, p.name AS `publishing`, AVG(mark.mark) as average_mark from book
                INNER JOIN mark ON book.id = mark.id_book
                JOIN book_genre bg on book.id = bg.id_book
                JOIN book_author ba on book.id = ba.id_book
                JOIN author a on a.id_author = ba.id_author
                JOIN book_publishing bp on book.id = bp.id_book
                JOIN publishing p on p.id_publishing = bp.id_publishing
                JOIN mark m on book.id = m.id_book
        WHERE bg.id_genre = '".$genre."'
        GROUP BY book.name
        ORDER BY average_mark DESC";

        $result = $this->db->getAll($sql);

        $this->log->info('array', $result);

        return $result;
    }

    function getGenreTitile($genre){
        return $this->db->getRow("SELECT name FROM genre WHERE id_genre = '".$genre."'");
    }

    function getPlusReview($book){
        $sql = "SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile WHERE id_book = '".$book."' AND (rating = 4 OR rating = 5);";

        $result = $this->db->getAll($sql);
        return $result;
    }

    function getZeroReview($book){
        $sql = "SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile WHERE id_book = '".$book."' AND rating = 3;";

        $result = $this->db->getAll($sql);
        return $result;
    }

    function getMinusReview($book){
        $sql = "SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile WHERE id_book = '".$book."' AND (rating = 1 OR rating = 2);";

        $result = $this->db->getAll($sql);
        return $result;
    }

}

