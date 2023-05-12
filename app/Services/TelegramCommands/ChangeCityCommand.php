<?php

namespace App\Services\TelegramCommands;

use App\Models\City;
use App\Models\User;
use App\Services\GeoCoding;
use App\Services\Telegram;
use App\Weather\Services\WeatherClientInterface;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class ChangeCityCommand extends CommandBase
{

    protected string $name = 'change_city';
    protected string $description = 'Start Command to get you started';

    public function __construct(Telegram $telegram,protected ?User $user,protected WeatherClientInterface $weatherClient, private readonly GeoCoding $geoCoding)
    {
        parent::__construct($telegram,$user,$weatherClient);
    }

    public function handle()
    {

        $cities = $this->geoCoding->getCityByName($this->update->message->text);

        if($cities->count() < 1)
        {
            $this->replyWithMessage([
                'text' => 'Місто не знайдено, спробуйте ввести назву міста повністю.',
            ]);
            die();
        }


        $keyboard = Keyboard::make()
            ->inline();

        foreach ($cities as $city) {
            $keyboard->row([Keyboard::inlineButton([
                 'text' => ($city->title ? $city->title.',' : '')
                 . ($city->state ? $city->state.',' : '')
                 . ($city->country ? $city->country : ''),
                 'callback_data' => $city->id])]);
        }


        $this->replyWithMessage([
            'text' => 'Оберіть місто:',
            'reply_markup' => $keyboard,
        ]);


        $this->user
             ->update([
                'last_command' => $this->name
            ]);

    }
}
