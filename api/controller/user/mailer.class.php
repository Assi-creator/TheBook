<?php

namespace TheBook;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

class Mailer extends Base
{
    public function sendEmail($email, $action)
    {
        $to = $email;
        $key = md5($email.rand(1000,9999));
        if ($action == 1) {
            $url = "http://thebook/views/forgot?key=$key";
            $subject = 'Восстановление пароля на сайт';
            $message = "<h2>Восстановление пароля на сайт TheBook</h2>
                    <p>Уважаймый читатель, поступил запрос на изменение вашего пароля.</p>
                    <br>
                    <p>Для изменения пароля перейдите по <a href='$url'>данной ссылке</a>.</p>
                    <p>Если это были не Вы, настоятельно рекомендуем зайти на сайт и изменить пароль.</p>";
            $_SESSION['change_key'] = $key;
            $_SESSION['tmp_user'] = $email;
            $this->log->info('Session change key: ', array($_SESSION['change_key']));
            $this->log->info('Change password info: ', array($key, $url));
        } else {
            $url = "http://thebook/api/controller/user/email.php?key=$key";
            $subject = 'Подтверждение электронной почты';
            $message = "<h2>Подтверждение электронной почты для сайта TheBook</h2>
                    <p>Уважаймый читатель, поступил запрос на изменение вашей электронной почты.</p>
                    <br>
                    <p>Для подтверждения перейдите по <a href='$url'>данной ссылке</a>.</p>
                    <p>Если это были не Вы, настоятельно рекомендуем зайти на сайт и изменить пароль.</p>";
            $_SESSION['change_key'] = $key;
            $_SESSION['tmp_email'] = $email;
            $this->log->info('Session change key: ', array($_SESSION));
            $this->log->info('Change email info: ', array($key, $url));
        }
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.mail.ru';

            $mail->SMTPAuth = true;
            $mail->Username = $this->config::username;
            $mail->Password = $this->config::password;

            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setLanguage('ru');
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $mail->setFrom('mastnastiy14@mail.ru', 'TheBook');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            $this->log->error('Error to sending email: ', array($mail->ErrorInfo));
            return false;
        }
    }

}