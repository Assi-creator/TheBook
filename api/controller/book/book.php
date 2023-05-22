<?php

namespace TheBook\controller;

use TheBook\Base;

require $_SERVER['DOCUMENT_ROOT'] . '/api/vendor/autoload.php';

class book extends Base {

    /**
     * Функция возвращает массив информации об 1 книге
     * @param $id
     * @return array|false|null
     */
    public function getSingleBookById($id)
    {
        $sql = "SELECT id, book.name AS `title`, annotation, ISBN, year, age, series, pages, image, p.name AS `publishing`, a.name AS `author`, a.id_author AS `id_author` FROM book
                    JOIN book_publishing bp on book.id = bp.id_book
                    JOIN publishing p on p.id_publishing = bp.id_publishing
                    JOIN book_author ba on book.id = ba.id_book
                    JOIN author a on a.id_author = ba.id_author
                WHERE book.id = $id ";
        return $this->db->getRow($sql);
    }

    /**
     * Функция возвращает массив жанров и их коды
     * @param $id
     * @return array
     */
    public function getGenresForSingleBook($id): array
    {
        $query = $this->db->getAll("SELECT genre.id_genre AS `id_genre`, genre.name AS `name` FROM genre 
                                        JOIN book_genre bg on genre.id_genre = bg.id_genre 
                                        JOIN book b on b.id = bg.id_book 
                                     Where b.id = " . $id . "");
        for ($i = 0; $i < count($query); $i++) {
            $result[] = array(
                'name' => $query[$i]['name'],
                'id_genre' => $query[$i]['id_genre'],
                'count' => 1+$i
            );
        }
        return $result;
    }

    /**
     * Функция возвращает массив с кодом статуса и его наименованием
     * @param $id
     * @param $profile
     * @param $gender
     * @return string[]|void
     */
    public function getActionForSession($id, $profile, $gender)
    {
        $action = $this->db->getRow("SELECT * FROM book_action WHERE id_book = '" . $id . "' AND id_profile = '" . $profile . "'");

        switch ($action['id_action']) {
            case 1:
                return array('id' => '1', 'action' => 'Читаю сейчас', 'href' => 'reading');
            case 2:
                if ($gender == 'ж') {
                    return array('id' => '2', 'action' => 'Прочитала', 'href' => 'read');
                } else {
                    return array('id' => '2', 'action' => 'Прочитал', 'href' => 'read');
                }
            case 3:
                return array('id' => '3', 'action' => 'В планах', 'href' => 'wish');
        }
    }

    /**
     * Возвращает массив всех рецензий для 1 книги
     * @param $id
     * @return array
     */
    public function getAllReviewForSingleBook($id): array
    {
        return $this->db->getAll("SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile JOIN reader r on r.id_reader = p.id_reader  WHERE id_book = " . $id . "");
    }

    /**
     * Возвращает массив с топом 5 рецензий для 1 книги
     * @param $id
     * @return array
     */
    public function getTopReviewsForSingleBook($id): ?array
    {
        return $this->db->getAll("SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile JOIN reader r on r.id_reader = p.id_reader  WHERE id_book = " . $id . " ORDER BY id_review DESC LIMIT 5");
    }

    /**
     * Возвращает массив с количеством рецензий и статусов "Прочитано" и "В планах" для 1 книги
     * @param $id
     * @return array
     */
    public function getStatForSingleBook($id): array
    {
        $review = $this->db->getRow("SELECT count(*) AS `count` FROM review JOIN profile p on p.id_profile = review.id_profile  WHERE id_book = " . $id . "");
        $read = $this->db->getRow("SELECT count(*) AS `count` FROM book_action WHERE id_book = " . $id . " AND id_action = 2");
        $wish = $this->db->getRow("SELECT count(*) AS `count` FROM book_action WHERE id_book = " . $id . " AND id_action = 3");

        return array(
            'review' => $review['count'],
            'read' => $read['count'],
            'wish' => $wish['count']
        );
    }

    /**
     * Функция возвращает среднюю оценку для книги
     * @param $id
     * @return float|int
     */
    public function getBookRating($id)
    {
        if (is_array($id)){
            $id = $id['id'];
        }
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
     * Функция возвращает пользовательскую оценку книги
     * @param $id
     * @param $profile
     * @return array
     */
    public function getMyMark($id, $profile): ?array
    {
        if ($profile !== null) {
            return $this->db->getRow("SELECT mark AS `rating` FROM mark WHERE id_book = " . $id . " AND id_profile = " . $profile . "");
        }
        return null;
    }

    /**
     * Возвращает массив 15 книг с таким же автором
     * @param $id
     * @param $author
     * @return array
     */
    public function getOtherAuthorBook($id, $author): ?array
    {
        return $this->db->getAll("SELECT book.id AS `id`, book.name AS `book`, book.image AS `image`, a.name FROM book 
                                        JOIN book_author ba on book.id = ba.id_book 
                                        JOIN author a on a.id_author = ba.id_author 
                                   WHERE ba.id_author = " . $author . " and book.id != " . $id . " LIMIT 15");
    }

    /**
     * Функция возвращает массив 15 книг с таким же названием и автором
     * @param $id
     * @param $title
     * @param $author
     * @return array
     */
    public function getSimpleBook($id, $title, $author): ?array
    {
        $simple = "SELECT book.id, book.name AS `book`, book.image, a.name AS `author` FROM book 
                        JOIN book_author ba on book.id = ba.id_book 
                        JOIN author a on a.id_author = ba.id_author 
                    WHERE ba.id_author = '" . $author . "' and book.name LIKE '%" . $title . "%' AND book.id != " . $id . " LIMIT 15";
        return $this->db->getAll($simple);
    }

    /**
     * Возвращает массив 20 книг 2022-2023 г. для вкладки "Новинки книг"
     * @return array
     */
    public function getNewBook(): array
    {
        $currentYear = date('Y');
        $previousYear = $currentYear - 1;
        return $this->db->getAll("SELECT book.id, book.name AS `book`, book.image, a.name FROM book 
                                        JOIN book_author ba on book.id = ba.id_book 
                                        JOIN author a on a.id_author = ba.id_author 
                                   WHERE book.year = " . $currentYear . " OR book.year = " . $previousYear . " 
                                   ORDER BY RAND() LIMIT 21 ");
    }

    /**
     * Функция возвращает массив 20 книг для вкладки "Что почитать?"
     * @return array
     */
    public function getRecommendationBook(): array
    {
        return $this->db->getAll("SELECT book.id, book.name AS `book`, book.image, a.name FROM book 
                                        JOIN book_author ba on book.id = ba.id_book 
                                        JOIN author a on a.id_author = ba.id_author  
                                   ORDER BY RAND() LIMIT 21 ");
    }

    public function getPopularBook(){
        return $this->db->getAll("SELECT book.id, book.name AS `book`, book.image, a.name, COUNT(book_action.id_action) AS action_count FROM book 
                                        INNER JOIN book_action ON book.id = book_action.id_book
                                        JOIN book_author ba on book.id = ba.id_book 
                                        JOIN author a on a.id_author = ba.id_author  
                                   WHERE book_action.id_action = 2
                                    GROUP BY book.id, book.name
                                    ORDER BY action_count DESC LIMIT 21 ");
    }

    /**
     * Возвращает массив книг всех книг пользователя
     * @param $profile
     * @return array
     */
    public function getAllProfileBook($profile): ?array
    {
        $common_select = "SELECT id, book.name AS title, annotation, ISBN, year, image, a.name AS author, p.name AS publishing FROM book 
                                JOIN book_author ba on book.id = ba.id_book 
                                JOIN author a on a.id_author = ba.id_author 
                                JOIN book_publishing bp on book.id = bp.id_book 
                                JOIN publishing p on p.id_publishing = bp.id_publishing 
                                JOIN book_action b on book.id = b.id_book 
                            WHERE b.id_profile = '" . $profile . "'";

        $reading = $this->db->getAll($common_select . " AND b.id_action = 1");
        $read = $this->db->getAll($common_select . " AND b.id_action = 2");
        $wish = $this->db->getAll($common_select . " AND b.id_action = 3");

        return array(
            'read' => array_reverse($read),
            'reading' => array_reverse($reading),
            'wish' => array_reverse($wish)
        );
    }

    /**
     * Возвращает информацию о ревью пользователя
     * @param $book
     * @param $profile
     * @return array
     */
    public function getProfileReviewForSingleBook($book, $profile): ?array
    {
        $sql = "SELECT * FROM review WHERE id_book = " . $book . " AND id_profile = " . $profile . "";
        return $this->db->getRow($sql);
    }

    /**
     * Функция предназначена для получения всей информации о рецензии по айди
     * @param $review
     * @return array
     */
    public function getReviewById($review): ?array
    {
        return $this->db->getRow("SELECT id_review AS `id_review`, review.id_book AS `id_book`, rating, title, text, b.name AS `book`, image, a.name AS `author` FROM review 
                                        JOIN book b on b.id = review.id_book 
                                        JOIN book_author ba on b.id = ba.id_book 
                                        JOIN author a on a.id_author = ba.id_author 
                                  WHERE id_review = '" . $review . "'");
    }

    /**
     * Функция возвращает массив информации о 1 рецензии
     * @param $review
     * @return array
     */
    public function getSingleReview($review): array
    {
        $sql = "SELECT id_review, review.id_book AS `id_book`, p.id_profile AS `id_profile`, p.login, p.avatar_path, title, rating, text, date, b.name AS `book`, image, a.name AS `author`, gender FROM review
                   JOIN book b on b.id = review.id_book
                   JOIN book_author ba on b.id = ba.id_book
                   JOIN author a on a.id_author = ba.id_author
                   join profile p on p.id_profile = review.id_profile
                   JOIN reader r on r.id_reader = p.id_reader
                WHERE id_review = " . $review . "";
        return $this->db->getRow($sql);
    }

    /**
     * Функция возвращает массив всех новых рецензий для главной
     * @return array
     */
    public function getAllReview(): array
    {
        $sql = "SELECT id_review, review.id_book AS `id_book`, p.id_profile, p.login, p.avatar_path, title, rating, text, date, b.name AS `book`, image, a.name AS `author`, gender FROM review
                   JOIN book b on b.id = review.id_book
                   JOIN book_author ba on b.id = ba.id_book
                   JOIN author a on a.id_author = ba.id_author
                   join profile p on p.id_profile = review.id_profile
                   JOIN reader r on r.id_reader = p.id_reader ORDER BY date DESC limit 20";
        return $this->db->getAll($sql);
    }

    /**
     * Функция возвращает количество всех рецензий
     * @return mixed
     */
    public function getCountAllReview(){
        $result = $this->db->getRow("SELECT count(*) AS `count` FROM review");
        return $result['count'];
    }

    /**
     * Функция возвращает массив всех родительских жанров
     * @return array
     */
    function getAllSubgenres(): array
    {
        $sql = "SELECT * FROM genre_title";
        return $this->db->getAll($sql);
    }

    /**
     * Функция проверяет существование рецензии для конкретной книги у пользователя
     * @param $book
     * @param $profile
     * @return int
     */
    public function getExistReview($book, $profile): int
    {
        if ($profile !== null) {
            $sql = "SELECT count(*) AS `count` FROM review WHERE id_book = " . $book . " AND id_profile = " . $profile . "";

            $result = $this->db->getRow($sql);
        }

        if ($result['count'] == 1) {
            return 1;
        } else return 0;
    }

    /**
     * Функция возвращает id ревью, если она существует у конкретной книги у пользователя
     * @param $book
     * @param $profile
     * @return int|mixed
     */
    public function getReviewId($book, $profile)
    {
        $sql = "SELECT id_review FROM review WHERE id_book = '" . $book . "' AND id_profile = '" . $profile . "'";

        $result = $this->db->getRow($sql);
        if (!empty($result)) {
            return $result['id_review'];
        } else return 0;

    }

    /**
     * Возвращает массив всех книг с указанным жанром
     * @param $genre
     * @return array|null
     */
    public function getBookByGenre($genre): ?array
    {
        $sql = "select id, book.name AS `title`, annotation, ISBN, year, series, image, a.name AS `author`, p.name AS `publishing`, g.name AS `genre` from book
                    JOIN book_genre bg on book.id = bg.id_book
                    JOIN book_author ba on book.id = ba.id_book
                    JOIN author a on a.id_author = ba.id_author
                    JOIN book_publishing bp on book.id = bp.id_book
                    JOIN publishing p on p.id_publishing = bp.id_publishing
                    JOIN genre g on bg.id_genre = g.id_genre
                WHERE bg.id_genre = '" . $genre . "'";
        return $this->db->getAll($sql);
    }

    /**
     * Возвращает массив новых книг указанного жанра
     * @param $genre
     * @return array
     */
    public function getBookByGenreNew($genre): ?array
    {
        $sql = "select id, book.name AS `title`, annotation, ISBN, year, series, image, a.name AS `author`, p.name AS `publishing`, g.name AS `genre` from book
                    JOIN book_genre bg on book.id = bg.id_book
                    JOIN book_author ba on book.id = ba.id_book
                    JOIN author a on a.id_author = ba.id_author
                    JOIN book_publishing bp on book.id = bp.id_book
                    JOIN publishing p on p.id_publishing = bp.id_publishing
                    join genre g on bg.id_genre = g.id_genre
                WHERE bg.id_genre = '" . $genre . "' ORDER BY id desc";
        return $this->db->getAll($sql);
    }

    /**
     * Возвращает массив книг с наибольшим статусом "Прочитано" указанного жанра
     * @param $genre
     * @return array|null
     */
    public function getBookByGenreTop($genre): ?array
    {
        $sql = "SELECT id, book.name AS `title`, annotation, ISBN, year, series, image, a.name AS `author`, p.name AS `publishing`, COUNT(book_action.id_action) AS action_count
                    FROM book
                             INNER JOIN book_action ON book.id = book_action.id_book
                             JOIN book_genre bg on book.id = bg.id_book
                             JOIN book_author ba on book.id = ba.id_book
                             JOIN author a on a.id_author = ba.id_author
                             JOIN book_publishing bp on book.id = bp.id_book
                             JOIN publishing p on p.id_publishing = bp.id_publishing
                    WHERE book_action.id_action = 2 AND bg.id_genre = '" . $genre . "'
                    GROUP BY book.id, book.name
                    ORDER BY action_count DESC ";
        return $this->db->getAll($sql);
    }

    /**
     * Возвращает массив книг с наибольшой средней пользовательской оценкой указанного жанра
     * @param $genre
     * @return array
     */
    public function getBookByGenreBest($genre): ?array
    {
        $sql = "select DISTINCT id, book.name AS `title`, annotation, ISBN, year, series, image, a.name AS `author`, p.name AS `publishing`, AVG(mark.mark) as average_mark from book
                INNER JOIN mark ON book.id = mark.id_book
                JOIN book_genre bg on book.id = bg.id_book
                JOIN book_author ba on book.id = ba.id_book
                JOIN author a on a.id_author = ba.id_author
                JOIN book_publishing bp on book.id = bp.id_book
                JOIN publishing p on p.id_publishing = bp.id_publishing
                JOIN mark m on book.id = m.id_book
        WHERE bg.id_genre = '" . $genre . "'
        GROUP BY book.name
        ORDER BY average_mark DESC";

        return $this->db->getAll($sql);
    }

    /**
     * Возвращает наименование жанра
     * @param $genre
     * @return array|false|null
     */
    public function getGenreTitle($genre)
    {
        return $this->db->getRow("SELECT name FROM genre WHERE id_genre = '" . $genre . "'");
    }

    /**
     * Возвращает массив положитеьных рецензий 1 книги
     * @param $book
     * @return array|null
     */
    public function getPlusReview($book): ?array
    {
        $sql = "SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile WHERE id_book = '" . $book . "' AND (rating = 4 OR rating = 5);";
        return $this->db->getAll($sql);
    }

    /**
     * Возвращает массив нейтральных рецензий 1 книги
     * @param $book
     * @return array|null
     */
    public function getZeroReview($book): ?array
    {
        $sql = "SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile WHERE id_book = '" . $book . "' AND rating = 3";
        return $this->db->getAll($sql);
    }

    /**
     * Возвращает массив негативных рецензий для 1 книги
     * @param $book
     * @return array|null
     */
    public function getMinusReview($book): ?array
    {
        $sql = "SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile WHERE id_book = '" . $book . "' AND (rating = 1 OR rating = 2);";

        $result = $this->db->getAll($sql);
        return $result;
    }

    /**
     * @return array
     */
    public function getAllTitleGenre(): array
    {
        return $this->db->getAll("SELECT * FROM genre_title");
    }

    /**
     * Возвращает все поджанры на основе родителя
     * @param $title
     * @return array
     */
    function getAllSubgenre($title): array
    {
        return $this->db->getAll("SELECT * FROM subgenres JOIN genre g on g.id_genre = subgenres.id_genre WHERE id_title = '" . $title . "' ORDER BY subgenres.id_title ");
    }

    /**
     * Возвращает массив 44 рандомных книг родительского жанра
     * @param $title
     * @return array
     */
    function getRandom44Book($title): array
    {
        return $this->db->getAll("SELECT DISTINCT `id`, book.name, image FROM book
            JOIN book_genre bg on book.id = bg.id_book
            JOIN genre g on bg.id_genre = g.id_genre
            JOIN subgenres s on g.id_genre = s.id_genre
            JOIN genre_title gt on s.id_title = gt.id_title
        WHERE gt.id_title = " . $title . " ORDER BY RAND() LIMIT 44;");
    }

    /**
     * @param $subgenre
     * @return array|void
     */
    function getCountSubgenreBooks($subgenre)
    {
        if($subgenre != null){
            return $this->db->getAll("SELECT DISTINCT COUNT(id) AS `count` FROM book 
            JOIN book_genre bg on book.id = bg.id_book 
            JOIN genre g on bg.id_genre = g.id_genre 
        WHERE g.id_genre = " . $subgenre . "");
        }
    }

    public function getGenreReview($id) {
        $id_genre = trim($id);
        $sql = "SELECT id_review, review.id_book AS `id_book`, p.id_profile, p.login, p.avatar_path, title, rating, text, date, b.name AS `book`, image, a.name AS `author`, gender FROM review
                     JOIN book b on b.id = review.id_book
                     JOIN book_author ba on b.id = ba.id_book
                     JOIN author a on a.id_author = ba.id_author
                     join profile p on p.id_profile = review.id_profile
                     JOIN reader r on r.id_reader = p.id_reader
                    join book_genre bg on b.id = bg.id_book 
                WHERE bg.id_genre = ".$id_genre."";
        return $this->db->getAll($sql);
    }
}
