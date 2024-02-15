<?php

namespace App\Console\Commands;

use App\Constants;
use App\Models\WeatherApiForecast;
use App\Services\WeatherApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchWeatherApiData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-weather-api-data {location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch weather data from Weather API on requested step and store them in the database';
    private WeatherApiService $service;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(WeatherApiService $service): void
    {
        $location = $this->argument('location');
        $result = $service->getWeatherByLocation($location);

        if (!$result) {
            $this->error('Something went wrong while calling WeatherAPI service. Please see logs.');
        }

        try {
            WeatherApiForecast::updateOrCreate([
                    'location_id'   =>  $location->id,
                    'forecast_date' =>  date(Constants::DATE_FORMAT, strtotime('now')),
                ],
                [
                    'daily_forecast' => json_encode($this->extractDailyData($result)),
                    'hourly_forecast' => json_encode($this->extractHourlyData($result)),
                ]
            );
            $this->info('Successfully stored WeatheAPI forecast data.');
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
        }
    }

    private function extractHourlyData($data): array
    {
        $hourlyData = [];

        foreach ($data['forecast']['forecastday'][0]['hour'] as $hour) {
            $hourlyData[] = [
                'hour'      =>  $hour['time'],
                'temp_c'    =>  $hour['temp_c'],
                'precip_mm' =>  $hour['precip_mm'],
            ];
        }
        return $hourlyData;
    }

    private function extractDailyData($data): array
    {
        return [
            'maxtemp_c' =>  $data['forecast']['forecastday'][0]['day']['maxtemp_c'],
            'mintemp_c' =>  $data['forecast']['forecastday'][0]['day']['mintemp_c'],
            'totalprecip_mm' =>  $data['forecast']['forecastday'][0]['day']['totalprecip_mm'],
        ];
    }
}
