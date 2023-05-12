<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HttpClient
{

    /**
     * make get request.
     */
    function fetch($url): \Illuminate\Support\Collection
    {
        $response = Http::withOptions(['proxy'=>'proxy1.pgok.corp:8081'])
        ->get($url);

        return $response->collect();
    }

}
