<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use App\Utils\Binance;
use App\Utils\TerminalCache;
use Illuminate\Http\Request;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\SaveSettingsRequest;
use Illuminate\Http\Request as HttpRequest;

class TerminalController extends Controller
{
    public function index(Binance $binance)
    {
        $markets =  $binance->getMarketsWithLeverage();

        return inertia('Admin/Terminal/Index', ['markets' => $markets]);
    }

    // public function getLastPrice(Binance $binance, $id)
    // {
    //     $symbol =  $binance->getSymbolByID($id)['symbol'] ?? null;
    //     $price = $binance->getLastPrice(['symbol' => $id]);
    //     $price->symbol =  $symbol;
    //     $price->id =  $id;
    //     return response()->json($price);
    // }


    public function createOrder(Binance $binance, OrderCreateRequest $request, TerminalCache $cache)
    {
        $data = $request->validated();

        $symbol = $data['symbol'];
        $side =  $data['side'];
        $amount = $data['quantity'] / $data['cur_price'];
        $leverage = $data['leverage'];

        $order = Order::create([
            'symbol' => $symbol,
            'leverage' => $leverage,
            'side' => $side,
            "stop1" => $data['stop1'],
            "take" => $data['take'],

        ]);

        $binance->placeLeverage($symbol, $leverage);
        $binOrder =  $binance->placeMarketOrder($symbol, $side, $amount);
        $order->placeNewOrder($binOrder);

        $r = $cache->forgetActiveOrders();

        dd($r);
        return back()
            ->with('success', 'The order has created.');
    }

    public function orders(HttpRequest $request)
    {

        $status = $request->status ?? 'active';
        $direction =  $request->direction ?? 'asc';
        $sort = $request->sort ?? 'symbol';
        $orders = Order::sort($sort, $direction)->filter(compact('status'))->paginate()->withQueryString();

        return inertia('Admin/Terminal/Orders', [
            'status' => $status,
            'defaultDirection' => $direction,
            'items' => $orders
        ]);
    }
    public function settings()
    {
        return inertia('Admin/Terminal/Settings', [
            'binApiKey' => setting('binApiKey'),
            'binApiSecret' => setting('binApiSecret'),
        ]);
    }

    public function saveSettings(SaveSettingsRequest $request)
    {
        setting($request->validated())->save();
        return back()->with('success', 'Settings has been saved.');
    }

    public function closeOrder(Order $order)
    {
        dd($order);
    }
}
