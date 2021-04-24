<?php

namespace App\Providers;

use League\Glide\Server;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use \ccxt\binance as BinanceApi;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        JsonResource::withoutWrapping();
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BinanceApi::class, function ($app) {

            return new BinanceApi([
                'apiKey' => setting('binApiKey'),
                'secret' => setting('binApiSecret'),
                'enableRateLimit' => true,
            ]);
        });


        $this->app->bind(Server::class, function ($app) {
            return Server::create([
                'source' => Storage::getDriver(),
                'cache' => Storage::getDriver(),
                'cache_folder' => '.glide-cache',
                'base_url' => 'img',
            ]);
        });
    }
}
