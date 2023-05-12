<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Support\Collection;

class GeoCoding
{

    public function __construct(private readonly HttpClient $httpClient)
    {

    }

    /**
     * get cities by user request,save to db and return search result.
     */
    function getCityByName(string $name) : Collection
    {
            $searchCities = $this->httpClient->fetch('https://api.openweathermap.org/geo/1.0/direct?q=' . $name . '&limit=5&appid=9ae4c75338e27265e071799534aa5ff6');
            $this->_saveCities($searchCities);

            return City::search($name)->get();

    }

    /**
     * save cities to db.
     */
    private function _saveCities(Collection $cities) : void
    {
        if (count($cities) == 1) {
            City::query()->insertOrIgnore(
                [
                    'title' =>  $cities[0]['name'] ?? '',
                    'title_ua' =>  $cities[0]['local_names']['uk'] ?? '',
                    'title_ru' =>  $cities[0]['local_names']['ru'] ?? '',
                    'title_en' =>  $cities[0]['local_names']['en'] ?? '',
                    'country' => $cities[0]['country'] ?? '',
                    'state' => $cities[0]['state'] ?? '',
                    'lon' => $cities[0]['lon'] ?? '',
                    'lat' => $cities[0]['lat'] ?? '',
                ]
            );

        } elseif (count($cities) > 1) {
            $data = [];
            foreach ($cities as $city){
                $data[] =   [
                    'title' =>  $city['name'] ?? '',
                    'title_ua' => $city['local_names']['uk'] ?? '',
                    'title_ru' => $city['local_names']['ru'] ?? '',
                    'title_en' => $city['local_names']['en'] ?? '',
                    'country' => $city['country'] ?? '',
                    'state' => $city['state'] ?? '',
                    'lat' => $city['lat'] ?? '',
                    'lon' => $city['lon'] ?? '',
                ];
            }

            City::query()->insertOrIgnore($data);

        }
    }

}
