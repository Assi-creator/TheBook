<?php

namespace TheBook\controller;

use TheBook\Base;
use TheBook\Mailer;
use TheBook\Utils;

session_start();

require $_SERVER['DOCUMENT_ROOT'] . '/api/vendor/autoload.php';

class account extends Base {

    /**
     * Функция редактирования профиля пользователя
     * @param $obj
     * @return array|null
     */
    public function editProfile($obj, $file = null): ?array
    {
        $login = trim($obj['login']);
        $about = trim($obj['about']);
        $utils = new Utils();

        if (strlen($login) < 1) {
            return $this->request_api(false, null, 'Некорректный логин' . $login);
        }

        if (!$utils->checkExistsLogin($login)) {
            return $this->request_api(false, null, 'Логин занят');
        }

        $avatar = $utils->setAvatar($obj, $file);
        $this->log->debug('Edit Profile AVATAR: ', array($avatar));

        $query = "UPDATE profile SET ?u WHERE id_profile = '" . $_SESSION['user']['id_profile'] . "'";
        $update = array(
            'login' => $login,
            'about' => nl2br($about),
            'avatar_path' => $avatar
        );

        $this->db->query($query, $update);
        $result = $this->db->getRow("SELECT * FROM profile p JOIN reader r on r.id_reader = p.id_reader WHERE p.id_profile = '" . $_SESSION['user']['id_profile'] . "'");
        $_SESSION['user'] = $result;
        return $this->request_api(true, 'Профиль обновлен');
    }

    /**
     * Функция добавления/изменения email пользователя
     * @param $obj
     * @return array|null
     */
    public function changeEmail($obj): ?array
    {
        $email = $obj['email'];
        $utils = new Utils();

        if (!$utils->checkEmail($email)) {
            return $this->request_api(false, null, 'Некорректный email');
        }

        if (!$utils->checkExistsEmail($email)) {
            return $this->request_api(false, null, 'Данный email занят');
        }

        $password = $_POST['password'];
        if (!$utils->checkPassword($password)) {
            return $this->request_api(false, null, 'Неверный пароль');
        }

        $mailer = new Mailer;
        if ($mailer->sendEmail($email, 2)) {
            $_SESSION['tmp_alert'] = '<div class="green"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>На указанную почту отправлено письмо подтверждения</div>';
            return $this->request_api(true, null);
        } else {
            return $this->request_api(false, null, 'Ошибка отправки письма');
        }
    }

    /**
     * Функция изменения пароля пользователя
     * @param $obj
     * @return array|null
     */
    public function changePassword($obj): ?array
    {
        $old = $obj['old'];
        $new = $obj['new'];
        $repeat = $obj['repeat'];
        $utils = new Utils();

        if (empty($old) or empty($new) or empty($repeat)) {
            return $this->request_api(false, null, 'Заполните все поля');
        }

        if (!$utils->checkPassword($old)) {
            return $this->request_api(false, null, 'Неверный пароль');
        }

        if ($old == $new) {
            return $this->request_api(false, null, 'Старый и новый пароли совпадают');
        }

        if (strlen($new) < 8) {
            return $this->request_api(false, null, 'Пароль должен быть не менее 8 символов');
        }

        if ($new != $repeat) {
            return $this->request_api(false, null, 'Пароли не совпадают');
        }

        try {
            $sql = "UPDATE profile SET password = '" . password_hash($new, PASSWORD_DEFAULT) . "' WHERE id_profile = '" . $_SESSION['user']['id_profile'] . "'";
            $this->db->query($sql);
        } catch (\Exception $e) {
            $this->log->error('Change password in account.php:', (array)$e);
            return $this->request_api(false, null, 'Внутренняя ошибка сервера');
        }
        $_SESSION['tmp_alert'] = '<div class="green"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>Пароль успешно изменен</div>';
        return $this->request_api(true, 'Все супер');
    }

    /**
     * Функция изменения пароля из формы "Восстановить пароль"
     * @param $obj
     * @return array
     */
    public function changeForgotPassword($obj): array
    {
        $new = $obj['new'];
        $repeat = $obj['repeat'];

        $this->log->debug('Forgot password form:', array($new, $repeat));

        if (empty($new) or empty($repeat)) {
            return $this->request_api(false, null, 'Заполните все поля');
        }

        if (strlen($new) < 8) {
            return $this->request_api(false, null, 'Пароль должен быть не менее 8 символов');
        }

        if ($new != $repeat) {
            return $this->request_api(false, null, 'Пароли не совпадают');
        }

        try {
            $sql = "UPDATE profile SET password = '" . password_hash($new, PASSWORD_DEFAULT) . "' WHERE email = '" . $_SESSION['tmp_user'] . "' OR reserved_email = '" . $_SESSION['tmp_user'] . "'";
            $this->log->debug('Update forgot password:', array($sql, $_SESSION['tmp_user']));
            $this->db->query($sql);
        } catch (\Exception $e) {
            $this->log->error('Forgot password in account.php:', (array)$e);
            return $this->request_api(false, null, 'Внутренняя ошибка сервера');
        }

        $result = $this->db->getRow("SELECT * FROM profile p JOIN reader r on r.id_reader = p.id_reader WHERE email = '" . $_SESSION['tmp_user'] . "' OR reserved_email = '" . $_SESSION['tmp_user'] . "'");
        unset($_SESSION['change_key']);
        unset($_SESSION['tmp_user']);
        $_SESSION['user'] = $result;

        return $this->request_api(true, 'Пароль изменен');
    }

    /**
     * Функция добавляет/изменяет резервный пароль пользователя
     * @param $obj
     * @return void
     */
    public function changeReservedEmail($obj)
    {
        // TODO: написать данную функцию
    }
}
