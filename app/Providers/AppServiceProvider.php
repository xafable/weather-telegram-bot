<?php

namespace App\Providers;

use App\Models\User;
use App\Services\HttpClient;

use App\Services\Telegram;
use App\Weather\Services\Openweather;
use App\Weather\Services\Weatherapi;
use App\Weather\Services\WeatherClientInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Telegram\Bot\Api;
USe Telegram\Bot\Laravel\Facades\Telegram as Tele;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(WeatherClientInterface::class, function (Application $app) {
            if (env('WEATHER_CLIENT') == 'OPENWEATHER')
                return new Openweather($app->make(HttpClient::class));
            else
                return new Weatherapi($app->make(HttpClient::class));
        });


          $this->app->singleton(Telegram::class, function (Application $app) {
              return new Telegram(new Api(env('TELEGRAM_BOT_TOKEN', '6068693237:AAH1XNk_v_59e31GtIs3t4TbwlXOg36JxBo')));

          });

          $this->app->bind(User::class, function (Application $app) {
              $request = app(\Illuminate\Http\Request::class);
              $chatId = array_column($request->all(),'from')[0]['id'];

              return User::find($chatId)->get()->first();
          });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
