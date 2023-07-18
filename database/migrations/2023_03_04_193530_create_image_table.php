<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->integer('meal_id')->unsigned();
            $table->integer('about_id')->unsigned();
            $table->foreign('about_id')->references('id')->on('about')->onDelete('cascade');
            $table->foreign('meal_id')->references('id')->on('meal')->onDelete('cascade');
            $table->integer('catagory_id')->unsigned();
            $table->foreign('catagory_id')->references('id')->on('catagory')->onDelete('cascade');
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
        Schema::dropIfExists('image');
    }
}
