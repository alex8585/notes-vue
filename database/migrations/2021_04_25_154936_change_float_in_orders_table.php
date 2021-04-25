<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFloatInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */



    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->float('amount', 16, 8)->default(0)->change();
            $table->float('stop1', 16, 8)->default(0)->change();
            $table->float('stop1_price', 16, 8)->default(0)->change();
            $table->float('take', 16, 8)->default(0)->change();
            $table->float('take_price', 16, 8)->default(0)->change();
            $table->float('stop2', 16, 8)->default(0)->change();
            $table->float('stop2_price', 16, 8)->default(0)->change();
            $table->float('cost', 16, 8)->default(0)->change();
            $table->float('price', 16, 8)->default(0)->change();
            $table->float('average', 16, 8)->default(0)->change();
            $table->float('sell_price', 16, 8)->default(0)->change();
            $table->float('result', 16, 8)->default(0)->change();
            $table->float('result_percent', 16, 8)->default(0)->change();
            $table->float('leverage', 16, 8)->default(0)->change();
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
            $table->float('amount')->nullable()->change();
            $table->float('stop1')->nullable()->change();
            $table->float('stop1_price')->nullable()->change();
            $table->float('take')->nullable()->change();
            $table->float('take_price')->nullable()->change();
            $table->float('stop2')->nullable()->change();
            $table->float('stop2_price')->nullable()->change();
            $table->float('cost')->nullable()->change();
            $table->float('price')->nullable()->change();
            $table->float('average')->nullable()->change();
            $table->float('sell_price')->nullable()->change();
            $table->float('result')->nullable()->change();
            $table->float('result_percent')->nullable()->change();
            $table->float('leverage')->nullable()->change();
        });
    }
}
