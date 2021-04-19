<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->string('direction');
            $table->float('quantity')->nullable();
            $table->float('stop1')->nullable();
            $table->float('stop1_price')->nullable();
            $table->float('take')->nullable();
            $table->float('take_price')->nullable();
            $table->float('stop2')->nullable();
            $table->float('stop2_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
