<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSellBuyConfirmTbls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create("orders", function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('plant_id')->unsigned()->nullable();
            $table->enum('status', ['Open', 'Pending', 'Closed']);
            $table->decimal('amount', 10, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create("confirm_orders", function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sell_order_id')->unsigned();
            $table->integer('buy_order_id')->unsigned();
            $table->enum('status', ['Open', 'Pending', 'Closed', 'Success']);
            $table->json('remark');
            $table->softDeletes();
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
        Schema::drop('orders');
        Schema::drop('confirm_orders');
    }
}
