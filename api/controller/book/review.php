<?php

namespace TheBook;

session_start();

require $_SERVER['DOCUMENT_ROOT'] . "/api/modules/Base.class.php";

$base = new Base;
$db = new DataBase;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'newreview') {
    $title = trim($_POST['title']);
    $text = nl2br($_POST['text']);
    $book = trim($_POST['book']);
    $mark = trim($_POST['mark']);

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

    $inAction = array(
        'id_book' => $book,
        'id_profile' => $_SESSION['user']['id_profile'],
        'id_action' => 2
    );

    $exist = $db->getRow("SELECT * FROM book_action WHERE id_profile = '".$_SESSION['user']['id_profile']."' AND id_book = '".$book."'");

    if ($exist['id_action'] != 2){
        $sqlAction = "UPDATE book_action SET id_action = 2 WHERE id_profile = '" . $_SESSION['user']['id_profile'] . "' AND id_book = '".$book."'";
        $db->query($sqlAction);
    } else if (empty($exist)){
        $sqlAction = "INSERT INTO book_action SET ?u";
        $db->query($sqlAction, $inAction);
        $pp = 'ХУЙ';
        //сюда не залезает код и не добавляет в таблицу нихуя ничего
    }

    try{
        $db->query($sqlReview, $inReview);
        $db->query($sqlMark, $inMark);

        echo json_encode($base->request_api(true, 'Рецензия успешно добавлена ' . $pp));
    } catch (\Exception $e){
        echo json_encode($base->request_api(false, null, 'Внутрення ошибка сервера: ' . $pp));
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'editreview'){
    $review = trim($_POST['review']);
    if ($_POST['delete'] == 0){
        $title = trim($_POST['title']);
        $text = nl2br($_POST['text']);
        $book = trim($_POST['book']);
        $mark = trim($_POST['mark']);

        $sqlReview = "UPDATE review SET ?u WHERE id_review = '".$review."'";
        $sqlMark = "UPDATE mark SET mark = '".$mark."' WHERE id_profile = '".$_SESSION['user']['id_profile']."' AND id_book = '".$book."'";

        $inReview = array(
            'rating' => $mark,
            'title' => $title,
            'text' => $text,
            'date' => date("Y-m-d H:i:s")
        );

        try{
            $db->query($sqlReview, $inReview);
            $db->query($sqlMark);

            echo json_encode($base->request_api(true, 'Рецензия успешно обновлена'));
        } catch (\Exception $e){
            echo json_encode($base->request_api(false, null, 'Внутрення ошибка сервера: ' . $e));
        }
    } else {
        try{
      $db->query("DELETE FROM review WHERE id_review = '".$review."'");
            echo json_encode($base->request_api(true, 'Рецензия успешно удалена'));
        } catch (\Exception $e){
            echo json_encode($base->request_api(false, null, 'Внутрення ошибка сервера: ' . $e));
        }
    }
}
