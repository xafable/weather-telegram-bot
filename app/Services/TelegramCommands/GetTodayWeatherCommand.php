<?php

namespace App\Services\TelegramCommands;

use App\Models\User;
use App\Weather\Services\WeatherClientInterface;
use Illuminate\Support\Facades\App;
use Telegram\Bot\Commands\Command;

class GetTodayWeatherCommand extends CommandBase
{
    protected string $name = 'weather_today';
    protected string $description = 'Start Command to get you started';


    public function handle()
    {

        if(!$this->user)
            $this->user = App::make(User::class);

        $userCity = $this->user->city;


        $weather = $this->weatherClient->loadWeather($userCity->lat,$userCity->lon);
        $todayWeather = $weather->getToday();

        /**
         * render view to html and send
         */
        $this->replyWithMessage([
            'parse_mode' =>'HTML',
            'text' => view('weatherMessage',['weather'=>$todayWeather])->render()
        ]);
    }

}
