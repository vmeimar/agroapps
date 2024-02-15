<?php

namespace App\Services;

use App\Constants;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherApiService
{
    public function getWeatherByLocation($location)
    {
        try {
            return Http::get(Constants::WEATHER_API_URL . 'forecast.json', [
                'q' =>  $this->formatRequestCoordinates($location),
                'key'   =>  env('WEATHER_API_KEY')
            ])->json();
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
            return $e->getCode();
        }
    }

    private function formatRequestCoordinates($location): string
    {
        return $location->latitude.','.$location->longitude;
    }
}
