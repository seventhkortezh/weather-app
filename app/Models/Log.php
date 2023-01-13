<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'logs';
    /**
     * @var array $guarded
     */
    protected $guarded = ['id'];
    protected $fillable = ['description', 'origin', 'type', 'result', 'level', 'token', 'ip', 'user_agent', 'session'];
}
