<?php

namespace TheBook;

class Utils extends Base
{
    /**
     * Добавление аватара в директорию проекта
     * @param $post
     * @param $files
     * @return mixed|string|void
     */
    public function setAvatar($post, $files)
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

    /**
     * Проверка на существование логина
     * @param $login
     * @return bool
     */
    public function checkExistsLogin($login): bool
    {
        $check = $this->db->getRow("SELECT count(*) AS `count` FROM profile WHERE login = '" . $login . "' AND id_profile != '" . $_SESSION['user']['id_profile'] . "'");
        return ($check['count'] == 0);
    }

    /**
     * Проверка на существование Email
     * @param $email
     * @return bool
     */
    public function checkExistsEmail($email): bool
    {
        if ($email == null){
            return true;
        }
        $check = $this->db->getRow("SELECT count(*) AS `count` FROM profile WHERE email = '" . $email . "'");
        return ($check['count'] == 0);
    }

    /**
     * Проверка пароля пользователя
     * @param $password
     * @return bool
     */
    public function checkPassword($password): bool
    {
        $result = $this->db->getRow("SELECT * FROM profile WHERE id_profile='" . $_SESSION['user']['id_profile'] . "'");
        if (password_verify($password, $result['password'])){
            return true;
        }
        return false;
    }

    /**
     * Проверка корректности введенного Email
     * @param $email
     * @return mixed
     */
    public function checkEmail($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL) ;
    }

    /**
     * Проверка существования оценки пользователя у книги
     * @param $book
     * @param $profile
     * @return bool
     */
    public function checkMark($book, $profile): bool
    {
        $sql = $this->db->getRow("Select count(*) AS `count` FROM mark WHERE id_profile = '".$profile."' AND id_book = '".$book."' ");

        if ($sql['count'] == 1){
            return true;
        } else return false;
    }

    /**
     * Функция вносить данные о сессии пользователя
     * @param $profile
     * @return void
     */
    public function setSession($profile){
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
        $this->db->query($sql, $inSession);
    }

    /**
     * Проверка существования аккаунта
     * @param $card
     * @return bool
     */
    public function checkExistAccount($card): bool
    {
        $check = $this->db->getRow("SELECT count(*) AS `count` FROM reader JOIN profile p on reader.id_reader = p.id_reader WHERE reader.card='" . $card . "'");
        return ($check['count'] == 0);
    }

    /**
     * Проверка сущестования читательской карточки
     * @param $card
     * @param $reader
     * @return bool
     */
    public function checkReader($card, $reader): bool
    {
        $check = $this->db->getRow("SELECT CONCAT(surname,name,patronymic) AS `reader` FROM reader WHERE card='" . $card . "'");
        if ($check != null) {
            return (count($check) == 1 && $check['reader'] == $reader);
        }
        return false;
    }


    /**
     * Проверка существования Email у пользователя/читателя
     * @param $email
     * @param $user
     * @return bool
     */
    public function checkEmailUser($email, $user): bool
    {
        $login = $this->db->getRow("SELECT count(*) as `count` FROM profile WHERE login = '".$user."' AND (email = '".$email."' OR reserved_email = '".$email."')");
        $card = $this->db->getRow("SELECT count(*) as `count` FROM profile JOIN reader r on r.id_reader = profile.id_reader WHERE card = ".(int)$user." AND (email = '".$email."' OR reserved_email = '".$email."')");

        $this->log->debug('Login select:', $login);
        $this->log->debug('Card select:', $card);

        if ($login['count'] == 1){
            return true;
        } else if($card['count'] == 1) {
            return true;
        } else return false;
    }
}