<?php

namespace App\Console\Commands;

use App\Models\Order;

use App\Utils\Binance;
use App\Utils\TerminalCache;
use Illuminate\Console\Command;
use App\Events\TickerUpdateEvent;


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

    protected $activeOrders;
    protected $binance;
    protected $cache;
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
    public function handle(Binance $binance, TerminalCache $cache)
    {
        $this->binance = $binance;
        $this->cache = $cache;
        //$f = $cache->forgetActiveOrders();
        $this->activeOrders = $cache->getActiveOrders();
        $cnt = 0;

        $cb = function ($return) use ($binance, &$cnt, $cache) {
            $symbolArr = $binance->bookTickerConvert($return);
            if ($symbolArr) {
                broadcast(new TickerUpdateEvent($symbolArr));

                $symbolId = $symbolArr['id'];
                $cnt++;
                if ($cnt > 1000) {
                    $this->activeOrders = $cache->getActiveOrders();
                    $cnt = 0;
                }

                $symbolOrders = $this->filterOrdersBySymbol($symbolId);

                $this->checkOrders($symbolOrders, $symbolArr);
            }
        };

        $binance->webSocketLoop('wss://fstream.binance.com/ws/!bookTicker',  $cb);
    }


    public function filterOrdersBySymbol($symbolId)
    {
        return $this->activeOrders->filter(function ($order) use ($symbolId) {
            return $order->symbolId == $symbolId;
        });
    }

    public function removeOrderFromActiveOrders($removeOrder)
    {
        $this->activeOrders =  $this->activeOrders->filter(function ($order) use ($removeOrder) {
            return $order->id != $removeOrder->id;
        });
        dump($this->activeOrders);
    }

    public function checkOrders($orders, $symbolArr)
    {
        if ($orders->isEmpty()) {
            return;
        }

        $currentBid = $symbolArr['bid'];
        $currentAsk = $symbolArr['ask'];

        foreach ($orders as $order) {
            //$this->stopOrder($order);

            if ($order->side == "sell") {
                if ($order->stop1_price <= $currentBid) {
                    $this->stopOrder($order);
                }
            } else if ($order->side == "buy") {
                if ($order->stop1_price >= $currentAsk) {
                    $this->stopOrder($order);
                }
            }
        }
    }

    public function stopOrder($order)
    {
        //$o = $this->binance->fetchOpenOrders("ETHUSDT",'8389765495922411614');
        $symbol = $order->symbol;
        $side = ($order->side == "sell") ? "buy" : "sell";
        $amount = $order->amount;


        $binOrder =  $this->binance->placeMarketOrder($symbol, $side, $amount);
        if ($binOrder && isset($binOrder['average'])) {
            $closePrice = $binOrder['average'];
            $closeCost = $binOrder['cost'];
            if ($order->side == "sell") {
                $result = $order->cost -  $closeCost;
                dump($order->cost);
                dump($closeCost);
                dump($result);
                $result_percent = $this->calcPercents($order->price, $closePrice);
            } else if ($order->side == "buy") {
                $result =  $closePrice - $order->price;
                $result_percent = $this->calcPercents($closePrice, $order->price);
            }

            $order->fill([
                'sell_price' => $closePrice,
                'status' => $binOrder['status'],
                'result' =>  $result,
                'result_percent' => $result_percent,
            ]);

            $order->save();
            $this->cache->forgetActiveOrders();
            $this->removeOrderFromActiveOrders($order);
            dump(['order has been stopped', $order->id]);
        } else {
            dump(['error stopOrder ', $order]);
        }
    }

    public function calcPercents($a, $b)
    {
        return ($a - $b) / $b * 100;
    }
}
