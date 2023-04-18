<?php

namespace Model;

use api\config\Config;
use DataBase\DataBase;
use PDO;

/**
 * @property Config $config
 * @property PDO $db
 */
abstract class Base
{
    protected $method;
    protected $action;

    public $requestUri = [];
    public $requestParams = [];

    public function __construct()
    {
        $this->config = new Config();
        $this->db = new DataBase();

        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
        $this->requestParams = $_REQUEST;

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                self::response(false, "Invalid method.");
            }
        }
    }

    public function run()
    {
        $this->action = $this->getAction();

        # Выполнение метода
        if (method_exists($this, $this->action)) {
            return $this->{$this->action}();
        } else {
            self::response(false, $this->action);
        }
    }

    protected function getAction()
    {
        $method = $this->method;
        switch ($method) {
            case 'POST':
                return 'createCommand';
            default:
                return null;
        }
    }
    function response($ok, $desc){
        if ($ok){
            echo json_encode(array("message" => $desc), JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array("error" => $desc), JSON_UNESCAPED_UNICODE);
        }
    }

    abstract protected function createCommand();
}
