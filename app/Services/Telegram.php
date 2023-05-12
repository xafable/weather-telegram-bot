<?php

namespace App\Services;

use App\Models\User;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class Telegram
{

    private Update $update;


    public function __construct(private readonly Api $telegram)
    {

    }


    /**
     * handle request from telegram
     */
    public function handle(): void
    {
        $this->update = $this->telegram->getWebhookUpdate();

        if ($this->update->isType('callback_query')) {
            $this->selectCallback();
        } elseif ($this->isBotCommand()) {
            \Telegram\Bot\Laravel\Facades\Telegram::commandsHandler(true);
        } else {
            $this->selectCommand();
        }


    }

    /**
     * get original instance of Telegram API
     */
    function getApiInstance(): Api
    {
        return $this->telegram;
    }

    /**
     * check is command
     */
    function isBotCommand(): bool
    {
        if (isset($this->update->message->entities[0]['type']))
            return $this->update->message->entities[0]['type'] == 'bot_command';
        else return false;
    }


    /**
     * select function for command from telegram request
     */
    function selectCommand(): void
    {
        if ($this->update->message->chat->type == 'private' && (User::find($this->update->getChat()->id)->first()->last_command == 'select_city' or User::find($this->update->getChat()->id)->first()->last_command == 'change_city'))
            \Telegram\Bot\Laravel\Facades\Telegram::triggerCommand('change_city', $this->update);

    }

    /**
     * select function for callback from telegram request
     */
    function selectCallback(): void
    {
        //if (Str::contains($this->update->callbackQuery->data, 'city_id'))
            \Telegram\Bot\Laravel\Facades\Telegram::triggerCommand('store_city', $this->update);
    }




}
