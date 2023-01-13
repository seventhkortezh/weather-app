<?php

namespace App\Http\Controllers;
use App\Services\TemperatureAverageService;
use App\Services\WeatherService;

class HomeController extends Controller
{
    public function index()
    {
        $YandexWeather = new WeatherService('yandex');
        $OpenWeatherMap = new WeatherService('openweathermap');
        $OpenMeteoWeather = new WeatherService('openmeteo');

        $average = new TemperatureAverageService(
            $YandexWeather->getTemperatureByCity('Novosibirsk'),
            $OpenWeatherMap->getTemperatureByCity('Novosibirsk'),
            $OpenMeteoWeather->getTemperatureByCity('Novosibirsk'),
        );

        dd(
            'Температура из yandex',
            $YandexWeather->getTemperatureByCity('Novosibirsk'),
            'Температура из openweathermap',
            $OpenWeatherMap->getTemperatureByCity('Novosibirsk'),
            'Температура из openmeteo',
            $OpenMeteoWeather->getTemperatureByCity('Novosibirsk'),
            '',
            'Средняя температура:',
            $average->getAverageTemperature()
        );
        return view('index');
    }
}
