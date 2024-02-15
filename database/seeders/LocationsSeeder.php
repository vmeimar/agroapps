<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            'name' => 'Athens',
            'latitude' => '37.98',
            'longitude' => '23.72',
        ]);

        DB::table('locations')->insert([
            'name' => 'Paris',
            'latitude' => '48.78',
            'longitude' => '2.33',
        ]);
    }
}
