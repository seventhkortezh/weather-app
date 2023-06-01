<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WeatherCollection extends ResourceCollection
{

    private float $average;

    public function __construct($resource, float $average)
    {
        parent::__construct($resource);
        $this->average = $average;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'list' => parent::toArray($request),
            'average' => round($this->average, 2)
        ];
    }
}
