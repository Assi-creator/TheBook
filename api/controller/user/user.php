<?php

namespace TheBook;

require $_SERVER['DOCUMENT_ROOT'] . '/api/vendor/autoload.php';

class User extends Base{

    function getCountActionForProfile($profile){
        $read = $this->db->getRow("SELECT count(id_action) AS 'read' FROM book_action WHERE id_book = ".$profile." AND id_action = 1");
        $reading = $this->db->getRow("SELECT count(id_action) AS 'reading' FROM book_action WHERE id_book = ".$profile." AND id_action = 2");
        $wish = $this->db->getRow("SELECT count(id_action) AS 'wish' FROM book_action WHERE id_book = ".$profile." AND id_action = 3");

        $result = array(
            'read' => $read['read'],
            'reading' => $reading['reading'],
            'wish' => $wish['wish']
        );
        return $result;
    }
}






