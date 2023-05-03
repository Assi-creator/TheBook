<?php

namespace TheBook;

require 'api/vendor/autoload.php';

class Book extends Base {

    public function test(){
        return $this->db->getAll("SELECT * FROM book");
    }
}