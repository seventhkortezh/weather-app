<?php

namespace App\Console\Commands;

use App\Services\WeatherReceiverService;
use Illuminate\Console\Command;

class GetWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:get {source?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting weather data from various APIs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(WeatherReceiverService $weatherReceiverService)
    {
        $source = $this->argument('source');
        $enabledSources = config('weather.enabled_sources');

        if( !empty($source) ){
            $enabledSources = array_intersect($enabledSources, [$source]);
        }

        if( count($enabledSources) == 0 ){
            $this->error('No weather sources found!');
            return Command::FAILURE;
        }

        $weatherReceiverService->handle($enabledSources);

        return Command::SUCCESS;
    }
}
