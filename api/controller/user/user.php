<?php

namespace TheBook\controller;

use TheBook\Base;
use TheBook\Utils;

require $_SERVER['DOCUMENT_ROOT'] . '/api/vendor/autoload.php';

class user extends Base {

    /**
     * Функция возвращает количество книг с разными статусами и количество рецензий для пользователя
     * @param $profile
     * @return array
     */
    public function getCountActionForProfile($profile): ?array
    {
        $reading = $this->db->getRow("SELECT count(id_action) AS 'reading' FROM book_action WHERE id_profile = " . $profile . " AND id_action = 1");
        $read = $this->db->getRow("SELECT count(id_action) AS 'read' FROM book_action WHERE id_profile = " . $profile . " AND id_action = 2");
        $wish = $this->db->getRow("SELECT count(id_action) AS 'wish' FROM book_action WHERE id_profile = " . $profile . " AND id_action = 3");
        $review = $this->db->getRow("SELECT count(id_review) AS 'review' FROM review WHERE id_profile = " . $profile . "");

        return array(
            'reading' => $reading['reading'],
            'read' => $read['read'],
            'wish' => $wish['wish'],
            'review' => $review['review']
        );
    }

    /**
     * Функция возвращает все ревью пользователя от новых к старым
     * @param $profile
     * @return array
     */
    public function getAllProfileReviews($profile): ?array
    {
        $sql = "SELECT id_review, review.id_book AS `id_book`, id_profile, title, rating, text, date, b.name AS `book`, image, a.name AS `author` FROM review 
                                                        JOIN book b on b.id = review.id_book 
                                                        JOIN book_author ba on b.id = ba.id_book 
                                                        JOIN author a on a.id_author = ba.id_author
                                                                    WHERE id_profile = " . $profile . " ORDER BY date asc";

        $result = $this->db->getAll($sql);
        return array_reverse($result);
    }

    /**
     * Функция возвращает все ревью пользователя с оценкой от положительных до отрицательных
     * @param $profile
     * @return array
     */
    function getAllProfileReviewsByRating($profile): ?array
    {
        $sql = "SELECT id_review, review.id_book AS `id_book`, id_profile, title, rating, text, date, b.name AS `book`, image, a.name AS `author` FROM review 
                                                        JOIN book b on b.id = review.id_book 
                                                        JOIN book_author ba on b.id = ba.id_book 
                                                        JOIN author a on a.id_author = ba.id_author
                                                                    WHERE id_profile = " . $profile . " ORDER BY rating DESC";

        return $this->db->getAll($sql);
    }

    /**
     * Возвращает массив истории входа в систему пользователем
     * @return array|null
     */
    public function getAllSessions(): ?array
    {
        $sql = "SELECT * FROM sessions WHERE id_profile = '" . $_SESSION['user']['id_profile'] . "'";

        return $this->db->getAll($sql);
    }

