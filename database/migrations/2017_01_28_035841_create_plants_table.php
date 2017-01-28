<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->text('quality')->nullable();
            $table->json('map')->nullable();

            $table->double('area_sqm')->nullable();
            $table->double('row_spacing')->nullable();
            $table->double('plant_spacing')->nullable();

            $table->integer('province_id')->nullable();
            $table->integer('amphure_id')->nullable();
            $table->integer('district_id')->nullable();

            $table->integer('user_id');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plant_transaction_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('plant_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plant_id');
            $table->enum('type', ['+', '-']);
            $table->double('amount');
            $table->double('balance');
            $table->string('status_id');

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
        Schema::drop('plant_transaction_statuses');
        Schema::drop('plant_transactions');
        Schema::drop('plants');
    }
}
