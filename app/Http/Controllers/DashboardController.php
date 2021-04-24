<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Test;
use Inertia\Inertia;
use App\Models\Media;
use App\Models\Market;
use App\Utils\Binance;
use App\Models\Taggable;
use Illuminate\Support\Facades\Auth;
use anlutro\LaravelSettings\Facade as Setting;

class DashboardController extends Controller
{
    public function __construct()
    {

        // dd(Auth::user());
        // Setting::setExtraColumns(array(
        //     'user_id' => Auth::user()->id
        // ));
    }

    public function index(Binance $binance, Setting $s)
    {
        // Setting::setExtraColumns(array(
        //     'user_id' => Auth::user()->id
        // ));
        // dd(Auth::user());

        //setting(['a' => ['1', '2222', '3333']])->save();
        //dd(setting('a'));

        //$balances = $binance->fetch_balance();


        // $book = $binance->fetch_order_book('ETH/USDT');
        // $ticker = $binance->fetch_ticker('ETH/USDT');

        //$market = $binance->market('ETH/USDT');

        //['symbol' => 'ETH/USDT', 'leverage' => '125']
        //$r = $binance->sign('positionRisk', 'fapiPrivateV2');
        //$r =  $binance->http_get('leverageBracket', 1, []);


        //$markets =  $binance->getMarketsWithLeverage();


        //dd($binance->describe());





        return Inertia::render('Dashboard/Index.vue');
    }
}