    /**
     * Записывает в базу данных статус пользователя
     * @param $obj
     * @return array
     */
    public function saveAction($obj): array
    {
        //TODO: Суть удаляется оценка отлично при изменении с 2 на 1/3 но не добавляется больше INSERT нужно где-то добавить
        $book = $obj['book'];
        $profile = $obj['profile'];
        $action = $obj['act'];
        $mark = $obj['mark'];
        $review = $obj['review'];

        $this->log->debug('saveAction Array:', $obj);

        $countAction = $this->db->getRow("SELECT count(*) AS `count` FROM book_action WHERE id_profile = '".$profile."' AND id_book = '".$book."'");
        if ($countAction['count'] == 0) {
            $insertAction = "INSERT INTO book_action SET ?u";
            $insertMark = "INSERT INTO mark SET ?u";

            $inAction = array(
              'id_book' => $book,
              'id_profile' => $profile,
              'id_action' => $action
            );

            if ($action == 2){
                $inMark = array(
                    'id_book' => $book,
                    'id_profile' => $profile,
                    'mark' => $mark
                );
                try{
                    $this->db->query($insertMark, $inMark);
                    $this->log->info('Successful saving new mark: ', array());
                } catch (\Exception $e){
                    $this->log->error('Error saving new mark: ', array($e));
                }
            }
            try {
                $this->db->query($insertAction, $inAction);
                $this->log->info('Successful saving new action: ', array());
            } catch (\Exception $e) {
                $this->log->error('Error saving new action: ', array($e));
            }
        } else {
            $updateAction = "UPDATE book_action SET id_action = '".$action."' WHERE id_profile = '".$profile."' AND id_book = '".$book."'";
            if ($action == 1 OR $action == 3){
                $countMark = $this->db->getRow("SELECT count(mark) AS `count` FROM mark WHERE id_book = '".$book."' AND id_profile = '".$profile."'");

                if ($countMark['count'] == 1) {
                    try {
                        $this->db->query("DELETE FROM mark WHERE id_book = '".$book."' AND id_profile = '".$profile."'");
                        $this->log->info('Successful remove mark for 1/3 action: ', array());
                    } catch (\Exception $e){
                        $this->log->error('Error remove mark for 1/3 action: ', array($e));
                    }
                }
                $this->db->query($updateAction);
                $this->log->info('Successful update action 1/3: ', array());
            } else {
                $updateMark = "UPDATE mark SET mark = '".$mark."' WHERE id_profile = '".$profile."' AND id_book = '".$book."'";
                $countMark = $this->db->getRow("SELECT count(mark) AS `count` FROM mark WHERE id_book = '".$book."' AND id_profile = '".$profile."'");

                if ($countMark['count'] == 1) {
                    $this->db->query($updateMark);
                    $this->log->info('Successful update mark for 2 ', array());
                } else {
                    $insertMark = "INSERT INTO mark SET ?u";
                    $inMark = array(
                        'id_book' => $book,
                        'id_profile' => $profile,
                        'mark' => $mark
                    );
                    $this->db->query($insertMark, $inMark);
                    $this->log->info('Successful saving new mark: ', array());
                }
                $checkReview = $this->db->getRow("SELECT count(*) AS `count` FROM review WHERE id_profile = '".$profile."' AND id_book = '".$book."'");

                if ($checkReview['count'] == 1) {
                    try {
                        $this->db->query("UPDATE review SET rating = '".$mark."' WHERE id_review = '".$review."'");
                        $this->log->info('Successful change mark for review ', array());
                    } catch (\Exception $e) {
                        $this->log->error('Error change mark for review ', array($e));
                    }
                }

                try {
                    $this->db->query($updateAction);
                    $this->log->info('Successful update action 2 ', array());
                } catch (\Exception $e) {
                    $this->log->error('Error saving action 2  ', array($e));
                }
            }
        }
        return $this->request_api(true, 'Смотри логи');
    }

    /**
     * Удаление статуса у книги
     * @param $obj
     * @return array
     */
    public function removeAction($obj): array
    {
        $profile = trim($obj['profile']);
        $book = trim($obj['book']);
        $utils = new Utils();
        $sql = "DELETE FROM book_action WHERE id_profile = '" . $profile . "' AND id_book = '" . $book . "'";
        $this->db->query($sql);

        if ($utils->checkMark($book, $profile)) {
            $this->db->query("DELETE FROM mark WHERE id_profile = '" . $profile . "' AND id_book = '" . $book . "'");
        }
        return $this->request_api(true, 'Оценка успешно удалена.');
    }

    /**
     * Возвращает количество книг в поджанрах
     * @param $subgenre
     * @return array|void
     */
    function getCountSubgenreBooks($subgenre)
    {
        if ($subgenre != null) {
            return $this->db->getAll("SELECT DISTINCT COUNT(id) AS `count` FROM book 
            JOIN book_genre bg on book.id = bg.id_book 
            JOIN genre g on bg.id_genre = g.id_genre 
        WHERE g.id_genre = " . $subgenre . "");
        }
    }
}
