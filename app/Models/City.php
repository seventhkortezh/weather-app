<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'latitude',
        'longitude',
    ];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function weather()
    {
        return $this->hasMany(Weather::class);
    }

    public function weatherAvg()
    {
        return $this->weather()
            ->selectRaw('avg(value) as avg')
            ->first()
            ->avg ?? 0;
    }

    public function weatherCurrentDay()
    {
        return $this->weather()
            ->whereDate('date', Carbon::today());
    }

    public function weatherAvgCurrentDay()
    {
        return $this->weatherCurrentDay()
            ->selectRaw('avg(value) as avg')
            ->first()
            ->avg ?? 0;
    }

    public function stats()
    {
        return $this->hasMany(Stat::class);
    }
}
