<?php

namespace App\Services\TelegramCommands;

use App\Models\User;
use App\Weather\Services\WeatherClientInterface;
use Telegram\Bot\Commands\Command;

class GetTomorrowWeatherCommand extends CommandBase
{
    protected string $name = 'weather_tomorrow';
    protected string $description = 'Start Command to get you started';


    public function handle()
    {
        $userCity = $this->user->city;

        $weather = $this->weatherClient->loadWeather($userCity->lat,$userCity->lon);
        $tomorrowWeather = $weather->getTomorrow();

        /**
         * render view to html and send
         */
        $this->replyWithMessage([
            'parse_mode' =>'HTML',
            'text' => view('weatherMessage',['weather'=>$tomorrowWeather])->render()
        ]);
    }

}
