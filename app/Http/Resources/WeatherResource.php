<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema()
 */

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @OA\Property(
     *   property="city",
     *   type="string",
     *   description="Наименовение города"
     * )
     * @OA\Property(
     *   property="source",
     *   type="string",
     *   description="Наименование источника погоды"
     * )
     * @OA\Property(
     *   property="value",
     *   type="float",
     *   description="Значение температуры воздуха"
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'city' => $this->city->name,
            'source' => $this->source,
            'value' => (float) $this->value,
        ];
    }
}
