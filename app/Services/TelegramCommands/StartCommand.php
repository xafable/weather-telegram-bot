<?php

namespace App\Services\TelegramCommands;

use App\Models\User;
use App\Services\Telegram;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Commands\Command;

class StartCommand extends CommandBase
{
    protected string $name = 'start';
    protected string $description = 'Start Command to get you started';



    public function handle()
    {

        //dd($this);
        $update = $this->getUpdate();
        //dd($update);


        if(isset($this->user))
            $this->replyWithMessage([
                'text' => 'Натисніть кнопку Menu щоб обрати необхідну функцюю.',
            ]);
        else {
            User::query()
                ->create([
                    'telegram_id'=>$update->message->from->id,
                ]);

            $this->triggerCommand('select_city');
        }


    }

}
