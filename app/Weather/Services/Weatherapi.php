<?php

namespace App\Weather\Services;

use App\Services\HttpClient;
use App\Weather\Weather;
use Illuminate\Support\Collection;

class Weatherapi extends WeatherClientBase implements WeatherClientInterface
{

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    function loadWeather($lat, $lon): WeatherClientInterface
    {
        $this->originalData = $this->httpClient->fetch('api.weatherapi.com/v1/forecast.json?key=fc610ea6ed5e4d64960151224232004&q=48.8567,2.3508&days=5&lang=uk');

        $this->_createWeather($this->originalData);

        return $this;
    }


    /**
     * make Weather Collection from Weather Provider data
     */
    private function _createWeather($response): void
    {
        $weatherCollection = collect();
        foreach ($response['forecast']['forecastday'] as $key => $item) {
            $arr = [];
            for ($i = 0, $j = 0; $i + 3 <= count($item['hour']); $i = $i + 3, $j++) {
                $arr[$j]['time'] = $item['hour'][$i]['time'];
                $arr[$j]['temp'] = $item['hour'][$i]['temp_c'];
                $arr[$j]['windSpeed'] = $item['hour'][$i]['wind_kph'];
                $arr[$j]['windDegree'] = $item['hour'][$i]['wind_degree'];
                $arr[$j]['visibility'] = $item['hour'][$i]['vis_km'];
                $arr[$j]['weatherDescription'] = $item['hour'][$i]['condition']['text'];
                $arr[$j]['feelslike'] = $item['hour'][$i]['feelslike_c'];
                $arr[$j]['cloud'] = $item['hour'][$i]['cloud'];
                $arr[$j]['pressure'] = $item['hour'][$i]['pressure_mb'];
            }
            $weather = new Weather($arr, $this->originalData);
            $weatherCollection->push($weather);

        }
        $this->weather = $weatherCollection;

    }


}
