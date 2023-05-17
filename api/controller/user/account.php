<?php

namespace TheBook;

session_start();

require $_SERVER['DOCUMENT_ROOT'] . "/api/modules/Base.class.php";

$base = new Base;
$db = new DataBase;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] = 'editprofile') {
    $login = trim($_POST['login']);
    $about = trim($_POST['about']);

    if (strlen($login) < 1) {
        echo json_encode($base->request_api(false, null, 'Некорректный логин'), JSON_UNESCAPED_UNICODE);
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
        'about' => $about,
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
} else {
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

