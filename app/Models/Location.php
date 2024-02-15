<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
    ];

    public function weatherApiData()
    {
        return $this->hasOne(WeatherApiForecast::class);
    }

    public function openMeteoData()
    {
        return $this->hasOne(OpenMeteoForecast::class);
    }
}
