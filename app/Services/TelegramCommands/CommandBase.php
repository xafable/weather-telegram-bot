<?php

namespace App\Services\TelegramCommands;

use App\Models\User;
use App\Services\Telegram;
use App\Weather\Services\WeatherClientInterface;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Commands\Command;

class CommandBase extends Command
{


    public function __construct(Telegram $telegram,protected ?User $user,protected WeatherClientInterface $weatherClient)
    {
        $this->telegram = $telegram->getApiInstance();
    }

    public function handle()
    {

    }

}
