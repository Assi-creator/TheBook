<?php

namespace TheBook;

session_start();

require $_SERVER['DOCUMENT_ROOT'] . "/api/modules/Base.class.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log'])) {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    $result = (new DataBase)->getAll("SELECT * FROM profile p JOIN reader r on r.id_reader = p.id_reader WHERE login='" . $login . "' AND password='" . $password . "'");
    $_SESSION['user'] = $result[0];
    print_r($_SESSION);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['forgot'])) {
    echo 'Я забыл((';
}


