<?php

namespace TheBook;

session_start();

require $_SERVER['DOCUMENT_ROOT'] . "/api/modules/Base.class.php";

$base = new Base;

if(!isset($_SESSION['user'])){
    header('Location: /');
}

if($_GET['key'] != $_SESSION['change_key']){
    header('Location: /');
} else {
    $base->db->query("UPDATE profile SET email = '".$_SESSION['tmp_email']."' WHERE id_profile = '".$_SESSION['user']['id_profile']."'");
    $_SESSION['user']['email'] = $_SESSION['tmp_email'];
    unset($_SESSION['tmp_email']);
    $_SESSION['tmp_alert'] = '<div class="green"> <a title="[x]" class="action a-close site-alert-close" onclick="Close();"><span class="i-clear"></span></a>Email успешно обновлен</div>';
    header('Location: /views/reader/');
}




