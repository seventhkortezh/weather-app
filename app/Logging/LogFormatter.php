<?php

namespace App\Logging;
use Illuminate\Support\Str;
use Monolog\Formatter\NormalizerFormatter;

class LogFormatter extends NormalizerFormatter
{
    /**
     * type
     */
    const LOG = 'log';
    const STORE = 'store';
    const CHANGE = 'change';
    const DELETE = 'delete';
    /**
     * result
     */
    const SUCCESS = 'success';
    const NEUTRAL = 'neutral';
    const FAILURE = 'failure';
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {
        $record = parent::format($record);
        return $this->getDocument($record);
    }
    /**
     * Convert a log message into an MariaDB Log entity
     *
     * @param array $record
     *
     * @return array
     */
    protected function getDocument(array $record)
    {
        $fills                = $record['extra'];
        $fills['level']       = mb_strtolower($record['level_name']);
        $fills['description'] = $record['message'];
        $fills['token']       = Str::random(30);
        $context              = $record['context'];
        $fills['type']   = !empty($context['type']) ? $context['type'] : self::LOG;
        $fills['result'] = !empty($context['result']) ? $context['result'] : self::NEUTRAL;
        $fills           = array_merge($record['context'], $fills);
        return $fills;
    }
}
