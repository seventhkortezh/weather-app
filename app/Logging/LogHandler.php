<?php

namespace App\Logging;
use App\Events\LogMonologEvent;
use Monolog\Logger as Monolog;
use Monolog\Handler\AbstractProcessingHandler;
use App\Models\Log;

class LogHandler extends AbstractProcessingHandler
{
    public function __construct($level = Monolog::DEBUG)
    {
        parent::__construct($level);
    }

    /**
     * Метод записывает в БД лог
     * @param  array $record
     * @return void
     */
    protected function write(array $record):void
    {
        event(new LogMonologEvent($record));
    }
}
