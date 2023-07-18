<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderRemoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_remote', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_remote_id')->unsigned();
            $table->foreign('user_remote_id')->references('id')->on('user_remote');
            $table->integer('meal_id')->unsigned();
            $table->foreign('meal_id')->references('id')->on('meal');
            $table->integer('count');
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
        Schema::dropIfExists('order_remote');
    }
}
