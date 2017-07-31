<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("orders", function (Blueprint $table) {
            $table->decimal('amount_rai',10,2)->nullable()->before('duedate');
            $table->decimal('amount_kg',10,2)->nullable()->before('duedate');
            $table->dropColumn('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("orders", function (Blueprint $table) {
            $table->dropColumn('amount_rai');
            $table->dropColumn('amount_kg');
            $table->decimal('amount',10,2);
        });
    }
}
