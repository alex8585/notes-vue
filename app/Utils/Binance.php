<?php

namespace App\Utils;

use \ccxt\binance as BinanceApi;
use App\Models\Market;
use \Ratchet\Client as wsClient;

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

    public function streamSocket($endpoint, callable $callback)
    {
        wsClient\connect($endpoint)->then(function ($ws) use ($callback) {
            $ws->on('message', function ($data) use ($ws, $callback) {
                $json = json_decode($data);
                call_user_func($callback, $json);
            });
            $ws->on('close', function ($code = null, $reason = null) use ($callback) {
                echo "Connection closed ({$code} - {$reason})\n";

                //in 3 seconds the app will reconnect
                // $loop->addTimer(3, function () use ($connector, $loop, $app) {
                //     connectToServer($connector, $loop, $app);
                // });
            });
        }, function ($e) {
            echo "ticker: Could not connect: {$e->getMessage()}" . PHP_EOL;
        });
    }



    public function webSocketLoop($endpoint, callable $callback)
    {
        $client = new \WebSocket\Client($endpoint);
        while (true) {
            try {
                $data = $client->receive();
                $json = json_decode($data);
                call_user_func($callback, $json);
            } catch (\WebSocket\ConnectionException $e) {
                if ($e->getCode() != 1025) {
                    dump($e);
                }
            }
        }
        $client->close();
    }

    public function placeMarketOrder($symbol, $side, $amount, $params = [])
    {
        $type = 'MARKET';
        $params['type'] = 'future';
        return $this->create_order($symbol, $type, $side, $amount, null, $params);
    }
    public function cancelOrder($id, $symbol, $params = [])
    {
        $params['type'] = 'future';

        return $this->cancel_order($id, $symbol, $params);
    }
    public function placeLeverage($symbol, $leverage)
    {
        $symbolId = str_replace("/", "",  $symbol);
        return $this->setLeverage($symbolId, $leverage);
    }

    public function bookTickerConvert($obj)
    {

        if (!isset($obj)) {
            return null;
        }
        return [
            'id' => $obj->s,
            'bid' => $obj->b,
            'ask' => $obj->a,
        ];
    }

    public function httpRequest($urlPart, $apiVersion = 1, $method = 'GET', $params = [])
    {

        $typeStr = 'fapiPrivate';
        if ($apiVersion == '2') {
            $typeStr = 'fapiPrivateV2';
        }

        $singArr = $this->api->sign($urlPart, $typeStr, $method, $params);
        $url =  $singArr['url'];

        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $res = $client->request(
            $singArr['method'],
            $url,
            [
                'headers' => $singArr['headers']
            ]
        );

        $response =  json_decode($res->getBody());

        return $response;
    }

    // public function http_post($urlPart, $apiVersion = 1, $params = [])
    // {
    //     $typeStr = 'fapiPrivate';
    //     if ($apiVersion == '2') {
    //         $typeStr = 'fapiPrivateV2';
    //     }

    //     $singArr = $this->api->sign($urlPart, $typeStr, 'POST', $params);
    //     $url =  $singArr['url'];
    //     //dd($singArr);

    //     $client = new \GuzzleHttp\Client(['http_errors' => false]);
    //     $res = $client->request(
    //         $singArr['method'],
    //         $url,
    //         [
    //             'body' => $singArr['body'],
    //             'headers' => $singArr['headers']
    //         ]
    //     );

    //     $response =  json_decode($res->getBody());

    //     return $response;
    // }

    public function getLastPrice($params = [])
    {
        $response = $this->httpRequest('premiumIndex', 1, "GET", $params);
        return $response;
    }

    public function setLeverage($symbol, $leverage,  $params = [])
    {
        $params['symbol'] = $symbol;
        $params['leverage'] = $leverage;

        $response = $this->httpRequest('leverage', 1, 'POST', $params);
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



    public function fetchOpenOrders($symbol, $orderId)
    {
        $params['type'] = 'future';
        $params['symbol'] = $symbol;
        $params['orderId'] = $orderId;
        $response = $this->httpRequest('allOrders', 1, 'GET', $params);
        return $response;
    }
    public function fetch_open_orders($symbol = null, $since = null, $limit = null, $params = array())
    {
        $this->load_markets();
        $market = null;
        $query = null;
        $type = null;
        $request = array();
        if ($symbol !== null) {
            $market = $this->market($symbol);
            $request['symbol'] = $market['id'];
            $defaultType = $this->safe_string_2($this->options, 'fetchOpenOrders', 'defaultType', $market['type']);
            $type = $this->safe_string($params, 'type', $defaultType);
            $query = $this->omit($params, 'type');
        } else if ($this->options['warnOnFetchOpenOrdersWithoutSymbol']) {
            $symbols = $this->symbols;
            $numSymbols = is_array($symbols) ? count($symbols) : 0;
            $fetchOpenOrdersRateLimit = intval($numSymbols / 2);
            throw new ExchangeError($this->id . ' fetchOpenOrders WARNING => fetching open orders without specifying a $symbol is rate-limited to one call per ' . (string) $fetchOpenOrdersRateLimit . ' seconds. Do not call this $method frequently to avoid ban. Set ' . $this->id . '.options["warnOnFetchOpenOrdersWithoutSymbol"] = false to suppress this warning message.');
        } else {
            $defaultType = $this->safe_string_2($this->options, 'fetchOpenOrders', 'defaultType', 'spot');
            $type = $this->safe_string($params, 'type', $defaultType);
            $query = $this->omit($params, 'type');
        }
        $method = 'privateGetOpenOrders';
        if ($type === 'future') {
            $method = 'fapiPrivateGetOpenOrders';
        } else if ($type === 'delivery') {
            $method = 'dapiPrivateGetOpenOrders';
        } else if ($type === 'margin') {
            $method = 'sapiGetMarginOpenOrders';
        }

        $response = $this->$method(array_merge($request, $query));
        return $this->parse_orders($response, $market, $since, $limit);
    }
}
