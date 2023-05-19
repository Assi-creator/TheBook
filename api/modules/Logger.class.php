<?php

namespace TheBook;

require $_SERVER['DOCUMENT_ROOT'] . "/api/vendor/autoload.php";
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
class Logs
{
    protected $logs;
    function __construct()
    {
        $this->logs = new Logger('api');
        $stream = new StreamHandler($_SERVER['DOCUMENT_ROOT'].'/api/logs/debug.log', Logger::DEBUG);
        $this->logs->pushHandler($stream);
        #return $this->logs;
    }

    /**
     * @param string $string
     * @param mixed $context
     * @return void
     */
    public function error(string $string, array $context = []): void
    {
        $this->logs->error($string,$context);
    }

    /**
     * @param string $string
     * @param mixed $context
     * @return void
     */
    public function info(string $string, array $context = []): void
    {
        $this->logs->info($string,$context);
    }

    /**
     * @param string $string
     * @param mixed $context
     * @return void
     */
    public function debug(string $string, array $context = []): void
    {
        $this->logs->debug($string, $context);
    }

}