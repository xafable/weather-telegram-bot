<?php

namespace App\Weather\Services;

use App\Weather\Weather;
use Illuminate\Support\Collection;

interface WeatherClientInterface
{
    /**
     * fetch weather from weather provider
     */
    public function loadWeather($lat,$lon) : WeatherClientInterface;
    public function getToday() : Weather;
    public function getTomorrow() : Weather;
    public function getAll() : Collection;

}
