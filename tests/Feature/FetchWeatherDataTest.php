<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchWeatherDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_call_command_without_arguments()
    {
        $this->artisan('app:fetch-weather-data')
            ->expectsOutput('Empty location name')
            ->assertExitCode(0);
    }

    public function test_fetch_weather_data_for_unknown_location()
    {
        $this->artisan('app:fetch-weather-data UnknownLocationName')
            ->expectsOutput('Location with name: UnknownLocationName not found')
            ->assertExitCode(0);
    }
}
