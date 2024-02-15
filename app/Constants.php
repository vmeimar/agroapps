<?php

namespace App;

class Constants
{
    const WEATHER_API_URL = 'http://api.weatherapi.com/v1/';
    const OPEN_METEO_URL = 'https://api.open-meteo.com/v1/';
    const DATE_FORMAT = 'Y-m-d';
    const OPEN_METEO_HOURLY_REQUEST_PARAMS = 'temperature_2m,precipitation';
    const OPEN_METEO_DAILY_REQUEST_PARAMS = 'temperature_2m_max,temperature_2m_min,precipitation_sum';
}
