<?php

namespace App\Services\TelegramCommands;

use App\Models\User;
use App\Services\Telegram;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Commands\Command;

class SelectCityCommand extends CommandBase
{
    protected string $name = 'select_city';
    protected string $description = 'Start Command to get you started';



    public function handle()
    {

        if(!$this->user)
            $this->user = App::make(User::class);

        $this->user
             ->update([
                'last_command'=>$this->name
            ]);

        $this->replyWithMessage([
            'text' => 'Введіть назву міста.',
        ]);
    }

}
