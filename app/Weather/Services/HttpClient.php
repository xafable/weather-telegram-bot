<?php

namespace App\Weather\Services;

use Illuminate\Support\Facades\Http;

class HttpClient
{

    function fetch($url): \Illuminate\Support\Collection
    {

        $response = Http::withOptions([ 'proxy' => 'http://pgok.corp:8081'])
                          ->get($url);

        return $response->collect();
    }

}
