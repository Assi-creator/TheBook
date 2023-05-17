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
        $query = $this->db->getAll("SELECT genre.name FROM genre JOIN book_genre bg on genre.id_genre = bg.id_genre JOIN book b on b.id = bg.id_book Where b.id = " . $id . "");
        for ($i = 0; $i < count($query); $i++) {
            $result[] = $query[$i]['name'];
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
        $action = $this->db->getAll("SELECT * FROM book_action WHERE id_book = " . $id . " AND id_profile = " . $profile . "");

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
            return $result;
        } else return 0;
    }

    /**
     * @param $id
     * @param $profile
     * @return array
     */
    function getMyMark($id, $profile): array
    {
        $mark = $this->db->getAll("SELECT rating FROM review JOIN profile p on p.id_profile = review.id_profile  WHERE review.id_book = " . $id . " AND review.id_profile = " . $profile . "");
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
                            WHERE b.id_profile = " . $profile;

        $read = $this->db->getAll($common_select . " AND b.id_action = 2");
        $reading = $this->db->getAll($common_select . " AND b.id_action = 1");
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
    function getProfileReviewForSingleBook($book, $profile): array
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
        $review = $this->db->getRow("SELECT * FROM review JOIN book b on b.id = review.id_book JOIN book_author ba on b.id = ba.id_book join author a on a.id_author = ba.id_author WHERE id_review = '" . $review . "'");

        $result = array(
            'id_review' => $review['id_review'],
            'id_book' => $review['id_book'],
            'rating' => $review['rating'],
            'title' => $review['title'],
            'text' => $review['text'],
            'book' => $review['name'],
            'image' => $review['image'],
            'author' => $review['a.name'] //Не выводится автор
        );

        return $result;
    }

    /**
     * @param $review
     * @return array
     */
    function getSingleReview($review): array
    {
        $sql = "SELECT id_review, review.id_book AS `id_book`, p.id_profile, p.login, p.avatar_path, title, rating, text, date, b.name AS `book`, image, a.name AS `author` FROM review
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
}

