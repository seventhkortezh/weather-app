<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stat extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'city_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
