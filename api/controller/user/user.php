<?php

namespace TheBook;

session_start();

require $_SERVER['DOCUMENT_ROOT'] . "/api/modules/Base.class.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['log'])) {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    $result = (new DataBase)->getAll("SELECT * FROM profile p JOIN reader r on r.id_reader = p.id_reader WHERE login='" . $login . "' AND password='" . $password . "'");
    if (!empty($result)){
        $_SESSION['user'] = $result[0];
        header('Location: http://thebook/');
    } else {
        $errors[] = 'Пользователь не найден!';
        return json_encode($errors);
    }

} else {
    unset($_SESSION['user']);
    header('Location: http://thebook/');
}




