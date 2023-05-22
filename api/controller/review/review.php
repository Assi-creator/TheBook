<?php

namespace TheBook\controller;

use TheBook\Base;

require $_SERVER['DOCUMENT_ROOT'] . '/api/vendor/autoload.php';

class review extends Base {

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

        if (empty($mark) and empty($title) and empty($text)) {
            return $this->request_api(false, null, 'Заполните рецензию');
        }

        if (empty($mark)) {
            return $this->request_api(false, null, 'Укажите оценку');
        }

        if (empty($title) and empty($text)) {
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

        $exist = $this->db->getRow("SELECT * FROM book_action WHERE id_profile = '" . $_SESSION['user']['id_profile'] . "' AND id_book = '" . $book . "'");

        if ($exist['id_action'] != 1 and $exist['id_action'] != 2 and $exist['id_action'] != 3) {
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

        try {
            $this->db->query($sqlMark, $inMark);
            $this->db->query($sqlReview, $inReview);

            $_SESSION['tmp_alert'] = '<div class="green"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>Рецензия создана</div>';

            return $this->request_api(true, 'Рецензия успешно добавлена');
        } catch (\Exception $e) {
            $this->log->error('New Review in review.php:', (array)$e);
            return $this->request_api(false, null, 'Внутренняя ошибка сервера');
        }
    }

    /**
     * Функция редактирования/удаления рецензии
     * @param $obj
     * @return array
     */
    public function editReview($obj)
    {
        $review = trim($obj['review']);
        $title = trim($obj['title']);
        $text = nl2br($obj['text']);
        $book = trim($obj['book']);
        $mark = trim($obj['mark']);

        $title = str_replace('"', '&quot;', $title);

        if (empty($title) and empty($text) and empty($mark)) {
            return $this->request_api(false, null, 'Заполните хотя бы одно поле');
        }

        if ($obj['delete'] == 0) {
            $sqlReview = "UPDATE review SET ?u WHERE id_review = '" . $review . "'";
            $sqlMark = "UPDATE mark SET mark = '" . $mark . "' WHERE id_profile = '" . $_SESSION['user']['id_profile'] . "' AND id_book = '" . $book . "'";

            $inReview = array(
                'rating' => $mark,
                'title' => $title,
                'text' => $text,
                'date' => date("Y-m-d H:i:s")
            );

            try {
                $this->db->query($sqlReview, $inReview);
                $this->db->query($sqlMark);

                $_SESSION['tmp_alert'] = '<div class="green"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>Рецензия обновлена</div>';

                return $this->request_api(true, $review);
            } catch (\Exception $e) {
                $this->log->error('Edit Review in review.php:', (array)$e);
                return $this->request_api(false, null, 'Внутрення ошибка сервера');
            }
        } else {

            try {
                $this->db->query("DELETE FROM review WHERE id_review = '" . $review . "'");

                $_SESSION['tmp_alert'] = '<div class="green"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>Рецензия удалена</div>';
                return $this->request_api(true, null);
            } catch (\Exception $e) {
                $this->log->error('Edit Review in review.php:', (array)$e);
                return $this->request_api(false, null, 'Внутрення ошибка сервера');
            }
        }
    }

    public function searchReviewForSingleBook($book, $ratings = null, $orders = null) {
        $id = trim($book);
        $rating = trim($ratings);
        $order = trim($orders);

        switch ($rating) {
            case 'plus':
                $sqlRating = "AND (rating = 4 OR rating = 5)";
                break;
            case 'zero':
                $sqlRating = "AND rating = 3";
                break;
            case 'minus':
                $sqlRating = "AND (rating = 1 OR rating = 2)";
                break;
            case 'all-review':
                $sqlRating = '';
                break;
        }

        switch ($order) {
            case 'rating':
                $sqlOrder = "ORDER BY rating DESC";
                break;
            case 'date':
                $sqlOrder = "ORDER BY date DESC";
                break;
            case 'all-order':
                $sqlOrder = '';
                break;
        }

        $sql = "SELECT * FROM review JOIN profile p on p.id_profile = review.id_profile  WHERE id_book = '" . $id . "' ".$sqlRating." ".$sqlOrder."";
        $this->log->debug("Single book review sql search:", array($sql));
        try {
            $result = $this->db->getAll($sql);
            $this->log->debug("Single book review search:", array($result));
            return $result;
        } catch (\Exception $e){
            $this->log->error("Single book review search:", array($e));
            return $this->request_api(false, null, $e);
        }
    }

    public function getRatingReviewCount($id) {
        $result = array(
          'plus' => $this->db->getCol("SELECT count(*) FROM review WHERE id_book = ".$id." AND (rating = 5 OR rating = 4)"),
          'zero' => $this->db->getCol("SELECT count(*) FROM review WHERE id_book = ".$id." AND rating = 3"),
          'minus' => $this->db->getCol("SELECT count(*) FROM review WHERE id_book = ".$id." AND (rating = 2 OR rating = 1)")
        );
        return $result;
    }


}
