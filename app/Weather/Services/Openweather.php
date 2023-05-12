<?php

namespace App\Weather\Services;

use App\Services\HttpClient;
use App\Weather\Weather;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Openweather extends WeatherClientBase implements WeatherClientInterface
{

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    function loadWeather($lat,$lon): WeatherClientInterface
    {

        $this->originalData = $this->httpClient->fetch('api.openweathermap.org/data/2.5/forecast?appid=9ae4c75338e27265e071799534aa5ff6&units=metric&lang=ua&lat='.$lat.'&lon='.$lon);

        $this->_createWeather($this->originalData);

        return $this;
    }



    /**
     * make Weather Collection from Weather Provider data
     */
    private function _createWeather($response): void
    {
        $weatherCollection = collect();
         foreach ($this->_groupArray($response['list']) as $day) {
            $arr = [];
            foreach ($day as $key=>$item){

                $arr[$key]['time'] = $item['dt_t'];
                $arr[$key]['temp'] = $item['main']['temp'];
                $arr[$key]['windSpeed'] = $item['wind']['speed'];
                $arr[$key]['windDegree'] = $item['wind']['deg'];
                $arr[$key]['visibility'] = $item['visibility'];
                $arr[$key]['weatherDescription'] = $item['weather'][0]['description'];
                $arr[$key]['feelslike'] = $item['main']['feels_like'];
                $arr[$key]['cloud'] = $item['clouds']['all'];
                $arr[$key]['pressure'] = $item['main']['pressure'];
            }
            $weather = new Weather($arr,$this->originalData);
            $weatherCollection->push($weather);

        }


        $this->weather = $weatherCollection;
    }

    /**
     * group weather data by days
     */
    private function _groupArray($array) : array{

        $mapped = Arr::map($array, function ($value) {
            $tmp = $value;
            $tmp['dt_t'] = $value['dt_txt'];
            $tmp['dt_txt'] = Str::of($value['dt_txt'])->substr(0, 10)->value();


            return $tmp;
        });

        $grouped = [];
        foreach($mapped as $val) {
            $grouped[$val['dt_txt']][] = $val;
        }

        return $grouped;
    }

}
