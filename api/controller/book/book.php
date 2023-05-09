<?php

namespace TheBook;

require $_SERVER['DOCUMENT_ROOT'] . '/api/vendor/autoload.php';

class Book extends Base {

    public function test(){
        return $this->db->getAll("SELECT * FROM book");
    }

    function getSingleBookById($id)
    {
        $query = $this->db->getAll("SELECT * FROM book WHERE id = ".$id."");
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
            "series" =>$book['series'],
            "pages" => $book['pages'],
            "image" => $book['image'],
            "id_author" => $author[0]['id_author'],
            "author" => $author[0]['name'],
            "publishing" => $publishing[0]['name'],
            "genres" => $genres
        );
        return $result;
    }

    function getAuthorForSingleBook($id) {
        return $this->db->getAll("SELECT author.id_author, author.name FROM author JOIN book_author ba on author.id_author = ba.id_author JOIN book b on b.id = ba.id_book Where b.id = ".$id."");
    }

    function getPublishingForSingleBook($id){
        return $this->db->getAll("SELECT publishing.name FROM publishing JOIN book_publishing bp on publishing.id_publishing = bp.id_publishing JOIN book b on b.id = bp.id_book WHERE b.id = ".$id."");
    }

    function getGenresForSingleBook($id){
        $query = $this->db->getAll("SELECT genre.name FROM genre JOIN book_genre bg on genre.id_genre = bg.id_genre JOIN book b on b.id = bg.id_book Where b.id = ".$id."");
        for($i = 0; $i < count($query); $i++){
            $result[] = $query[$i]['name'];
        }
        return $result;
    }

    function getActionForSession($id, $profile, $gender) {
        $action = $this->db->getAll("SELECT * FROM book_action WHERE id_book = ".$id." AND id_profile = ".$profile."");

        switch ($action[0]['id_action']){
            case 1:
                if ($gender == 'ж'){
                    return 'Прочитала';
                } else {
                    return 'Прочитал';
                }
            case 2: return 'Читаю сейчас';
            case 3: return 'В планах';
        }
    }

    function getAllReviewForSingleBook($id){
        return $this->db->getAll("SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile  WHERE id_book = ".$id."");
    }

    function getStatForSingleBook($id){
        $review = $this->db->getAll("SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile  WHERE id_book = ".$id."");
        $read = $this->db->getAll("SELECT * FROM book_action WHERE id_book = ".$id." AND id_action = 1");
        $wish = $this->db->getAll("SELECT * FROM book_action WHERE id_book = ".$id." AND id_action = 3");

        $result = array(
            'review' => count($review),
            'read' => count($read),
            'wish' => count($wish)
        );
        return $result;
    }

    function getBookRaiting($id){
        $review = $this->db->getAll("SELECT rating FROM review JOIN profile p on p.id_profile = review.id_profile  WHERE id_book = ".$id."");
        if (count($review) > 0){
            for($i = 0; $i < count($review); $i++){
                $result = $result + (int)($review[$i]['rating']);
            }
            $result = $result / count($review);
            return $result;
        } else {
            return 0;
        }
    }

    function getOtherAuthorBook($id, $author){
        $other = $this->db->getAll("SELECT book.id, book.name AS `book`, book.image, a.name FROM book JOIN book_author ba on book.id = ba.id_book JOIN author a on a.id_author = ba.id_author WHERE ba.id_author = ".$author." and book.id != ".$id." LIMIT 15");
        return $other;
    }

    function getNewBook(){
        $currentYear = date('Y');
        $previousYear = $currentYear - 1;
        return $this->db->getAll("SELECT book.id, book.name AS `book`, book.image, a.name FROM book JOIN book_author ba on book.id = ba.id_book JOIN author a on a.id_author = ba.id_author WHERE book.year = ".$currentYear." OR book.year = ".$previousYear." ORDER BY RAND() LIMIT 20 ");
    }
}