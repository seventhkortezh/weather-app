<?php

namespace App\Helpers;

/**
 * Класс Хелпер для обработки данных от YaGeo
 * @author Alex Novikov <kortezh@list.ru>
 */
class GeocodeHelper
{

    /**
     * Метод проверяет наличие координат в массиве ответа от Яндекс Geocode API
     * @param object $geo объект YaGeo с данными о запрошенном городе
     * @return array|false
     */
    public static function getCoordinates(object $geo):array|false
    {
        $data = $geo->getResponse()->getData();

        if(
            !empty($data['response'])
            && !empty($data['response']['GeoObjectCollection'])
            && !empty($data['response']['GeoObjectCollection']['featureMember'])
            && count($data['response']['GeoObjectCollection']['featureMember']) > 0
        ){
            $data = current($data['response']['GeoObjectCollection']['featureMember']);
            $coord = [];
            list($coord['longitude'], $coord['latitude']) = explode(' ', $data['GeoObject']['Point']['pos']);

            return $coord;
        }

        return false;
    }

}
