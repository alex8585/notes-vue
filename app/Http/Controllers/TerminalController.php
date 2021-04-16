<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Utils\Binance;


class TerminalController extends Controller
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




        return inertia('Terminal/Index', ['markets' => $markets]);
    }

    public function getLastPrice(Binance $binance, $id)
    {

        //get-last-price/ETHUSDT
        $symbol =  $binance->getSymbolByID($id)['symbol'] ?? null;

        $price = $binance->getLastPrice(['symbol' => $id]);


        $price->symbol =  $symbol;
        $price->id =  $id;
        return response()->json($price);
        // return array($price);


        //dump($binance->markets);
        //dd($sumbol);
        //        
        //return $r;
    }
}
