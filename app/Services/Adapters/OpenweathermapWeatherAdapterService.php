<?php

namespace App\Services\Adapters;

use App\Interfaces\WeatherInterface;
use App\Services\WeatherSources\OpenweathermapSourceService;
use Illuminate\Database\Eloquent\Collection;

class OpenweathermapWeatherAdapterService implements WeatherInterface
{
    private OpenweathermapSourceService $openweathermapSourceService;
    public function __construct(OpenweathermapSourceService $openweathermapSourceService)
    {
        $this->openweathermapSourceService = $openweathermapSourceService;
        $this->setup();
    }

    public function setup()
    {
        $this->openweathermapSourceService->apiUrl = config('weatherProviders.openweathermap.api_url');
        $this->openweathermapSourceService->apiKey = config('weatherProviders.openweathermap.api_key');
    }

    public function getTemperature(Collection $cities): array
    {
        return $this->openweathermapSourceService->getTemperature($cities);
    }
}
