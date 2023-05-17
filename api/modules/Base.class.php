<?php

namespace TheBook;

session_start();

require $_SERVER['DOCUMENT_ROOT'] . "/api/vendor/autoload.php";

date_default_timezone_set('Europe/Moscow');
use Exception;

class Base
{
    public ConfigBase $config;
    public DataBase $db;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->config   = new ConfigBase();
        $this->db       = new DataBase($this->config::DB_CONNECT);
    }

    /**
     * @param bool $ok
     * @param $result
     * @param string $description
     * @return array
     */
    function request_api(bool $ok = false, $result = null, string $description = ''): array
    {
        if($ok === true){
            return array(
                'ok' => true,
                'result'=> $result,
            );

        }else{
            return array(
                'ok' => false,
                'description'=> $description,
            );
        }

    }
}
