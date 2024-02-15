<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchSingleLocationWeatherData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-single-location-weather-data {location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->fetchWeatherApiServiceWeatherData(
            $this->argument('location')
        );

        $this->fetchOpenMeteoServiceWeatherData(
            $this->argument('location')
        );
    }

    private function fetchWeatherApiServiceWeatherData($location): void
    {
        $this->call('app:fetch-weather-api-data', [
            'location' => $location
        ]);
    }

    private function fetchOpenMeteoServiceWeatherData($location): void
    {
        $this->call('app:fetch-open-meteo-data', [
            'location' => $location
        ]);
    }
}
