<?php

namespace App\Console\Commands;

use App\Utils\Binance;
use App\Models\MaxPrice;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class checkUpdateMaximum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update_maximum';

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
        $maxPricees = MaxPrice::all();

        $updates = Telegram::getUpdates();

        $chat_id = end($updates)['message']['chat']['id'];


        $prices = $binance->getLastPrice();
        foreach ($prices as $p) {
            $symbol = $p->symbol;
            $markPrice = $p->markPrice;

            $index = $maxPricees->search(function ($item, $key) use ($symbol) {
                return $item->symbol == $symbol;
            });
            $maxPrice =  $maxPricees[$index];

            if ($markPrice > $maxPrice->value) {
                $msg = $symbol . ' = ' . $markPrice;
                Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => $msg
                ]);
                $maxPrice->value = $markPrice;
                $maxPrice->save();
                //dd('1');
            }
        }



        return 0;
    }
}
