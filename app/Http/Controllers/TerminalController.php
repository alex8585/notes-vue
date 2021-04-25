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

        return inertia('Terminal/Index', ['markets' => $markets]);
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

        $params = ['newClientOrderId' => $order->id];
        $binOrder =  $binance->placeMarketOrder($symbol, $side, $amount, $params);
        if ($side == 'sell') {
            $stop1_price = $binOrder['price'] + $binOrder['price'] / 100 * $data['stop1'];
            $take_price = $binOrder['price'] - $binOrder['price'] / 100 * $data['take'];
        } else if ($side == 'buy') {
            $stop1_price = $binOrder['price'] + $binOrder['price'] / 100 * $data['stop1'];
            $take_price = $binOrder['price'] - $binOrder['price'] / 100 * $data['take'];
        }


        $order->fill([
            'binance_id' => $binOrder['id'],
            'amount' => $binOrder['amount'],
            'cost' => $binOrder['cost'],
            'price' => $binOrder['average'],
            'average' => $binOrder['average'],
            'status' => 'active',
            "stop1_price" => $stop1_price,
            "take_price" => $take_price,
        ]);
        $order->save();

        $r = $cache->forgetActiveOrders();

        dd($r);
        return back()
            ->with('success', 'The order has created.');
    }

    public function orders(HttpRequest $request)
    {
        $direction =  $request->direction ?? 'asc';
        $sort = $request->sort ?? 'symbol';
        $orders = Order::sort($sort, $direction)->paginate()->withQueryString();

        return inertia('Terminal/Orders', [
            'defaultDirection' => $direction,
            'items' => $orders
        ]);
    }
    public function settings()
    {
        return inertia('Terminal/Settings', [
            'binApiKey' => setting('binApiKey'),
            'binApiSecret' => setting('binApiSecret'),
        ]);
    }

    public function saveSettings(SaveSettingsRequest $request)
    {
        setting($request->validated())->save();
        return back()->with('success', 'Settings has been saved.');
    }
}
