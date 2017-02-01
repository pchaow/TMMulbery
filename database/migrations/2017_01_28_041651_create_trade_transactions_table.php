<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_transactions', function (Blueprint $table) {
            $table->integer('id');
            $table->date('deal_date')->nullable();
            $table->double('amount')->nullable();;
            $table->double('pricerate')->nullable();;

            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('plant_id')->nullable()->unsigned();

            $table->timestamps();

            $table->foreign('plant_id')->references('id')->on('plants')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('trade_transactions');

    }
}
