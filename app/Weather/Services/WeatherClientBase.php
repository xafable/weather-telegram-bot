<?php

namespace App\Weather\Services;

use App\Services\HttpClient;
use App\Weather\Weather;
use Illuminate\Support\Collection;

class WeatherClientBase
{
    protected Collection $weather;
    protected HttpClient $httpClient;
    protected Collection $originalData;

    /**
     * get Today Weather Object
     */
    function getToday(): Weather
    {
        return $this->weather->first();
    }

    /**
     * get Tomorrow Weather Object
     */
    function getTomorrow(): Weather
    {
        return $this->weather->offsetGet(2);
    }

    /**
     * get All Days(5) Weather Collection
     */
    function getAll(): Collection
    {
        return $this->weather;
    }



}
