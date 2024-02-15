<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenMeteoForecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'forecast_date',
        'daily_forecast',
        'hourly_forecast',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
