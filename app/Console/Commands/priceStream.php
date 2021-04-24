<?php

namespace App\Console\Commands;

use App\Utils\Binance;

use Illuminate\Console\Command;
use App\Events\TickerUpdateEvent;
use Lin\Binance\BinanceWebSocket;

class priceStream extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price_stream';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Binance $binance)
    {
        $cb = function ($return) use ($binance) {
            $symbol = $binance->bookTickerConvert($return);
            if ($symbol) {
                broadcast(new TickerUpdateEvent($symbol));
                //dump($symbol);
            }
        };
        // $binance->streamSocket('wss://fstream.binance.com/ws/!bookTicker',  $cb);
        $binance->webSocketLoop('wss://fstream.binance.com/ws/!bookTicker',  $cb);
    }
}
