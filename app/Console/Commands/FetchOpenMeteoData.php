<?php

namespace App\Console\Commands;

use App\Constants;
use App\Models\OpenMeteoForecast;
use App\Services\OpenMeteoService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FetchOpenMeteoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-open-meteo-data {location}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(OpenMeteoService $service)
    {
        $location = $this->argument('location');
        $result = $service->getWeatherByLocation($location);

        if (!$result) {
            $this->error('Something went wrong while calling OpenMeteo service. Please see logs.');
        }

        try {
            OpenMeteoForecast::updateOrCreate([
                'location_id'   =>  $location->id,
                'forecast_date' =>  date(Constants::DATE_FORMAT, strtotime('now')),
            ],
                [
                    'daily_forecast' => json_encode($this->extractDailyData($result)),
                    'hourly_forecast' => json_encode($this->extractHourlyData($result)),
                ]
            );
            $this->info('Successfully stored OpenMeteo forecast data.');
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
        }
    }

    private function extractHourlyData($data): array
    {
        $hourlyData = [];

        for ($i=0; $i<count($data['hourly']['time']); $i++) {
            $hourlyData[] = [
                'hour'      =>  $data['hourly']['time'][$i],
                'temp_c'    =>  $data['hourly']['temperature_2m'][$i],
                'precip_mm' =>  $data['hourly']['precipitation'][$i],
            ];
        }
        return $hourlyData;
    }

    private function extractDailyData($data): array
    {
        return [
            'maxtemp_c' =>  $data['daily']['temperature_2m_max'][0],
            'mintemp_c' =>  $data['daily']['temperature_2m_min'][0],
            'totalprecip_mm' =>  $data['daily']['precipitation_sum'][0],
        ];
    }
}
