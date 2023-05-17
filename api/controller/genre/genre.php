<?php

namespace TheBook;

require $_SERVER['DOCUMENT_ROOT'] . '/api/vendor/autoload.php';

class Genre extends Base
{

    /**
     * @return array
     */
    function getAllTitleGenre(): array
    {
        return $this->db->getAll("SELECT * FROM genre_title");
    }

    /**
     * @param $title
     * @return array
     */
    function getAllSubgenre($title): array
    {
        return $this->db->getAll("SELECT * FROM subgenres JOIN genre g on g.id_genre = subgenres.id_genre WHERE id_title = '" . $title . "' ORDER BY subgenres.id_title ");
    }

    /**
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
}
