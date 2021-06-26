<?php

namespace App\Console\Commands;

use Steam;
use SteamApi\SteamApi;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class steamBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'steam_bot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command steam';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$a = config_path('steam-api.php');
        //dd($a);
        // $key = '45E5B2520A832EE353C6989C99AFE5EC';

        // $appId = 200710;
        // $steamId = '76561198843552052';
        // $p = Steam::item()->GetPlayerItems(570, $steamId);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {





        $api = new SteamApi();
        //$response = $api->getCurrencyList();
        // dd($response);
        // $options = [
        //     'start' => 0,
        //     'count' => 100,
        //     'query' => "AK-47 | Elite Build (Battle-Scarred)",
        //     'exact' => true,
        //     'currency'         => 18
        // ];

        $options = [
            'start' => 0,
            'count' => 30,
            'currency' => 18,
            'market_hash_name' => "AK-47 | Elite Build (Battle-Scarred)",
            'filter' => ''
        ];

        $resp = $api->getItemListings(730, $options);

        foreach ($resp['items'] as $item) {
            $options = [
                'inspect_link' => $item['inspectLink'],
                //'detailed'     => false,
            ];
            sleep(1);
            $respInfo = $api->inspectItemV2($options);
            $info =  $respInfo['iteminfo'];
            if ($info['stickers']) {
                dump($item['price_with_fee'], $info);
            }
        }



        //dd($r);
    }
}
