<?php

namespace TheBook\controller;

use TheBook\Base;

require $_SERVER['DOCUMENT_ROOT'] . '/api/vendor/autoload.php';

Class search extends Base {

    public function bookSearch($obj) {
        $this->log->debug('SQL search user:', array($obj));
        $book = new book();
        $search = "SELECT book.id AS `id_book`, book.name AS `title`, image, a.name AS `author`, book.annotation, book.ISBN, book.year, p.name AS `publishing` FROM book
                        JOIN book_author ba on book.id = ba.id_book
                        JOIN author a on a.id_author = ba.id_author
                        JOIN book_publishing bp on book.id = bp.id_book 
                        JOIN publishing p on p.id_publishing = bp.id_publishing
                    WHERE book.name LIKE '%".$obj['search']."%' OR a.name LIKE '%".$obj['search']."%'";
        $search = $this->db->getAll($search);

        $this->log->debug('SQL search info:', array($search));

        for ($i = 0; $i < count($search); $i++) {
            $action = $book->getStatForSingleBook($search[$i]['id_book']);
            $result[] = array(
              'id_book' => $search[$i]['id_book'],
              'title' => $search[$i]['title'],
              'image' => $search[$i]['image'],
              'author' => $search[$i]['author'],
              'genre' => $book->getGenresForSingleBook($search[$i]['id_book']),
                'rating' => $book->getBookRating($search[$i]['id_book']),
                'reads' => $action['read'],
                'reviews' => $action['review'],
                'wishs' => $action['wish'],
                'annotation' => $search[$i]['annotation'],
                'ISBN' => $search[$i]['ISBN'],
                'year' => $search[$i]['year'],
                'publishing' => $search[$i]['publishing']
            );
        }
        $this->log->debug('Search info:', array($result));
        return $this->request_api(true, $result);
    }

    public function searchReview($getGenre, $getRating, $getDate, $getOrder, $getName = null) {

        $id_genre = trim($getGenre);
        $rating = trim($getRating);
        $date = trim((int)$getDate) * 30;
        $order = trim($getOrder);

        $name = $getName;

        switch ($order) {
            case 'date': $sqlOrder = 'ORDER BY date DESC';
            break;
            case 'rating': $sqlOrder = 'ORDER BY rating DESC';
            break;
        }

       if ((int)$id_genre !== 0) {
           $sqlGenre = "AND gt.id_title = $id_genre ";
       } else $sqlGenre = "";

       switch ($rating) {
           case 'plus':
               $sqlRating = "AND (rating = 4 OR rating = 5)";
               break;
           case 'zero':
               $sqlRating = "AND rating = 3";
               break;
           case 'minus':
               $sqlRating = "AND (rating = 1 OR rating = 2)";
               break;
           case 'all-rating':
               $sqlRating = '';
               break;
       }

       if ($name !== null AND !empty($name)){
           $sqlName = "AND b.name LIKE '%$name%'";
       }else $sqlName = "";

        $sql = "SELECT DISTINCT id_review, rating, title, text, date, login, avatar_path, gender, b.id AS `id_book`, b.name AS `book_title`, image, a.name AS `author`  FROM review
                    JOIN profile p on p.id_profile = review.id_profile
                    join reader r on r.id_reader = p.id_reader
                    JOIN book b on b.id = review.id_book
                    JOIN book_author ba on b.id = ba.id_book
                    JOIN author a on a.id_author = ba.id_author
                    JOIN book_action ba2 on b.id = ba2.id_book
                    JOIN book_genre bg on review.id_book = bg.id_book
                    JOIN genre g on bg.id_genre = g.id_genre
                    JOIN subgenres s on g.id_genre = s.id_genre
                    JOIN genre_title gt on gt.id_title = s.id_title 
                WHERE date > NOW() - INTERVAL $date DAY $sqlRating $sqlGenre $sqlName $sqlOrder ";

       $this->log->info('SQL review search:', array($sql));
       $result = $this->db->getAll($sql);

       return $result;
    }

    public function getSummaryValue($getGenre, $getRating, $getDate) {
        $sqlTitle = $this->db->getRow("SELECT name FROM genre_title WHERE id_title = '".(int)$getGenre."' ");

        switch ($getRating) {
            case 'plus':
                $rating = "Положительные";
                break;
            case 'zero':
                $rating = "Нейтральные";
                break;
            case 'minus':
                $rating = "Отрицательные";
                break;
            case 'all-rating':
                $rating = "Все";
                break;
        }

        switch ($getDate) {
            case '999':
                $date = "Все";
                break;
            case '1':
                $date = "Месяц";
                break;
            case '3':
                $date = "3 месяца";
                break;
            case '6':
                $date = "Полгода";
            break;
            case '12':
                $date = "Год";
            break;
            case '24':
                $date = "Позднее";
            break;
        }

        $result = array(
          'genre' => $sqlTitle['name'],
          'date' => $date,
          'rating' => $rating
        );

        return $result;
    }
}
