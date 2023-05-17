<?php

namespace TheBook;

require $_SERVER['DOCUMENT_ROOT'] . '/api/vendor/autoload.php';

class User extends Base
{

    /**
     * @param $profile
     * @return array
     */
    function getCountActionForProfile($profile): array
    {
        $reading = $this->db->getRow("SELECT count(id_action) AS 'reading' FROM book_action WHERE id_profile = " . $profile . " AND id_action = 1");
        $read = $this->db->getRow("SELECT count(id_action) AS 'read' FROM book_action WHERE id_profile = " . $profile . " AND id_action = 2");
        $wish = $this->db->getRow("SELECT count(id_action) AS 'wish' FROM book_action WHERE id_profile = " . $profile . " AND id_action = 3");
        $review = $this->db->getRow("SELECT count(id_review) AS 'review' FROM review WHERE id_profile = " . $profile . "");

        $result = array(
            'reading' => $reading['reading'],
            'read' => $read['read'],
            'wish' => $wish['wish'],
            'review' => $review['review']
        );
        return $result;
    }

    /**
     * @param $profile
     * @return array
     */
    function getAllProfileReviews($profile): array
    {
        $sql = "SELECT id_review, review.id_book AS `id_book`, id_profile, title, rating, text, date, b.name AS `book`, image, a.name AS `author` FROM review 
                                                        JOIN book b on b.id = review.id_book 
                                                        JOIN book_author ba on b.id = ba.id_book 
                                                        JOIN author a on a.id_author = ba.id_author
                                                                    WHERE id_profile = " . $profile . "";

        $result = $this->db->getAll($sql);
        return array_reverse($result);
    }

    /**
     * @param $profile
     * @return array
     */
    function getAllProfileReviewsByRating($profile): array
    {
        $sql = "SELECT id_review, review.id_book AS `id_book`, id_profile, title, rating, text, date, b.name AS `book`, image, a.name AS `author` FROM review 
                                                        JOIN book b on b.id = review.id_book 
                                                        JOIN book_author ba on b.id = ba.id_book 
                                                        JOIN author a on a.id_author = ba.id_author
                                                                    WHERE id_profile = " . $profile . " ORDER BY rating DESC";

        $result = $this->db->getAll($sql);
        return $result;
    }
}






