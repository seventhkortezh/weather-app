<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema()
 */

class StatResource extends JsonResource
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
     *   property="count",
     *   type="integer",
     *   description="Количество запросов в период"
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'city' => $this->city->name,
            'count' => $this->count,
        ];
    }
}
