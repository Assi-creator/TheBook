<?php

namespace TheBook\controller;
use TheBook\Base;

Class review extends Base {

    /**
     * Функция создания новой рецензии
     * @param $obj
     * @return array
     */
    public function newReview($obj): array
    {
        $title = trim($obj['title']);
        $text = nl2br($obj['text']);
        $book = trim($obj['book']);
        $mark = trim($obj['mark']);

        if (empty($title) and empty($text) and empty($mark)){
            return $this->request_api(false, null, 'Заполните хотя бы одно поле');
        }

        $sqlReview = "INSERT INTO review SET ?u";
        $sqlMark = "INSERT INTO mark SET ?u";

        $inReview = array(
            'id_book' => $book,
            'id_profile' => $_SESSION['user']['id_profile'],
            'rating' => $mark,
            'title' => $title,
            'text' => $text,
            'date' => date("Y-m-d H:i:s")
        );

        $inMark = array(
            'id_book' => $book,
            'id_profile' => $_SESSION['user']['id_profile'],
            'mark' => $mark
        );

        $exist = $this->db->getRow("SELECT * FROM book_action WHERE id_profile = '".$_SESSION['user']['id_profile']."' AND id_book = '".$book."'");

        if ($exist['id_action'] != 1 AND $exist['id_action'] != 2 AND $exist['id_action'] != 3) {
            $sqlAction = "INSERT INTO book_action SET ?u";
            $inAction = array(
                'id_book' => $book,
                'id_profile' => $_SESSION['user']['id_profile'],
                'id_action' => 2
            );
            $this->db->query($sqlAction, $inAction);
        } else if ($exist['id_action'] != 2) {
            $sqlAction = "UPDATE book_action SET id_action = 2 WHERE id_profile = '" . $_SESSION['user']['id_profile'] . "' AND id_book = '" . $book . "'";
            $this->db->query($sqlAction);
        }

        try{
            $this->db->query($sqlReview, $inReview);
            $this->db->query($sqlMark, $inMark);

            return $this->request_api(true, 'Рецензия успешно добавлена');
        } catch (\Exception $e){
            $this->log->error('New Review in review.php:', (array)$e);
            return $this->request_api(false, null, 'Внутрення ошибка сервера');
        }
    }

    /**
     * Функция редактирования/удаления рецензии
     * @param $obj
     * @return array|void
     */
    public function editReview($obj) {
        $review = trim($obj['review']);
        $title = trim($obj['title']);
        $text = nl2br($obj['text']);
        $book = trim($obj['book']);
        $mark = trim($obj['mark']);

        $title = str_replace('"', '&quot;', $title);

        if (empty($title) and empty($text) and empty($mark)){
            return $this->request_api(false, null, 'Заполните хотя бы одно поле');
        }

        if ($obj['delete'] == 0){
            $sqlReview = "UPDATE review SET ?u WHERE id_review = '".$review."'";
            $sqlMark = "UPDATE mark SET mark = '".$mark."' WHERE id_profile = '".$_SESSION['user']['id_profile']."' AND id_book = '".$book."'";

            $inReview = array(
                'rating' => $mark,
                'title' => $title,
                'text' => $text,
                'date' => date("Y-m-d H:i:s")
            );

            try{
                $this->db->query($sqlReview, $inReview);
                $this->db->query($sqlMark);

                return $this->request_api(true, 'Рецензия успешно обновлена');
            } catch (\Exception $e){
                $this->log->error('Edit Review in review.php:', (array)$e);
                return $this->request_api(false, null, 'Внутрення ошибка сервера');
            }
        } else {

            try{
                $this->db->query("DELETE FROM review WHERE id_review = '".$review."'");
                return $this->request_api(true, 'Рецензия успешно удалена');
            } catch (\Exception $e){
                $this->log->error('Edit Review in review.php:', (array)$e);
                return $this->request_api(false, null, 'Внутрення ошибка сервера');
            }
        }
    }
}
