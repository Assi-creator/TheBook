<?php

namespace TheBook;

session_start();

require $_SERVER['DOCUMENT_ROOT'] . "/api/modules/Base.class.php";

$base = new Base;
$db = new DataBase;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'editprofile') {
    $login = trim($_POST['login']);
    $about = trim($_POST['about']);

    if (strlen($login) < 1) {
        echo json_encode($base->request_api(false, null, 'Некорректный логин' . $login), JSON_UNESCAPED_UNICODE);
        die();
    }

    if (!checkExistsLogin($login)) {
        echo json_encode($base->request_api(false, null, 'Логин занят'), JSON_UNESCAPED_UNICODE);
        die();
    }

    $avatar = setAvatar($_POST, $_FILES);

    $query = "UPDATE profile SET ?u WHERE id_profile = '" . $_SESSION['user']['id_profile'] . "'";
    $update = array(
        'login' => $login,
        'about' => nl2br($about),
        'avatar_path' => $avatar
    );

    $base->db->query($query, $update);
    $result = $db->getRow("SELECT * FROM profile p JOIN reader r on r.id_reader = p.id_reader WHERE p.id_profile = '" . $_SESSION['user']['id_profile'] . "'");
    $_SESSION['user'] = $result;
    echo json_encode($base->request_api(true, 'Профиль обновлен'), JSON_UNESCAPED_UNICODE);


} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'changemark') {
    $profile = trim($_POST['profile']);
    $book = trim($_POST['book']);
    $act = trim($_POST['act']);
    $sql = "SELECT count(*) AS `count` FROM book_action WHERE id_profile = '" . $profile . "' AND id_book = '" . $book . "'";
    $action = $db->getRow($sql);


    if ($action['count'] == 1) {
        $sql = "UPDATE book_action SET id_action = '" . $act . "' WHERE id_profile = '" . $profile . "' AND id_book = '" . $book . "'";
        $db->query($sql);
        echo json_encode($base->request_api(true, $act), JSON_UNESCAPED_UNICODE);
        die();

    } else if ($action['count'] == 0) {
        $sql = "INSERT INTO book_action SET ?u";
        $in = array(
            'id_book' => $book,
            'id_profile' => $profile,
            'id_action' => $act
        );

        $db->query($sql, $in);
        echo json_encode($base->request_api(true, 'Статус успешно добавлен'), JSON_UNESCAPED_UNICODE);
        die();
    } else {
        echo json_encode($base->request_api(false, null, 'Непредвиденная ошибка'), JSON_UNESCAPED_UNICODE);
        die();
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'removemark') {
    $profile = trim($_POST['profile']);
    $book = trim($_POST['book']);
    $sql = "DELETE FROM book_action WHERE id_profile = '" . $profile . "' AND id_book = '" . $book . "'";
    $db->query($sql);

    echo json_encode($base->request_api(true, 'Оценка успешно удалена.'), JSON_UNESCAPED_UNICODE);
    die();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'changeemail') {
   $email = $_POST['email'];


   if (!checkEmail($email)){
       echo json_encode($base->request_api(false, null, 'Некорректный email'), JSON_UNESCAPED_UNICODE);
       die();
   }

   if (!checkExistsEmail($email)){
       echo json_encode($base->request_api(false, null, 'Данный email занят'), JSON_UNESCAPED_UNICODE);
       die();
   }

   $password = $_POST['password'];
   if (!checkPassword($password)){
       echo json_encode($base->request_api(false, null, 'Неверный пароль'), JSON_UNESCAPED_UNICODE);
       die();
   }

    // TODO: Создать класс PHPMailer и отправлять код туда, после отправки записывать email.
    echo json_encode($base->request_api(true, 'Все супер'), JSON_UNESCAPED_UNICODE);
    die();

} else if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'changepassword') {

    $old = $_POST['old'];
    $new = $_POST['new'];
    $repeat = $_POST['repeat'];

    if (empty($old) or empty($new) or empty($repeat)){
        echo json_encode($base->request_api(false, null, 'Заполните все поля'), JSON_UNESCAPED_UNICODE);
        die();
    }

    if (!checkPassword($old)){
        echo json_encode($base->request_api(false, null, 'Неверный пароль'), JSON_UNESCAPED_UNICODE);
        die();
    }

    if ($old == $new){
        echo json_encode($base->request_api(false, null, 'Старый и новый пароли совпадают'), JSON_UNESCAPED_UNICODE);
        die();
    }

    if (strlen($new) < 8){
        echo json_encode($base->request_api(false, null, 'Пароль должен быть не менее 8 символов'), JSON_UNESCAPED_UNICODE);
        die();
    }

    if ($new != $repeat){
        echo json_encode($base->request_api(false, null, 'Пароли не совпадают'), JSON_UNESCAPED_UNICODE);
        die();
    }

    try {
        $sql = "UPDATE profile SET password = '".password_hash($new, PASSWORD_DEFAULT)."' WHERE id_profile = '".$_SESSION['user']['id_profile']."'";
        $db->query($sql);
    } catch (\Exception $e){
        echo json_encode($base->request_api(false, null, 'Внутренняя ошибка сервера: '.$e), JSON_UNESCAPED_UNICODE);
        die();
    }

    echo json_encode($base->request_api(true, 'Все супер'), JSON_UNESCAPED_UNICODE);
    die();

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'changereservedemail') {
    $backup = $_POST['backup'];

    if (empty($backup)){
        echo json_encode($base->request_api(false, null, 'Заполните поле'), JSON_UNESCAPED_UNICODE);
        die();
    }

    if (!checkEmail($backup)){
        echo json_encode($base->request_api(false, null, 'Некорректный email'), JSON_UNESCAPED_UNICODE);
        die();
    }

    if (!checkExistsEmail($backup)){
        echo json_encode($base->request_api(false, null, 'Данный email занят'), JSON_UNESCAPED_UNICODE);
        die();
    }

    // TODO: Создать класс PHPMailer и отправлять код туда, после отправки записывать email.
    echo json_encode($base->request_api(true, 'Все супер'), JSON_UNESCAPED_UNICODE);
    die();
}
else {
    echo json_encode($base->request_api(false, null, 'Непредвиденная ошибка'), JSON_UNESCAPED_UNICODE);
    die();
}

/**
 * @param $login
 * @return bool
 */
function checkExistsLogin($login): bool
{
    $check = (new DataBase)->getRow("SELECT count(*) AS `count` FROM profile WHERE login = '" . $login . "' AND id_profile != '" . $_SESSION['user']['id_profile'] . "'");
    return ($check['count'] == 0);
}

/**
 * @param $post
 * @param $files
 * @return mixed|string|void
 */
function setAvatar($post, $files)
{
    switch ($post['value']) {
        case 'undefined':
        case 'current':
            $avatar = $_SESSION['user']['avatar_path'];
            return $avatar;
        case 'no':
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

function checkExistsEmail($email): bool
{
    if ($email == null){
        return true;
    }
    $check = (new DataBase)->getRow("SELECT count(*) AS `count` FROM profile WHERE email = '" . $email . "'");
    return ($check['count'] == 0);
}

function checkPassword($password): bool
{
    $db = new DataBase;
    $result = $db->getRow("SELECT * FROM profile WHERE id_profile='" . $_SESSION['user']['id_profile'] . "'");
    if (password_verify($password, $result['password'])){
        return true;
    }
    return false;
}

function checkEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL) ;
}

