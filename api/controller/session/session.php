<?php

namespace TheBook\controller;
use TheBook\Base;
use TheBook\Mailer;
use TheBook\Utils;

class session extends Base {

    /**
     * Авторизация пользователя в систему
     * @param $obj
     * @return array|null
     */
    protected function auth($obj): ?array
    {
        $login = stripslashes(trim($obj['login']));
        $password = trim($obj['password']);
        $utils = new Utils();

        $result = $this->db->getRow("SELECT * FROM profile p JOIN reader r on r.id_reader = p.id_reader WHERE login='" . $login . "'");
        if (!empty($result) && password_verify($password, $result['password'])) {
            $_SESSION['user'] = $result;
            $utils->setSession($_SESSION['user']['id_profile']);
            return $this->request_api(true, 'Пользователь найден');
        } else {
            return $this->request_api(false, null, 'Пользователь не найден!');
        }
    }

    /**
     * Регистрация пользователя в системе
     * @param $obj
     * @return array
     */
    protected function registration($obj): array
    {
        $card = stripslashes(trim($obj['card']));
        $reader = stripslashes(trim(str_replace(' ', '',$obj['reader'])));
        $email = stripslashes(trim($obj['email']));
        $login = stripslashes(trim($obj['login']));
        $password = stripslashes(trim($obj['password']));
        $utils = new Utils();

        if (!$utils->checkReader($card, $reader)) {
            return $this->request_api(false, null, 'Неверно указан номер читательской карточки или ФИО читателя');
        }

        if (!$utils->checkExistsLogin($login)) {
            return $this->request_api(false, null, 'Логин занят');
        }

        if(strlen($password) < 8) {
            return $this->request_api(false, null, 'Пароль должен содержать не менее 8 символов');
        }

        if (!$utils->checkExistsEmail($email)) {
            return $this->request_api(false, null, 'Email занят');
        }

        if($email != null && !$utils->checkEmail($email)){
            return $this->request_api(false, null, 'Указан некорректный email');
        }

        if(!$utils->checkExistAccount($card)){
            return $this->request_api(false, null, 'Данный читатель уже зарегистрирован');
        }

        $avatar = $utils->setAvatar($_POST, $_FILES);
        $reader = $this->db->getRow("SELECT id_reader FROM reader WHERE card='" . $card . "'");
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
        $this->db->query($query, $in);
        $result = $this->db->getRow("SELECT * FROM profile p JOIN reader r on r.id_reader = p.id_reader ORDER BY id_profile DESC LIMIT 1");

        $_SESSION['user'] = $result;
        return $this->request_api(true, null);
    }

    /**
     * Выход пользователя из системы и удаление переменных сессии
     * @return void
     */
    protected function logout() {
        unset($_SESSION['user']);
        header('Location: /index.php');
    }

    /**
     * Функционал модального окна "Сбросить пароль"
     * @param $obj
     * @return array
     */
    protected function forgotPassword($obj): array
    {
        $email = $obj['email'];
        $user = $obj['user'];
        $utils = new Utils();

        if(empty($email) OR empty($user)){
            return $this->request_api(false, null, 'Заполните все поля ввода');
        }

        if(!$utils->checkEmail($email)){
            return $this->request_api(false, null, 'Некорректный email');
        }

        if(!$utils->checkEmailUser($email, $user)){
            return $this->request_api(false, null,'Пользователь с такой почтой не найден');
        } else {
            $mailer = new Mailer;
            if($mailer->sendEmail($email, 1)){
                return $this->request_api(true, 'Инструкция по сбросу пароля отправлена на почту');
            } else {
                return $this->request_api(false, null,'Ошибка отправки письма');
            }
        }
    }
}
