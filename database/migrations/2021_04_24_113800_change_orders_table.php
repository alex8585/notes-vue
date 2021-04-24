<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // "id" => "8389765495860034969"
        // "clientOrderId" => "x-xcKtGhcu3ad2778b8e4a50dd7e2826"
        // "timestamp" => null
        // "datetime" => null
        // "lastTradeTimestamp" => null
        // "symbol" => "ETH/USDT"
        // "type" => "market"
        // "timeInForce" => "GTC"
        // "postOnly" => false
        // "side" => "sell"
        // "price" => 2212.76
        // "stopPrice" => 0.0
        // "amount" => 0.005
        // "cost" => 11.0638
        // "average" => 2212.76
        // "filled" => 0.005
        // "remaining" => 0.0
        // "status" => "closed"
        // "fee" => null
        // "trades" => []
        // "fees" => []

        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('direction', 'side');
            $table->renameColumn('quantity', 'amount');
            $table->bigInteger('binance_id')->nullable();
            $table->float('cost')->nullable();
            $table->float('price')->nullable();
            $table->float('average')->nullable();
            $table->float('sell_price')->nullable();
            $table->float('result')->nullable();
            $table->float('result_percent')->nullable();
            $table->float('leverage')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('binance_id', 'cost', 'price', 'average', 'sell_price', 'result', 'result_percent', 'leverage', 'status');
            $table->renameColumn('side', 'direction');
            $table->renameColumn('amount', 'quantity');
        });
    }
}
