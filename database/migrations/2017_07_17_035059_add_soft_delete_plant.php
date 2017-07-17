<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletePlant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("plant_transaction_statuses",function($table){
            $table->softDeletes();
        });
        Schema::table("plant_transactions",function($table){
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("plant_transaction_statuses",function($table){
            $table->dropSoftDeletes();
        });

        Schema::table("plant_transactions",function($table){
            $table->dropSoftDeletes();
        });
    }
}
