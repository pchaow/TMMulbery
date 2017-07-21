<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();

            $table->string('identity')->unique()->nullable();
            $table->string('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->integer('province_id')->nullable()->unsigned();
            $table->integer('amphure_id')->nullable()->unsigned();
            $table->integer('district_id')->nullable()->unsigned();

            $table->json('profiles')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('province_id')->references('id')->on('provinces')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('amphure_id')->references('id')->on('amphures')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('districts')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
