<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_booking', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('date_time');
            $table->int('number_of_guests');
            $table->boolean('acccepted')->default(false);
            $table->timestamps();

            $table->int('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->int('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('bookings');
        });

    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
