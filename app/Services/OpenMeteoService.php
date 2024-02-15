<?php

namespace App\Services;

use App\Constants;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenMeteoService
{
    public function getWeatherByLocation($location)
    {
        try {
            return Http::get(Constants::OPEN_METEO_URL . 'forecast', [
                'forecast_days' => 1,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'hourly' => Constants::OPEN_METEO_HOURLY_REQUEST_PARAMS,
                'daily' => Constants::OPEN_METEO_DAILY_REQUEST_PARAMS
            ])->json();
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
            return $e->getCode();
        }
    }
}
