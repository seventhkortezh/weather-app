<?php

namespace App\Services;

/**
 * Класс сервис для расчёта средней температуры, из переданных вариантов от разных источников
 * @author Alex Novikov <kortezh@list.ru>
 */
class TemperatureAverageService
{
    private $temperature;

    public function __construct(...$fields)
    {
        $this->temperature = $fields;
    }

    /**
     * Метод вычисляет среднее значение
     * @return float
     */
    public function getAverageTemperature():float
    {
        return round(array_sum($this->temperature)/count($this->temperature), 1);
    }

}
