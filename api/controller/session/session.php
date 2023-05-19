<?php

namespace TheBook;

session_start();

require $_SERVER['DOCUMENT_ROOT'] . "/api/vendor/autoload.php";
require $_SERVER['DOCUMENT_ROOT'] . "/api/modules/Base.class.php";

$base = new Base;
$db = new DataBase;

if ($_SERVER['REQUEST_METHOD'] === 'POST' AND $_POST['action'] == 'session') {
    $login = stripslashes(trim($_POST['login']));
    $password = trim($_POST['password']);
    $result = $db->getRow("SELECT * FROM profile p JOIN reader r on r.id_reader = p.id_reader WHERE login='" . $login . "'");
    if (!empty($result) && password_verify($password, $result['password'])) {
        $_SESSION['user'] = $result;
        setSession($_SESSION['user']['id_profile']);
        echo json_encode($base->request_api(true, 'Пользователь найден'));
    } else {
        echo json_encode($base->request_api(false, null, 'Пользователь не найден!'));
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' AND $_POST['action'] == 'reg') {

    $card = stripslashes(trim($_POST['card']));
    $reader = stripslashes(trim(str_replace(' ', '',$_POST['reader'])));
    $email = stripslashes(trim($_POST['email']));
    $login = stripslashes(trim($_POST['login']));
    $password = stripslashes(trim($_POST['password']));

    if (!checkReader($card, $reader)) {
        echo json_encode($base->request_api(false, null, 'Неверно указан номер читательской карточки или ФИО читателя'), JSON_UNESCAPED_UNICODE);
        die();
    }

    if (!checkExistsLogin($login)) {
        echo json_encode($base->request_api(false, null, 'Логин занят'), JSON_UNESCAPED_UNICODE);
        die();
    }

    if(strlen($password) < 8) {
        echo json_encode($base->request_api(false, null, 'Пароль должен содержать не менее 8 символов'), JSON_UNESCAPED_UNICODE);
        die();
    }

    if (!checkExistsEmail($email)) {
        echo json_encode($base->request_api(false, null, 'Email занят'), JSON_UNESCAPED_UNICODE);
        die();
    }

    if($email != null && !checkEmail($email)){
        echo json_encode($base->request_api(false, null, 'Указан некорректный email'), JSON_UNESCAPED_UNICODE);
        die();
    }

    if(!checkExistAccount($card)){
        echo json_encode($base->request_api(false, null, 'Данный читатель уже зарегистрирован'), JSON_UNESCAPED_UNICODE);
        die();
    }

    $avatar = setAvatar($_POST, $_FILES);
    $reader = $db->getRow("SELECT id_reader FROM reader WHERE card='" . $card . "'");
    $about = trim($_POST['about']);

    $query = "INSERT INTO profile SET ?u";
    $in = array(
        'login' => $login,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'about' => nl2br($about),
        'email' => $email,
        'reserved_email' => '',
        'avatar_path' => $avatar,
        'cover_path' => '/assets/images/root/icons/back-profile.png',
        'id_reader' => $reader['id_reader']
    );
    $base->db->query($query, $in);
    $result = $db->getRow("SELECT * FROM profile p JOIN reader r on r.id_reader = p.id_reader ORDER BY id_profile DESC LIMIT 1");
    $_SESSION['user'] = $result;
    echo json_encode($base->request_api(true, null));

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' AND $_POST['action'] == 'forgot') {
        $email = $_POST['email'];
        $user = $_POST['user'];

        if(empty($email) OR empty($user)){
            echo json_encode($base->request_api(false, null, 'Заполните все поля ввода'), JSON_UNESCAPED_UNICODE);
            die();
        }

        if(!checkEmail($email)){
            echo json_encode($base->request_api(false, null, 'Некорректный email'), JSON_UNESCAPED_UNICODE);
            die();
        }

        //TODO: БУДЕМ КРАФТИТЬ КОД ВОССТАНОВЛЕНИЯ ДОСТУПА!!!!!!!!!!!!!!!!!!!!!!!

        if(!checkEmailUser($email, $user)){
            echo json_encode($base->request_api(false, null,'Пользователь с такой почтой не найден'), JSON_UNESCAPED_UNICODE);
        } else {
            $mailer = new Mailer;
            if($mailer->sendEmail($email)){
                echo json_encode($base->request_api(true, 'Инструкция по сбросу пароля отправлена на почту'), JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode($base->request_api(false, null,'Ошибка отправки письма'), JSON_UNESCAPED_UNICODE);
            }
        }
}else {
    unset($_SESSION['user']);
    header('Location: /index.php');
}

/**
 * @param $card
 * @param $reader
 * @return bool
 */
function checkReader($card, $reader): bool
{
    $check = (new DataBase)->getRow("SELECT CONCAT(surname,name,patronymic) AS `reader` FROM reader WHERE card='" . $card . "'");
    if ($check != null) {
        return (count($check) == 1 && $check['reader'] == $reader);
    }
    return false;
}

/**
 * @param $email
 * @return bool
 */
function checkExistsEmail($email): bool
{
    if ($email == null){
        return true;
    }
    $check = (new DataBase)->getRow("SELECT count(*) AS `count` FROM profile WHERE email = '" . $email . "'");
    return ($check['count'] == 0);
}

/**
 * @param $login
 * @return bool
 */
function checkExistsLogin($login): bool
{
    $check = (new DataBase)->getRow("SELECT count(*) AS `count` FROM profile WHERE login = '" . $login . "'");
    return ($check['count'] == 0);
}

/**
 * @param $card
 * @return bool
 */
function checkExistAccount($card): bool
{
    $check = (new DataBase)->getRow("SELECT count(*) AS `count` FROM reader JOIN profile p on reader.id_reader = p.id_reader WHERE reader.card='" . $card . "'");
    return ($check['count'] == 0);
}

/**
 * @param $email
 * @return mixed
 */
function checkEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL) ;
}

function setAvatar($post, $files)
{
    switch ($post['value']) {
        case 'undefined':
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

function setSession($profile){
    $base = new Base;
    $sql = "INSERT INTO sessions SET ?u";

    $user_agent = $_SERVER["HTTP_USER_AGENT"];
    $ip = $_SERVER['REMOTE_ADDR'];
    if (strpos($user_agent, "Firefox") !== false) $browser = "Firefox";
    elseif (strpos($user_agent, "Opera") !== false) $browser = "Opera";
    elseif (strpos($user_agent, "Chrome") !== false) $browser = "Chrome";
    elseif (strpos($user_agent, "MSIE") !== false) $browser = "Internet Explorer";
    elseif (strpos($user_agent, "Safari") !== false) $browser = "Safari";
    else $browser = "Неизвестный";

    $inSession = array(
        'id_profile' => $profile,
        'date' => date("Y-m-d H:i:s"),
        'browser' => $browser,
        'ip' => $ip
    );

    $base->db->query($sql, $inSession);
    return;
}

function checkEmailUser($email, $user){
    $base = new Base;
    $login = $base->db->getRow("SELECT count(*) as `count` FROM profile WHERE login = '".$user."' AND (email = '".$email."' OR reserved_email = '".$email."')");
    $card = $base->db->getRow("SELECT count(*) as `count` FROM profile JOIN reader r on r.id_reader = profile.id_reader WHERE card = ".$user." AND (email = '".$email."' OR reserved_email = '".$email."')");

    $base->log->debug('Login select:', $login);
    $base->log->debug('Card select:', $card);

    if ($login['count'] == 1){
        return true;
    } else if($card['count'] == 1) {
        return true;
    } else return false;
}







