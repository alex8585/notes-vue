<?php

namespace App\Utils;

use \ccxt\binance as BinanceApi;
use App\Models\Market;

class Binance
{
    public $api = null;
    public $params = null;
    public $leverage = [];
    public $symbols = [];
    public function __construct(BinanceApi $api)
    {
        $this->api = $api;
        $this->params = ['type' => 'future'];
        $this->setMarketsFromDb();
    }


    public function setMarketsFromDb()
    {
        $dbMarkets = Market::all();
        $markets = [];
        foreach ($dbMarkets->toArray() as $m) {
            $markets[] = json_decode($m['data'], true);
            $this->leverage[$m['symbol']] = json_decode($m['leverage'], true);
            $this->symbols[] = $m['symbol'];
        }
        $this->api->set_markets($markets);
    }

    public function getMarketsWithLeverage()
    {
        $returnArr = [];
        foreach ($this->markets as $m) {
            $returnArr[$m['symbol']] = $m;
            $returnArr[$m['symbol']]['leverage'] =  $this->leverage[$m['symbol']];
        }
        return $returnArr;
    }

    public function getSymbolByID($id)
    {
        return current(array_filter($this->markets, function ($element) use ($id) {
            return $element['id'] == $id;
        }));
    }

    public function http_get($urlPart, $apiVersion = 1, $params = [])
    {
        //$apiUrl = config('settings.binance.api_url');
        // $baseUrl = "{$apiUrl}v3/{$endpoint}";

        $typeStr = 'fapiPrivate';
        if ($apiVersion == '2') {
            $typeStr = 'fapiPrivateV2';
        }

        $singArr = $this->api->sign($urlPart, $typeStr, 'GET', $params);
        $url =  $singArr['url'];

        // $qs = http_build_query($params);
        // $url = "{$baseUrl}?{$qs}";
        // $signature = hash_hmac('sha256',  $qs, env('BIN_API_SECRET'));
        // $qs = http_build_query(array_merge($params, ['signature' => $signature]));
        // dd($qs);


        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $res = $client->request(
            'GET',
            $url,
            [
                'headers' => $singArr['headers']
            ]
        );

        $response =  json_decode($res->getBody());

        return $response;
    }

    public function getLastPrice($params = [])
    {

        $response = $this->http_get('premiumIndex', 1, $params);
        return $response;
    }


    public function getApi()
    {
        return $this->api;
    }

    public function fetch_markets($params = [])
    {
        $params = array_merge($this->params, $params);
        return $this->api->fetch_markets($params);
    }
    public function fetch_balance($params = [])
    {
        $params = array_merge($this->params, $params);
        return $this->api->fetch_balance($params);
    }

    public function __get($name)
    {
        return $this->api->{$name};
    }

    public function __call($function_name, $arguments)
    {
        return $this->api->{$function_name}(...$arguments);
    }
}
