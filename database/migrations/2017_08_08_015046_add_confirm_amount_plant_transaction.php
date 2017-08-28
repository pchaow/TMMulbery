<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfirmAmountPlantTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plant_transactions', function (Blueprint $table) {
            $table->decimal('confirm_amount', 10, 2)->nullable()->after('balance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plant_transactions', function (Blueprint $table) {
            $table->dropColumn('confirm_amount');
        });
    }
}
