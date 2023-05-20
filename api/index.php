<?php
namespace TheBook;
require $_SERVER['DOCUMENT_ROOT'] . "/api/vendor/autoload.php";  //
date_default_timezone_set('Europe/Moscow');

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS' or $_SERVER['REQUEST_METHOD'] == 'GET' or $_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json, text/plain, */*');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Credentials: false");
    header('Access-Control-Allow-Headers: *');
    header('Access-Control-Allow-Method: *');
    header("HTTP/1.1 200 OK");

}

if (isset($_POST['Class'], $_POST['function'])) {
    $class_name = $_POST['Class'];
    $function_name = $_POST['function'];

    $class_file = $_SERVER['DOCUMENT_ROOT'] . "/api/controller/{$class_name}/{$class_name}.php";
    if (!file_exists($class_file)) {
        $base = new \TheBook\Base();
        $base->log->error("Class not found: {$class_name}");
        return $base->request_api(false, null, "Class {$class_name} not found");
    }

    require_once $class_file;

    $full_class_name = "TheBook\\controller\\{$class_name}";

    if (!class_exists($full_class_name)) {
        $base = new \TheBook\Base();
        $base->log->error("Class not found: {$class_name}");
        return $base->request_api(false, null, "Class {$class_name} not found");
    }

    $class_instance = new $full_class_name();

    if (!method_exists($class_instance, $function_name)) {
        $base = new \TheBook\Base();
        $base->log->error("Method not found: {$function_name}");
        return $base->request_api(false, null, "Method {$function_name} not found");
    }

    $result = $class_instance->$function_name($_POST);

    echo json_encode($result, true);
}

