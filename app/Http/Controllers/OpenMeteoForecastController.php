<?php

namespace App\Http\Controllers;

use App\Models\OpenMeteoForecast;

class OpenMeteoForecastController extends Controller
{
    public function index()
    {
        $weatherForecast = OpenMeteoForecast::all();

        return response()->json($weatherForecast);
    }
}
