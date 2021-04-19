<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Utils\Binance;
use Illuminate\Http\Request;
use App\Http\Requests\OrderCreateRequest;
use App\Models\Order;
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

    public function createOrder(OrderCreateRequest $request)
    {

        $data = $request->validated();
        //dd($data);
        Order::create($data);
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
}
