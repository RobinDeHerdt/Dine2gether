<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->double('price');
            $table->datetime('date')->nullable();
            $table->string('street_number');
            $table->integer('postalcode');
            $table->string('city');
            $table->timestamps();

            $table->integer('host_id')->unsigned();
            $table->foreign('host_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        Schema::drop('dish_images');
        Schema::drop('dishes');
        Schema::drop('user_booking');
        Schema::dropIfExists('bookings');
    }
}
