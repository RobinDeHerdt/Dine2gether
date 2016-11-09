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
            $table->integer('max_guests');
            $table->string('telephone_number');
            $table->string('street_number');
            $table->integer('postalcode');
            $table->string('city');
            $table->timestamps();

            
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('booking_interest');
        Schema::dropIfExists('booking_kitchenstyle');
        Schema::dropIfExists('request_booking');
        Schema::drop('bookingdate_user');
        Schema::dropIfExists('bookingdates');
        Schema::drop('kitchenstyles');
        Schema::dropIfExists('bookings');
    }
}
