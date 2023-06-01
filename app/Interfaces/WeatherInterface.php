<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface WeatherInterface
{
    public function setup();
    public function getTemperature(Collection $cities);
}
