<?php

namespace App\Services\Adapters;

use App\Interfaces\WeatherInterface;
use App\Services\WeatherSources\YandexSourceService;
use Illuminate\Database\Eloquent\Collection;

class YandexWeatherAdapterService implements WeatherInterface
{
    private YandexSourceService $yandexSourceService;
    public function __construct(YandexSourceService $yandexSourceService)
    {
        $this->yandexSourceService = $yandexSourceService;
        $this->setup();
    }

    public function setup()
    {
        $this->yandexSourceService->apiUrl = config('weatherProviders.yandex.api_url');
        $this->yandexSourceService->apiKey = config('weatherProviders.yandex.api_key');
    }

    public function getTemperature(Collection $cities): array
    {
        return $this->yandexSourceService->getTemperature($cities);
    }
}
