<?php

namespace App\Logging;
use Monolog\Logger as Monolog;

/**
 * Логгер от Monolog в БД
 */
class Log
{
    /**
     * Метод создаёт объект Монолога
     * @param array $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Monolog('database');
        $logger->pushHandler(new LogHandler());
        $logger->pushProcessor(new LogProcessor());
        return $logger;
    }

}
