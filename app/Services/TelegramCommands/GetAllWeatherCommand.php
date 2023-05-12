<?php

namespace App\Services\TelegramCommands;

use App\Models\User;
use App\Weather\Services\WeatherClientInterface;
use Telegram\Bot\Commands\Command;

class GetAllWeatherCommand extends CommandBase
{
    protected string $name = 'weather_all';
    protected string $description = 'Start Command to get you started';



    public function handle()
    {
        $userCity = $this->user->city;

        $weather = $this->weatherClient->loadWeather($userCity->lat,$userCity->lon);
        $allWeather = $weather->getAll();

        foreach ($allWeather as $w)

            /**
             * render view to html and send
             */
        $this->replyWithMessage([
            'parse_mode' =>'HTML',
            'text' => view('weatherMessage',['weather'=>$w])->render()
        ]);
    }

}
