<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Services\GeoCoding;
use App\Services\HttpClient;
use App\Services\Telegram;
use App\Services\TelegramCommands\GetTodayWeatherCommand;
use App\Weather\Services\Weatherapi;
use App\Weather\Services\WeatherClientInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram as Tele;
use Telegram\Bot\Traits\Http;

class TelegramController extends Controller
{
    function handle(Telegram $telegram)
    {
        $telegram->handle();

        return 200;
    }
}

