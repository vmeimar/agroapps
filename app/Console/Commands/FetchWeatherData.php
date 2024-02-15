<?php

namespace App\Console\Commands;

use App\Models\Location;
use Illuminate\Console\Command;

class FetchWeatherData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-weather-data {locationName?} {--locations=single}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch weather data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (
            $this->option('locations') == 'single'
            && empty($this->argument('locationName'))
        ) {
            $this->error('Empty location name');
            return;
        }

        if ($this->option('locations') == 'all') {
            $this->fetchAllLocationsWeatherData();
            return;
        }

        $location = Location::where(
            'name',
            $this->argument('locationName')
        )->first();

        if (!$location) {
            $this->error('Location with name: ' . $this->argument('locationName') . ' not found');
            return;
        }
        $this->fetchSingleLocationWeatherData($location);
    }

    private function fetchSingleLocationWeatherData($location): void
    {
        $this->info('');
        $this->call('app:fetch-single-location-weather-data', [
            'location' => $location
        ]);
    }

    private function fetchAllLocationsWeatherData(): void
    {
        $locations = Location::all();

        foreach ($locations as $location) {
            $this->fetchSingleLocationWeatherData($location);
        }
    }
}
