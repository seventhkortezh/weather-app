<?php

namespace App\Services;
use App\Models\City;
use App\Models\Stat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Класс сервис для рассчёта статистики запросов температуры
 * @author Alex Novikov <kortezh@list.ru>
 */
class StatService
{

    private Stat $statistic;
    public function __construct(Stat $statistic)
    {
        $this->statistic = $statistic;
    }

    /**
     * Метод получает статистику запросов температуры с группировкой по городам
     * @param City $city
     * @return array
     */
    public function set(City $city): Stat
    {
        return $this->statistic->create(['city_id' => $city->id]);
    }

    public function statistic(array $filter): Collection
    {
        switch ($filter['period']){
            case 'month':
                $statistic = $this->statistic
                    ->whereBetween('datetime',
                        [
                            Carbon::now()->startOfMonth(),
                            Carbon::now()->endOfMonth()
                        ]
                    );
                break;
            case 'day':
                $statistic = $this->statistic->whereDate('datetime', Carbon::today());
                break;
            default:
                throw \Exception('not found period');
        }

        return $statistic
            ->with('city')
            ->select('city_id', DB::raw('count(id) as count'))
            ->groupBy('city_id')
            ->get();
    }

}
