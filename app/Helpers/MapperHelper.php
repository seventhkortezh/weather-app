<?php

namespace App\Helpers;

/**
 * Класс Хелпер для маппинга данных от поставщиков погоды
 * @author Alex Novikov <kortezh@list.ru>
 */
class MapperHelper
{
    /**
     * Метод пробегается по "элементу" погоды до конечного значения температуры,
     * на основе "карты" в конфиге источника погоды
     * @param array $map "карты" поиска температуры в массиве
     * @param array $data массив элемента из API источника погоды
     * @return array|string
     */
    public static function handle(array $map, array $data):array|string
    {
        foreach ($map as $itemMap) {
            $data = $data[$itemMap];
        }

        return $data;
    }

}
