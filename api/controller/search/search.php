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
}
