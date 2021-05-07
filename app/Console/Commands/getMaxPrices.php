<?php

namespace App\Console\Commands;


use App\Models\Market;
use App\Utils\Binance;
use App\Models\MaxPrice;
use Illuminate\Console\Command;

class getMaxPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get_max_prices';

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


        $markets =    Market::all();;
        foreach ($markets as $m) {
            // dd($m);
            $symbol =  $m->symbol_id;
            $params = [
                'symbol' => $symbol,
                'interval' => '1M',
                'limit' => 6
            ];
            $markets = $binance->klines($params);
            $max = collect($markets)->max(2);


            MaxPrice::firstOrCreate(
                ['symbol' => $symbol],
                ['symbol' => $symbol, 'value' =>  $max]
            );
        }

        // $maxPrice->value = $max



        return 0;
    }
}
