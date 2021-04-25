<?php

namespace App\Utils;

use App\Models\Order;
use Illuminate\Support\Facades\Cache;

class TerminalCache
{
    // public function getBalances()
    // {
    //     Cache::forget('open_orders');
    //     return Cache::remember('balances2', 9999, function () {
    //         dump(['getBalances2']);
    //         return $this->getBinanceBalances();
    //     });
    // }

    public function forgetActiveOrders()
    {
        return Cache::forget('activeOrders');
    }

    public function getActiveOrders()
    {
        return Cache::remember('activeOrders', 200, function () {
            $orders =  Order::where('status', 'active')->get();
            return $orders;
        });
    }
}
