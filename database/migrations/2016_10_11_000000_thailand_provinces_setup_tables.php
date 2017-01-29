<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ThailandProvincesSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('name_eng');


        });

        Schema::create('amphures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('name_eng');
            $table->integer('province_id');

        });

        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('name_eng');
            $table->integer('province_id');
            $table->integer('amphure_id');

        });

//        Schema::table('amphures',function (Blueprint $table){
//            $table->foreign('province_id')->references('id')->on('provinces')
//                ->onUpdate('cascade')->onDelete('cascade');
//
//        });
//
//        Schema::table('districts',function (Blueprint $table){
//            $table->foreign('province_id')->references('id')->on('provinces')
//                ->onUpdate('cascade')->onDelete('cascade');
//            $table->foreign('amphure_id')->references('id')->on('amphures')
//                ->onUpdate('cascade')->onDelete('cascade');
//
//        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('districts');
        Schema::drop('amphures');
        Schema::drop('provinces');
    }
}
