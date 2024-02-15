<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weather_api_forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained();
            $table->date('forecast_date');
            $table->json('daily_forecast');
            $table->json('hourly_forecast');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_api_forecasts');
    }
};
