<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Test;
use Inertia\Inertia;
use App\Models\Media;
use App\Utils\Binance;
use App\Models\Taggable;
use App\Models\Market;

class DashboardController extends Controller
{
    public function index(Binance $binance)
    {

        //$balances = $binance->fetch_balance();


        // $book = $binance->fetch_order_book('ETH/USDT');
        // $ticker = $binance->fetch_ticker('ETH/USDT');

        //$market = $binance->market('ETH/USDT');

        //['symbol' => 'ETH/USDT', 'leverage' => '125']
        //$r = $binance->sign('positionRisk', 'fapiPrivateV2');
        //$r =  $binance->http_get('leverageBracket', 1, []);


        $markets =  $binance->getMarketsWithLeverage();


        //dd($binance->describe());





        return Inertia::render('Dashboard/Index.vue', ['markets' => $markets]);
    }
}
