<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WeatherCollection;
use App\Models\City;
use App\Services\StatService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/weather/{city}",
     *     summary="Информация о погоде из разных источников + средняя по всем",
     *     tags={"Погода"},
     *     @OA\Parameter(
     *         name="city",
     *         in="path",
     *         description="City code",
     *         @OA\Schema(
     *             type="string",
     *             example="moscow"
     *         )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Successful response",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="list",
     *                      type="array",
     *                      @OA\Items(ref="#/components/schemas/WeatherResource")
     *                  ),
     *                  @OA\Property(
     *                      property="average",
     *                      type="float"
     *                  ),
     *              )
     *          )
     *     ),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound")
     * )
     */
    public function index(Request $request, City $city, StatService $statService): WeatherCollection
    {
        $statService->set($city);
        return new WeatherCollection($city->weatherCurrentDay, $city->weatherAvgCurrentDay());
    }
}
