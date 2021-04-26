<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'created_at' => 'date:d-m-Y H:i',
        'updated_at' => 'date:d-m-Y H:i',
    ];

    public function scopeSort($query, $sort, $direction)
    {

        $direction = $direction ?? 'asc';
        $sort = $sort ?? 'id';

        if (!in_array($direction, ['asc', 'desc'])) {
            return $query;
        }

        $query->orderBy($sort, $direction);

        return $query;
    }

    public function getSymbolIdAttribute()
    {
        return str_replace("/", "",  $this->symbol);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? null, function ($query, $status) {
            //dd($status);
            return $query->where('status', $status);
        });
    }
    public function placeNewOrder($binOrder)
    {
        if ($this->side == 'sell') {
            $stop1_price = $binOrder['price'] + $binOrder['price'] / 100 * $this->stop1;
            $take_price = $binOrder['price'] - $binOrder['price'] / 100 * $this->take;
        } else if ($this->side == 'buy') {
            $stop1_price = $binOrder['price'] + $binOrder['price'] / 100 * $this->stop1;
            $take_price = $binOrder['price'] - $binOrder['price'] / 100 * $this->take;
        }


        $this->fill([
            'binance_id' => $binOrder['id'],
            'amount' => $binOrder['amount'],
            'cost' => $binOrder['cost'],
            'price' => $binOrder['average'],
            'average' => $binOrder['average'],
            'status' => 'active',
            "stop1_price" => $stop1_price,
            "take_price" => $take_price,
        ]);
        $this->save();
    }




    public function closeOrder($binOrder)
    {
        if (!isset($binOrder['average'])) {
            dump('error Order->closeOrder');
            return;
        }

        $closePrice = $binOrder['average'];
        $closeCost = $binOrder['cost'];
        if ($this->side == "sell") {
            $result = $this->cost -  $closeCost;
            $result_percent = $this->calcPercents($this->price, $closePrice);
        } else if ($this->side == "buy") {
            $result =  $closePrice - $this->price;
            $result_percent = $this->calcPercents($closePrice, $this->price);
        }

        $this->fill([
            'sell_price' => $closePrice,
            'status' => $binOrder['status'],
            'result' =>  $result,
            'result_percent' => $result_percent,
        ]);
        $this->save();
    }

    public function calcPercents($a, $b)
    {
        return ($a - $b) / $b * 100;
    }
}
