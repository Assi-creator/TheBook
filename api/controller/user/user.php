<?php

namespace TheBook;

session_start();

require $_SERVER['DOCUMENT_ROOT'] . "/api/modules/Base.class.php";

$base = new Base;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'auth') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    $result = (new DataBase)->getAll("SELECT * FROM profile p JOIN reader r on r.id_reader = p.id_reader WHERE login='" . $login . "' AND password='" . $password . "'");
    if (!empty($result)) {
        $_SESSION['user'] = $result[0];
        echo json_encode($base->request_api(true, 'Пользователь найден'));
    } else {
        echo json_encode($base->request_api(false, null, 'Пользователь не найден!'));
    }
} else if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'reg') {

    if(!empty($_FILES['avatar']['name'])){
        $imgName = $_POST['login'] . "_" . $_FILES['avatar']['name'];
        $fileTmpName = $_FILES['avatar']['tmp_name'];
        $fileType = $_FILES['avatar']['type'];
        $destination = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/profiles/" . $imgName;

        if(strpos($fileType, 'image') === false){
            $_POST['avatar'] = "/assets/images/root/icons/noavatar.svg";
        } else {
            $check = move_uploaded_file($fileTmpName, $destination);
            if ($check) {
                $_POST['avatar'] = "/assets/images/profiles/" . $imgName;
            } else {
                $_POST['avatar'] = "/assets/images/root/icons/noavatar.svg";
            }
        }
    }

    if($_POST['avatar'] == 'undefined'){
        $_POST['avatar'] = "/assets/images/root/icons/noavatar.svg";
    }

    $card = trim($_POST['card']);
    $reader = trim($_POST['reader']);
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);
    $email = trim($_POST['password']);
    $about = trim($_POST['about']);
    $avatarurl = trim($_POST['avatarurl']);
    $avatar = trim($_POST['avatar']);

    $query = "INSERT INTO profile SET ?u";
    $in = array(
        'login' => $login,
        'password' => $password,
        'about' => $about,
        'email' => $email,
        'reserved_email' => null,
        'avatar_path' => $avatarurl,
        'cover_path' => null,
        'id_reader' => 1
    );
    echo json_encode($in);
    $base->db->query($query, $in);
} else {
    unset($_SESSION['user']);
    header('Location: /index.php');
}






