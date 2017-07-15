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

            $table->integer('province_id')->nullable()->unsigned();
            $table->integer('amphure_id')->nullable()->unsigned();
            $table->integer('district_id')->nullable()->unsigned();

            $table->integer('user_id')->nullable()->unsigned();

            $table->softDeletes();
            $table->timestamps();


            $table->foreign('province_id')->references('id')->on('provinces')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('amphure_id')->references('id')->on('amphures')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('districts')
                ->onUpdate('cascade')->onDelete('set null');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('set null');
        });

        Schema::create('plant_transaction_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('plant_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plant_id')->nullable()->unsigned();
            $table->enum('type', ['+', '-']);
            $table->double('amount');
            $table->double('balance');
            $table->integer('status_id')->nullable()->unsigned();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('plant_id')->references('id')->on('plants')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('status_id')->references('id')->on('plant_transaction_statuses')
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
        Schema::drop('plant_transactions');
        Schema::drop('plant_transaction_statuses');
        Schema::drop('plants');
    }
}
