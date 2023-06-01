<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatsRequest;
use App\Http\Resources\StatCollection;
use App\Services\StatService;

class StatsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/stats",
     *     summary="Статистика запросов погоды по городам",
     *     tags={"Статистика"},
     *     @OA\Parameter(
     *         name="period",
     *         in="query",
     *         description="Statistic period (day/month)",
     *         @OA\Schema(
     *             type="string",
     *             example="month"
     *         )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Successful response",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/StatResource")
     *              )
     *          )
     *     ),
     *     @OA\Response(response="404", ref="#/components/responses/NotFound")
     * )
     */
    public function index(StatsRequest $request, StatService $statService): StatCollection
    {
        return new StatCollection($statService->statistic($request->validated()));
    }
}
