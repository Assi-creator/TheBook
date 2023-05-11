<?php

namespace TheBook;

session_start();

require $_SERVER['DOCUMENT_ROOT'] . "/api/modules/Base.class.php";

$base = new Base;
$db = new DataBase;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'editprofile') {
    $login = trim($_POST['login']);
    $about = trim($_POST['about']);

    if(strlen($login) < 1){
        echo json_encode($base->request_api(false, null, 'Некорректный логин'), JSON_UNESCAPED_UNICODE);
        die();
    }

    if (!checkExistsLogin($login)) {
        echo json_encode($base->request_api(false, null, 'Логин занят'), JSON_UNESCAPED_UNICODE);
        die();
    }

    $avatar = setAvatar($_POST, $_FILES);

    $query = "UPDATE profile SET ?u WHERE id_profile = '".$_SESSION['user']['id_profile']."'";
    $update = array(
        'login' => $login,
        'about' => $about,
        'avatar_path' => $avatar
    );

    $base->db->query($query, $update);
    $result = $db->getRow("SELECT * FROM profile p JOIN reader r on r.id_reader = p.id_reader WHERE p.id_profile = '".$_SESSION['user']['id_profile']."'");
    $_SESSION['user'] = $result;

    echo json_encode($base->request_api(true, null));
}

function checkExistsLogin($login)
{
    $check = (new DataBase)->getRow("SELECT count(*) AS `count` FROM profile WHERE login = '" . $login . "' AND id_profile != '".$_SESSION['user']['id_profile']."'");
    return ($check['count'] == 0);
}

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
