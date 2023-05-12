<?php

namespace App\Services\TelegramCommands;

use App\Models\City;
use App\Models\User;
use App\Services\GeoCoding;
use App\Services\Telegram;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class StoreCityCommand extends CommandBase
{

    protected string $name = 'store_city';
    protected string $description = 'Start Command to get you started';


    public function handle()
    {

        $this->user
             ->update([
                'city_id' => $this->update->callbackQuery->data
            ]);

        $this->replyWithMessage([
            'text' => 'Місто збережено. Ось погода на сьогодні.',
        ]);

        $this->triggerCommand('weather_today');


        $this->user
             ->update([
                'last_command' => $this->name
            ]);


    }
}
