<?php

namespace App\Http\Controllers;

use App\Models\WeatherApiForecast;

class WeatherApiForecastController extends Controller
{
    public function index()
    {
        $weatherForecast = WeatherApiForecast::all();

        return response()->json($weatherForecast);
    }
}
