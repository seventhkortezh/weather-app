<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="2.0.0",
 *      title="Weather aggregator",
 *      description="L5 Swagger OpenApi description",
 * )
 * @OA\Tag(
 *     name="Погода",
 *     description="Получение информации о погоде"
 * )
 * @OA\Tag(
 *     name="Статистика",
 *     description="Статистика использования сервиса"
 * )
 * @OA\Server(
 *     url="http://localhost/",
 *     description="Local API server"
 * )
 * @OA\Schema(
 *     schema="ErrorMessage",
 *     title="ErrorMessage",
 *     type="object",
 *     @OA\Property(
 *          property="message",
 *          type="string",
 *          description="Описание ошибки"
 *     )
 * )
 * @OA\Schema(
 *     schema="SuccessMessage",
 *     title="SuccessMessage",
 *     type="object",
 *     @OA\Property(
 *          property="id",
 *          type="integer",
 *          description="Идентификатор"
 *     ),
 *     @OA\Property(
 *          property="message",
 *          type="string",
 *          description="Описание успешного действия"
 *     )
 * )
 * @OA\Response(
 *     response="NotFound",
 *     description="Route not found",
 *     @OA\JsonContent(ref="#/components/schemas/ErrorMessage")
 * )
 * @OA\Response(
 *     response="SuccessNew",
 *     description="Successfully created",
 *     @OA\JsonContent(ref="#/components/schemas/SuccessMessage")
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
