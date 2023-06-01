<?php

namespace App\Services\WeatherSources;

use App\Helpers\GeocodeHelper;
use App\Models\City;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use YaGeo;

class OpenmeteoSourceService
{
    public $apiUrl;

    private $responseMap = [
        'hourly',
        'temperature_2m',
        0
    ];

    public function getTemperature(Collection $cities): array
    {
        $weatherByCity = [];
        $cities->each(function ($city, $key) use (&$weatherByCity) {
            $weatherByCity[] = [
                'city_id' => $city->id,
                'source' => 'openmeteo',
                'value' => $this->getTemperatureByCity($city)
            ];
        });

        return $weatherByCity;
    }

    private function getTemperatureByCity(City $city): string|false
    {
        $response = false;
        $coord = GeocodeHelper::getCoordinates(YaGeo::setQuery($city->name)->load());
        if( $coord ) {
            $response = $this->getResponse(['longitude' => $coord['longitude'], 'latitude' => $coord['latitude']]);
        }

        return $response ? $this->formatData($response) : false;
    }

    private function getResponse(array $data): \Illuminate\Http\Client\Response|false
    {
        $response = Http::get($this->apiUrl . '&' . http_build_query($data));

        return $response->successful() ? $response : false;
    }

    private function formatData(\Illuminate\Http\Client\Response $response): string|false
    {
        $data = $response->json();
        foreach ($this->responseMap as $item) {
            $data = $data[$item];
        }

        return $data;
    }
}
