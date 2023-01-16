<?php

namespace App\Services;
use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Класс сервис для рассчёта статистики запросов температуры
 * @author Alex Novikov <kortezh@list.ru>
 */
class StatisticService
{

    public function __construct()
    {

    }

    /**
     * Метод получает статистику запросов температуры с группировкой по городам
     * @param string $period
     * @return array
     */
    public function getLast(string $period = 'day'):array
    {
        $dates = $period == 'month' ? Carbon::now()->subMonth() : Carbon::today();
        $result = Log::select('description', DB::raw('count(*) as total'))
            ->whereDate('created_at', '>=', $dates->toDateString())
            ->groupBy('description')
            ->orderBy('total', 'DESC')
            ->pluck('total','description')
            ->toArray();

        return $result;
    }

}
