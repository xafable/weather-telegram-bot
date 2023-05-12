<?php

namespace App\Weather\Services;

use App\Weather\Weather;
use Illuminate\Support\Collection;

interface WeatherClient
{
    public function loadWeather() : Collection;

}
