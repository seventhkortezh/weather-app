<?php

namespace App\Services;

use App\Models\City;
use App\Models\Weather;
use App\Services\Adapters\YandexWeatherAdapterService;
use App\Services\Adapters\OpenmeteoWeatherAdapterService;
use App\Services\Adapters\OpenweathermapWeatherAdapterService;

class WeatherReceiverService
{
    public function handle(array $sources)
    {
        $cities = $this->getCities();

        foreach ($sources as $source){
            switch ($source){
                case 'yandex':
                    $weather = app()->make(YandexWeatherAdapterService::class);
                    break;
                case 'openmeteo':
                    $weather = app()->make(OpenmeteoWeatherAdapterService::class);
                    break;
                case 'openweathermap':
                    $weather = app()->make(OpenweathermapWeatherAdapterService::class);
                    break;
            }

            $result = $weather->getTemperature($cities);
            $this->saveTemperature($result);
        }
    }

    private function getCities()
    {
       return City::all();
    }

    private function saveTemperature(array $citiesTemp)
    {
        foreach ($citiesTemp as $cityTemp){
            if( $cityTemp['value'] ){
                Weather::create($cityTemp);
            }
        }
    }
}
