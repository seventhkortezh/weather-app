<?php

namespace App\Services\Adapters;

use App\Interfaces\WeatherInterface;
use App\Services\WeatherSources\OpenmeteoSourceService;
use Illuminate\Database\Eloquent\Collection;

class OpenmeteoWeatherAdapterService implements WeatherInterface
{
    private OpenmeteoSourceService $openmeteoSourceService;
    public function __construct(OpenmeteoSourceService $openmeteoSourceService)
    {
        $this->openmeteoSourceService = $openmeteoSourceService;
        $this->setup();
    }

    public function setup()
    {
        $this->openmeteoSourceService->apiUrl = config('weatherProviders.openmeteo.api_url');
    }

    public function getTemperature(Collection $cities): array
    {
        return $this->openmeteoSourceService->getTemperature($cities);
    }
}
