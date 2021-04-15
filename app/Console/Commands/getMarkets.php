<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Utils\Binance;
use App\Models\Market;

class getMarkets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get_markets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Binance $binance)
    {
        $markets = $binance->fetch_markets();
        $now = now();


        $leverageBracket = $binance->http_get('leverageBracket', 1,);
        $leverages = [];
        foreach ($leverageBracket as $l) {
            $leveragesElem = [];
            foreach ($l->brackets as $b) {
                $leveragesElem[] = $b->initialLeverage;
            }
            sort($leveragesElem);
            $leverages[$l->symbol] =  $leveragesElem;
        }




        $insertData = [];
        foreach ($markets as $m) {
            $insertData[] = [
                'symbol' => $m['symbol'],
                'data' => json_encode($m),
                'leverage' => json_encode($leverages[$m['id']]),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        //dd($insertData);

        Market::insert($insertData);

        return 0;
    }
}
