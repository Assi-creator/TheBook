<?php

namespace TheBook;

session_start();

require $_SERVER['DOCUMENT_ROOT'] . "/api/modules/Base.class.php";

$base = new Base;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'session') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    $result = (new DataBase)->getAll("SELECT * FROM profile p JOIN reader r on r.id_reader = p.id_reader WHERE login='" . $login . "' AND password='" . $password . "'");
    if (!empty($result)) {
        $_SESSION['user'] = $result[0];
        echo json_encode($base->request_api(true, 'Пользователь найден'));
    } else {
        echo json_encode($base->request_api(false, null, 'Пользователь не найден!'));
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'reg') {

    $card = trim($_POST['card']);
    $reader = trim($_POST['reader']);
    $email = trim($_POST['email']);
    $login = trim($_POST['login']);

    if (!checkReader($card, $reader)) {
        echo json_encode($base->request_api(false, null, 'Неверно указан номер читательской карточки или ФИО читателя.'));
        die();
    }
    if (!checkExistsEmail($email)) {
        echo json_encode($base->request_api(false, null, 'На указанный email уже зарегистрирован аккаунт.'));
        die();
    }
    if (!checkExistsLogin($login)) {
        echo json_encode($base->request_api(false, null, 'На указанный логин уже зарегистрирован аккаунт.'));
        die();
    }
    $avatar = setAvatar($_POST, $_FILES);

    $reader = (new DataBase)->getRow("SELECT id_reader FROM reader WHERE card='" . $card . "'");
    $password = trim($_POST['password']);
    $about = trim($_POST['about']);

    $query = "INSERT INTO profile SET ?u";
    $in = array(
        'login' => $login,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'about' => $about,
        'email' => $email,
        'reserved_email' => null,
        'avatar_path' => $avatar,
        'cover_path' => null,
        'id_reader' => $reader['id_reader']
    );
    $base->db->query($query, $in);
    echo json_encode($base->request_api(true, null));

} else {
    unset($_SESSION['user']);
    header('Location: /index.php');
}

function checkReader($card, $reader)
{
    $check = (new DataBase)->getRow("SELECT CONCAT(surname) FROM reader WHERE card='" . $card . "'");

    return (count($check) == 1 && $check['reader'] == $reader);
}

function checkExistsEmail($email)
{
    $check = (new DataBase)->getRow("SELECT count(*) FROM profile WHERE email = '" . $email . "'");

    return (count($check) == 0);
}

function checkExistsLogin($login)
{
    $check = (new DataBase)->getRow("SELECT count(*) FROM profile WHERE email = '" . $login . "'");

    return (count($check) == 0);
}

function setAvatar($post, $files)
{
    switch ($post['value']) {
        case 'current':
            $avatar = "/assets/images/root/icons/noavatar.svg";
            return $avatar;
        case 'new':
            if (!empty($files['avatar']['name']) && $post['avatar'] != 'undefined') {
                $imgName = $post['login'] . "_" . $_FILES['avatar']['name'];
                $fileTmpName = $files['avatar']['tmp_name'];
                $fileType = $files['avatar']['type'];
                $destination = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/profiles/" . $imgName;

                if (strpos($fileType, 'image') === false) {
                    $avatar = "/assets/images/root/icons/noavatar.svg";
                } else {
                    $check = move_uploaded_file($fileTmpName, $destination);
                    if ($check) {
                        $avatar = "/assets/images/profiles/" . $imgName;
                    } else {
                        $avatar = "/assets/images/root/icons/noavatar.svg";
                    }
                }
            } else {
                $avatar = "/assets/images/root/icons/noavatar.svg";
            }
            return $avatar;
        case 'url':
            $avatar = $post['avatarurl'];
            return $avatar;
    }
}







